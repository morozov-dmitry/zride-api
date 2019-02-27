<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param int $id
     *
     * @return \App\Entity\User|null
     */
    public function findOne(int $id): ?User
    {
        return $this->findOneBy([
            'id' => $id,
            'removedAt' => null,
        ]);
    }

    /**
     * @param string $email
     *
     * @return \App\Entity\User|null
     */
    public function findOneByEmail(string $email): ?User
    {
        return $this->findOneBy([
            'email' => $email,
            'removedAt' => null,
        ]);
    }

    /**
     * @param string $login
     *
     * @return \App\Entity\User|null
     */
    public function findOneByLogin(string $login): ?User
    {
        return $this->findOneBy([
            'login' => $login,
            'removedAt' => null,
        ]);
    }

    /**
     * @param \App\Entity\User $user
     *
     * @return array
     */
    public function transform(User $user): array
    {
        return [
            'id' => $user->getId(),
            'login' => $user->getLogin(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'phone' => $user->getPhone(),
            'skype' => $user->getSkype(),
            'createdAt' => $user->getCreatedAt(),
        ];
    }
}
