<?php
declare(strict_types=1);

namespace App\Service\Helpers;

class InsertHelper
{
    public static function insertAdminUser(): string
    {
        // ghbdtn пароль
        $password = '$2y$13$2kSlEOG8POghyHtQ2SuRXeMOcT3OK2F4R5QmXty3ZuGZFmAK4ptPG';
        $email = 'admin@admin.ru';
        $roles = json_encode(['ROLE_ADMIN']);

        return <<<EOF
        INSERT INTO "user" (id, email, roles, password) VALUES (1, '$email', '$roles', '$password');
        EOF;
    }

    public static function insertApplicationStatus(): string
    {
        return <<<EOF
        INSERT INTO "application_status" (id, name) VALUES
        (1, 'Новая'),
        (2, 'В работе'),
        (3, 'Решено');
        EOF;
    }
}