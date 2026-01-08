<?php
// includes/users.php
declare(strict_types=1);

/*
Cấu trúc:
username => [
    'hash' => mật khẩu đã mã hoá,
    'role' => admin | user
]
*/

$users = [
    'admin' => [
        // mật khẩu: 123
        'hash' => password_hash('123', PASSWORD_DEFAULT),
        'role' => 'admin'
    ],

    'student' => [
        // mật khẩu: 123
        'hash' => password_hash('123', PASSWORD_DEFAULT),
        'role' => 'user'
    ],

    'manhdung' => [
        // mật khẩu: 123
        'hash' => password_hash('123', PASSWORD_DEFAULT),
        'role' => 'user'
    ]
];
