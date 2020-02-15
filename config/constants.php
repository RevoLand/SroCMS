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
            'job' => '8',
            'earring' => '9',
            'necklace' => '10',
            'lring' => '11',
            'rring' => '12',
        ],
    ],
    'item' => [
        'rarity' => [
            '0' => 'Normal',
            '1' => 'Seal of Nova',
            '2' => 'Seal of Moon',
            '3' => 'Seal of Sun',
        ],
        'country' => [
            '0' => 'Chinese',
            '1' => 'Europe',
        ],
        'white_stats' => [
            'param_names' => [
                'weapon' => ['Durability', 'PhyReinforce', 'MagReinforce', 'HitRatio', 'PhyAttack', 'MagAttack', 'CriticalRatio'], // 7
                'equipment' => ['Durability', 'PhyReinforce', 'MagReinforce', 'PhyDefense', 'MagDefense', 'ParryRatio'], // 6
                'shield' => ['Durability', 'PhyReinforce', 'MagReinforce', 'BlockRatio', 'PhyDefense', 'MagDefense'], // 6
                'accessory' => ['PhyAbsorb', 'MagAbsorb'], // 2
            ],
        ],
        'typeid' => [
            '1' => [
                'name' => 'Garment',
                '1' => 'Head',
                '2' => 'Shoulder',
                '3' => 'Body',
                '4' => 'Leg',
                '5' => 'Arm',
                '6' => 'Foot',
            ],
            '2' => [
                'name' => 'Protector',
                '1' => 'Head',
                '2' => 'Shoulder',
                '3' => 'Body',
                '4' => 'Leg',
                '5' => 'Arm',
                '6' => 'Foot',
            ],
            '3' => [
                'name' => 'Armor',
                '1' => 'Head',
                '2' => 'Shoulder',
                '3' => 'Body',
                '4' => 'Leg',
                '5' => 'Arm',
                '6' => 'Foot',
            ],
            '4' => [
                'name' => 'Shield',
                '1' => 'Chinese',
                '2' => 'European',
            ],
            '5' => [
                'name' => 'Accessory',
                '1' => 'Earring',
                '2' => 'Necklace',
                '3' => 'Ring',
            ],
            '6' => [
                'name' => 'Weapon',
                '1' => 'Unknown',
                '2' => 'Sword',
                '3' => 'Blade',
                '4' => 'Spear',
                '5' => 'Glavie',
                '6' => 'Bow',
                '7' => 'One-handed Sword',
                '8' => 'Two-handed Sword',
                '9' => 'Axe',
                '10' => 'Dark Staff',
                '11' => 'Staff',
                '12' => 'Crossbow',
                '13' => 'Dagger',
                '14' => 'Harp',
                '15' => 'Cleric Rod',
                '16' => 'Fortress Hammer',
            ],
            '7' => [
                'name' => 'Trade Item',
                '1' => 'Trader',
                '2' => 'Thief',
                '3' => 'Hunter',
            ],
            '9' => [
                'name' => 'Robe',
                '1' => 'Head',
                '2' => 'Shoulder',
                '3' => 'Body',
                '4' => 'Leg',
                '5' => 'Arm',
                '6' => 'Foot',
            ],
            '10' => [
                'name' => 'Light Armor',
                '1' => 'Head',
                '2' => 'Shoulder',
                '3' => 'Body',
                '4' => 'Leg',
                '5' => 'Arm',
                '6' => 'Foot',
            ],
            '11' => [
                'name' => 'Heavy Armor',
                '1' => 'Head',
                '2' => 'Shoulder',
                '3' => 'Body',
                '4' => 'Leg',
                '5' => 'Arm',
                '6' => 'Foot',
            ],
            '12' => [
                'name' => 'Accessory',
                '1' => 'Earring',
                '2' => 'Necklace',
                '3' => 'Ring',
            ],
            '13' => [
                'name' => 'Avatar',
                '1' => 'Hat',
                '2' => 'Body',
                '3' => 'Attachment',
            ],
            '14' => [
                'name' => 'Devil Spirit',
                '1' => 'Devil Spirit',
            ],
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
    'guild' => [
        'permission' => [
            'all' => -1,
            'join' => 1,
            'withdraw' => 2,
            'union' => 4,
            'storage' => 8,
            'notice' => 16,
        ],
        'siege' => [
            '1' => 'Commander',
            '2' => 'Deputy Commander',
            '4' => 'Fortress War Administrator',
            '8' => 'Production Administrator',
            '16' => 'Training Administrator',
            '32' => 'Military Engineer',
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
