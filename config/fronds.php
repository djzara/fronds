<?php
/**
 * User: zara
 * Date: 2019-02-24
 * Time: 15:49
 */
return [
    'form_submit' => [
        'to' => env('FORM_SUBMIT_TO', 'database'),

        'submission_modes' => [
            'database' => [
                'table' => 'submission_table',
                'connection' => 'default'
            ],
            'mail' => [
                'to' => env('FORM_SUBMIT_EMAIL_TO', 'admin'),
                'from' => env('FORM_SUBMIT_EMAIL_FROM', 'noreply'),
                'subject' => env('FORM_SUBMIT_EMAIL_SUBJECT', 'New Submission from %s')
            ],
            's3' => [
                'connection' => 'default',
                'access_key' => '',
                'secret_key' => '',
                'bucket_name' => ''
            ],
            'csv' => [
                'file_name' => '%s_submission.csv',
                'field_delim' => ',',
                'line_delim' => '\n'
            ]
        ]
    ]
];