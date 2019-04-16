<?php
namespace App\Components\Password;

class PasswordEncoder
{
    /**
     * @param string $password
     * @return string
     */
    public function encodePassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}