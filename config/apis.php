<?php
return [
    'flip' => [
        'base_url'          => env('FLIP_BASE_API_URL', 'https://nextar.flip.id'),
        'authentication'    => [
            'basic' => [
                'username' => env('FLIP_API_SECRET', 'HyzioY7LP6ZoO7nTYKbG8O4ISkyWnX1JvAEVAhtWKZumooCzqp41'),
                'password' => ''
            ]
        ]
    ]
];