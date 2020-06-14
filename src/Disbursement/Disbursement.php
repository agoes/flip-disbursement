<?php
namespace Flip\Disbursement;

use Flip\Database\Database;
use Flip\Http\Request\Request;

class Disbursement
{
    const DEFAULT_REMARK = 'Disbursement';

    public function __construct(Database $db, Request $httpClient, int $limit)
    {
        $this->db = $db;
        $this->httpClient = $httpClient;
        $this->limit = $limit;
    }

    public function disburse(
        string $bankCode,
        string $accountNumber,
        string $amount,
        string $remark = self::DEFAULT_REMARK 
    ) {
        return $this->httpClient->post('/disburse', [
            'bank_code'         => $bankCode,
            'account_number'    => $accountNumber,
            'amount'            => $amount,
            'remark'            => $remark
        ]);
    }

    public function checkDisbursementStatus($vendorDisbursementId)
    {
        return $this->httpClient->get('/disburse/' . $vendorDisbursementId);
    }

    public function updateDisbursement(
        int $id,
        $vendorDisbursementId,
        $status,
        $receipt,
        $timeServed
    ) {
        $this->db->raw('UPDATE `disbursements` SET
            `vendor_disbursement_id` = ?,
            `status` = ?,
            `receipt` = ?,
            `time_served` = ?
        WHERE
            `id` = ?
        ;', [$vendorDisbursementId, $status, $receipt, $timeServed, $id]);
    }

    public function disburseAll() : void
    {
        $newDisbursements = $this->filterByStatus(Statuses::NEW, $this->limit)->fetchAll();
        if ($newDisbursements) {
            foreach($newDisbursements as $disbursement) {
                $response = $this->disburse(
                    $disbursement['bank_code'],
                    $disbursement['bank_account_number'],
                    $disbursement['amount'],
                );

                if (!$this->isDisbursementFailed($disbursement)) {
                    $this->updateDisbursement(
                        $disbursement['id'],
                        $response->id,
                        $response->status,
                        $response->receipt,
                        $response->time_served
                    );
                } else {
                    $this->statusUpdate($id, Statuses::NEW_RETRY);
                }
            }
        }
    }

    public function checkAndUpdatePending() : void
    {
        $disbursements = $this->filterByStatus(Statuses::PENDING, $this->limit)->fetchAll();
        if ($disbursements) {
            foreach($disbursements as $disbursement) {
                $response = $this->checkDisbursementStatus($disbursement['vendor_disbursement_id']);

                if (!$this->isDisbursementFailed($disbursement)) {
                    $this->statusUpdate($disbursement['id'], $response->status);
                }
            }
        }
    }

    public function markForRetry($id) : void
    {
    }

    public function markAsSuccess($id) : void
    {
        $this->statusUpdate($id, Statuses::SUCCESS);
    }

    private function isDisbursementFailed($disbursement) : bool
    {
        return isset($disbursement->errors);
    }

    private function filterByStatus(string $status)
    {
        return $this->db->raw('SELECT * FROM `disbursements` WHERE `status` = ? ORDER BY `created_at` ASC LIMIT ' . $this->limit, [$status]);
    }

    public function statusUpdate($id, $status) : void
    {
        $this->db->raw('UPDATE `disbursements` SET
            `status` = ?
        WHERE
            `id` = ' . $id . '
        ;', [$status]);
    }
}