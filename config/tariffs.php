<?php

#########################################################################################
return [
    'STANDARD' => [
        'level' => 1,
        'name' => 'STANDARD',
        'prefix' => 'ST',
        'logo' => '<span style="border:1px solid #333333; padding: 3px; border-radius: 5px!important;"><b>БАЗОВЫЙ ТАРИФ</b></span>',
        'emblem' => '<span style="border:1px solid #333333; padding: 5px;  border-radius: 5px!important;"><b>БАЗОВЫЙ ТАРИФ</b></span>',
        'color1' => "#000000",
        'cards_gifts1' => 0,
        'cards_gifts2' => 0,
        'tsp_license' => 0,
        'paymentDescription' => 'Оплата за урок, тариф "Стандартный"',
        'payouts' => [
            ['to' => 'directory_firm', 'price' => 300, 'description' => 'Арендная плата за занятие'],
            [
                'to' => 'directory_person',
                'next_limit_orderers' => 9,
                'price' => [
                    'junior' => [1 => 450, 9 => 600],
                    'senior' => [1 => 850, 9 => 1000],
                    'lead' => [1 => 1400, 9 => 1600],
                ],
                'description' => 'Отчисления за занятие'
            ],
        ],
        'price' => [
            'junior' => [
                [
                    'key' => 1,
                    'price' => 1700,
                ],
                [
                    'key' => 8,
                    'price' => 12400,
                ],
            ],
            'senior' => [
                [
                    'key' => 1,
                    'price' => 2300,
                ],
                [
                    'key' => 8,
                    'price' => 14800,
                ],
            ],
            'lead' => [
                [
                    'key' => 1,
                    'price' => 3500,
                ],
                [
                    'key' => 8,
                    'price' => 22400,
                ],
            ],
        ]
    ],

    'HOME' => [
        'level' => 1,
        'name' => 'HOME',
        'prefix' => 'HM',
        'logo' => '<span style="border:1px solid #333333; padding: 3px; border-radius: 5px!important;"><b>БАЗОВЫЙ ТАРИФ</b></span>',
        'emblem' => '<span style="border:1px solid #333333; padding: 5px;  border-radius: 5px!important;"><b>БАЗОВЫЙ ТАРИФ</b></span>',
        'color1' => "#000000",
        'cards_gifts1' => 0,
        'cards_gifts2' => 0,
        'tsp_license' => 0,
        'paymentDescription' => 'Оплата за урок, обучение дома',
        'payouts' => [
            [
                'to' => 'directory_person',
                'next_limit_orderers' => 9,
                'price' => [
                    'junior' => [1 => 600, 9 => 800],
                    'senior' => [1 => 1100, 9 => 1200],
                    'lead' => [1 => 1500, 9 => 1700],
                ],
                'description' => 'Отчисления за занятие'
            ],
        ],
        'price' => [
            'junior' => [
                [
                    'key' => 1,
                    'price' => 1700,
                ],
                [
                    'key' => 8,
                    'price' => 11600,
                ],
                [
                    'key' => 16,
                    'price' => 21600,
                ],
            ],
            'senior' => [
                [
                    'key' => 1,
                    'price' => 2300,
                ],
                [
                    'key' => 8,
                    'price' => 14800,
                ],
                [
                    'key' => 16,
                    'price' => 25600,
                ],
            ],
            'lead' => [
                [
                    'key' => 1,
                    'price' => 3500,
                ],
                [
                    'key' => 8,
                    'price' => 22400,
                ],
                [
                    'key' => 16,
                    'price' => 38400,
                ],
            ],
        ],
    ],

    'SKYPE' => [
        'level' => 1,
        'name' => 'SP',
        'prefix' => 'ST',
        'logo' => '<span style="border:1px solid #333333; padding: 3px; border-radius: 5px!important;"><b>БАЗОВЫЙ ТАРИФ</b></span>',
        'emblem' => '<span style="border:1px solid #333333; padding: 5px;  border-radius: 5px!important;"><b>БАЗОВЫЙ ТАРИФ</b></span>',
        'color1' => "#000000",
        'cards_gifts1' => 0,
        'cards_gifts2' => 0,
        'tsp_license' => 0,
        'paymentDescription' => 'Оплата за урок, обучение в формате видео-конференции',
        'payouts' => [
            ['to' => 'directory_person', 'price' => 600, 'new_price' => 550, 'description' => 'Отчисления за занятие', 'next_limit_orderers' => null ],
        ],
        'price' => [
            'junior' => [
                [
                    'key' => 1,
                    'price' => 1200,
                ],
                [
                    'key' => 8,
                    'price' => 8000,
                ],
                [
                    'key' => 16,
                    'price' => 13600,
                ],
            ],
            'senior' => [
                [
                    'key' => 1,
                    'price' => 1200,
                ],
                [
                    'key' => 8,
                    'price' => 8000,
                ],
                [
                    'key' => 16,
                    'price' => 13600,
                ],
            ],
            'lead' => [
                [
                    'key' => 1,
                    'price' => 1200,
                ],
                [
                    'key' => 8,
                    'price' => 8000,
                ],
                [
                    'key' => 16,
                    'price' => 13600,
                ],
            ],
        ],
    ],
];
