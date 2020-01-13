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
    ],
    /*
     * Some security configurations will assume certain things, such as the email address to send
     * notifications to being the email address of the user to which they apply, as is the case
     * in login security emails.
     * Defaults are set to the recommended basic level security
     */
    'security' => [
        'authentication' => [
            // keep track of where the user logged in from relative to where they last logged in from
            'location_aware' => [
                'enabled' => env('LOCATION_AWARE', false),
                'email_verification' => env('LOCATION_AWARE_EMAIL_VERIFY', false)
            ],
            'login_scheme' => env('LOGIN_SCHEME', 'web')
        ],
        'require_https' => env('REQUIRE_HTTPS', true)
    ]
];
