<?php

return [
    'current_version' => 'v' . file_get_contents(base_path('version.txt')),
    'list' => [
        [
            'header' => '🎓🎓🎓 Moneypenny v1.0',
            'date' => '26-06-2025 01:32',
            'notes' => [
                'Bachelor version release',
            ],
            'tags' => ['major_version']
        ],
        [
            'header' => '🦅🦅🦅 Moneypenny v0.5',
            'date' => '19-06-2023 02:30',
            'notes' => [
                'File explorer interface for admin',
                'Log browser view for admin',
                'Deprecate analyzers logic',
                'Minor bugs fixes'
            ],
            'tags' => []
        ],
        [
            'header' => '🐛🫎🦋 Moneypenny v0.4.1',
            'date' => '15-06-2023 20:05',
            'notes' => [
                'Fixed api error handling bug at register',
                'Improved styling at some pages'
            ],
            'tags' => []
        ],
        [
            'header' => '🧑🏾‍🎨👨🏻‍🎨👩‍🎨 Moneypenny v0.4',
            'date' => '07-06-2023 22:22',
            'notes' => [
                'Add selecting avatars from gallery',
                'Add new data widgets at home view'
            ],
            'tags' => []
        ],
        [
            'header' => '🥳🥳🥳 Moneypenny v0.3',
            'date' => '06-06-2023 10:35',
            'notes' => [
                'Added analytics features',
                'Added transactions categorisations features',
                'Implemented beautiful ChartJS features in analytics views',
                'Added multiple new features in admin panel: promoting, blocking and deleting users',
                'Enhanced home page features',
                'Added icons and graphics for better UX',
                'Improved query times',
                'Fixed bugs'
            ],
            'tags' => []
        ],
        [
            'header' => '🐥🐥🐥 Moneypenny v0.2',
            'date' => '10-05-2023 22:15',
            'notes' => [
                'Code refactor',
                'Added users devices tracking',
            ],
            'tags' => []
        ],
        [
            'header' => '🐤🐤🐤 Moneypenny v0.1',
            'date' => '06-05-2023 00:15',
            'notes' => [
                'Init application'
            ],
            'tags' => []
        ]
    ]
];
