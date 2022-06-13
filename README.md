# Laravel employeeBirthday
Technical Assessment

## Installation

1. clone the repo and cd into it
1. `composer install`
1. rename or copy `.env.example` file to `.env` on root folder
5. Enter your email credentials in your `.env` file, edit the following
    `MAIL_MAILER=smtp`
    `MAIL_HOST=mailhog`
    `MAIL_PORT=1025`
    `MAIL_USERNAME=null`
    `MAIL_PASSWORD=null`
    `MAIL_ENCRYPTION=null`
5. `php artisan key:generate`
7. `php artisan serve`
8.  go to http://127.0.0.1:8000
