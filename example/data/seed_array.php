<?php
$data = [
    'level1' => [
        1 => [
            'value' => 'AG',
            'title' => 'AGRICULTURE, FORESTRY AND FISHING',
            'level2' => [
                1 => [
                    'value' => 'FRS',
                    'title' => 'Forestry and logging',
                    'level3' => [
                        1 => [
                            'value' => 'SILV',
                            'title' => 'Silviculture and other forestry activities'
                        ],
                        2 => [
                            'value' => 'MINI',
                            'title' => 'Mining of hard coal'
                        ]
                    ]
                ],
                2 => [
                    'value' => 'MNG',
                    'title' => 'Mining of coal and lignite'
                ]
            ]
        ],
        2 => [
            'value' => 'MI',
            'title' => 'MINING AND QUARRYING'
        ]
    ]
];

$data_alt_01 = [
    'level1' => [
        1 => ['value' => 'US', 'title' => 'United States'],
        2 => ['value' => 'UK', 'title' => 'United Kingdom']
    ]
];

$data_alt_02 = [
    'level1' => [
        1 => [
            'value' => 'PAR',
            'title' => 'Partnerships',
            'level2' => [
                1 => [
                    'value' => 'LLP',
                    'title' => 'Limited liability partnership'
                ],
                2 => [
                    'value' => 'LP',
                    'title' => 'Limited partnership'
                ]
            ]
        ],
        2 => [
            'value' => 'COM',
            'title' => 'Companies',
            'level2' => [
                1 => [
                    'value' => 'LTD',
                    'title' => 'Private company limited'
                ],
                2 => [
                    'value' => 'PLC',
                    'title' => 'Public limited company'
                ]
            ]
        ]
    ]
];
