<?php
return [
    'flip' => [
        'base_url'          => env('FLIP_BASE_API_URL', 'https://nextar.flip.id'),
        'authentication'    => [
            'basic' => [
                'username' => env('FLIP_API_SECRET'),
                'password' => ''
            ]
        ]
    ]
];