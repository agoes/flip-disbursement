<?php
namespace Flip\Disbursement;

class Statuses
{
    const NEW = 'NEW';                     // New disbursement created from client
    const NEW_RETRY = 'NEW_RETRY';         // Error on client side (request, network, etc .. ) after new
    const PENDING = 'PENDING';             // Proceed by Flip
    const PENDING_RETRY = 'PENDING_RETRY'; // Error on client side (request, network, etc .. ) after pending
    const SUCCESS = 'SUCCESS';             // SUCCESSS
}