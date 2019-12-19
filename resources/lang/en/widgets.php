<?php

return [
    'action' => [
        'panels' => [
            'menus' => [
                'title' => 'Manage Menus'
            ],
            'pages' => [
                'title' => 'Manage Pages',
                'responses' => [
                    'add' => 'New page added successfully',
                    'edit' => 'Page edited successfully'
                ],
                'validation' => [
                    'slug' => [
                        'slug' => 'Invalid slug format'
                    ]
                ]
            ],
            'theme' => [
                'title' => 'Manage Themes'
            ],
            'images' => [
                'title' => 'Manage Images'
            ],
            'content' => [
                'title' => 'Manage Content'
            ]
        ]
    ]
];
