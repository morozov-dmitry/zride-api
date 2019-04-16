<?php
namespace App\Service;

use App\Entity\User;
use App\Components\Password\PasswordEncoder;
use Doctrine\ORM\EntityManagerInterface;

class UserService extends AbstractService
{
    /**
     * @param \App\Entity\User $user
     * @param \App\Components\Password\PasswordEncoder $passwordEncoder
     * @return \App\Entity\User
     */
    public function saveUser(User $user, PasswordEncoder $passwordEncoder)
    {
        $encodedPassword = $passwordEncoder->encodePassword($user->getPassword());
        $user->setPassword($encodedPassword);

        $this->persistRecord($user);

        return $user;
    }

    /**
     * @param \App\Entity\User $user
     * @throws \Exception
     * @return void
     */
    public function deleteUser(User $user): void
    {
        $this->softDeleteRecord($user);
    }
}