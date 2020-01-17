<?php

return [
    'payment_types' => [
        'balance' => '1',
        'balance_point' => '2',
        'silk' => '3',
        'silk_gift' => '4',
        'silk_point' => '5',
        'item' => 6,
    ],
    'silk' => [
        'type' => [
            'name' => [
                '0' => 'silk_own',
                '1' => 'silk_gift',
                '2' => 'silk_point',
            ],
            'id' => [
                'silk_own' => '0',
                'silk_gift' => '1',
                'silk_point' => '2',
            ],
        ],
        'reason' => [
            'inc' => [
                'silk_own' => '0',
                'silk_gift' => '2',
                'silk_point' => '4',
            ],
            'dec' => [
                'silk_own' => '1',
                'silk_gift' => '3',
                'silk_point' => '5',
            ],
        ],
    ],
    'balance' => [
        'source' => [
            'admin' => '0',
            'deposit' => '1',
            'epin' => '2',
            'itemmall' => '3',
            'vote' => '4',
            'sent_to_user' => '5',
            'sent_by_user' => '6',
        ],
        'source_desc' => [
            '0' => 'Yönetici tarafından verildi',
            '1' => 'Bakiye yüklemesi',
            '2' => 'E-Pin',
            '3' => 'Item Mall',
            '4' => 'Vote Sistemi',
            '5' => 'Kullanıcıya gönderildi',
            '6' => 'Kullanıcı gönderdi',
        ],
        'type' => [
            'balance' => 'balance',
            'point' => 'balance_point',
        ],
        'type_by_id' => [
            '1' => 'Bakiye',
            '2' => 'Bakiye (Puan)',
        ],
        'log_type' => [
            'balance' => '1',
            'balance_point' => '2',
        ],
    ],
    'inventory' => [
        'slots' => [
            'helm' => '0',
            'chest' => '1',
            'shoulders' => '2',
            'gauntlet' => '3',
            'pants' => '4',
            'boots' => '5',
            'weapon' => '6',
            'shield' => '7',

            'earring' => '9',
            'necklace' => '10',
            'lring' => '11',
            'rring' => '12',
        ],
    ],
    'skill' => [
    ],
    'skillmastery' => [
        'names' => [
            // MasteryID => Name
            '257' => 'Blade',
            '258' => 'Glavie',
            '259' => 'Bow',
            '273' => 'Cold',
            '274' => 'Lightning',
            '275' => 'Fire',
            '276' => 'Force',

            '513' => 'Warrior',
            '514' => 'Warlock',
            '515' => 'Rogue',
            '516' => 'Wizard',
            '517' => 'Bard',
            '518' => 'Cleric',
        ],
    ],
    'siege' => [
        'names' => [
            // SiegeID => Name
            '1' => 'Jangan',
            '3' => 'Hotan',
            '4' => 'Constantinople',
            '6' => 'Bandit',
        ],
    ],
];
