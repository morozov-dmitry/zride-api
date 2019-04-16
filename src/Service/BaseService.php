<?php
namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;

class BaseService
{
    protected $em;

    protected $entity;

    /**
     * UserService constructor.
     * @param \Doctrine\ORM\EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param \Doctrine\ORM\Mapping\Entity $entity
     * @return void
     */
    protected function persistRecord($entity): void
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    /**
     * @param \Doctrine\ORM\Mapping\Entity $entity
     * @return void
     */
    protected function flushRecord($entity): void
    {
        $this->em->remove($entity);
        $this->em->flush();
    }

    /**
     * @param $entity
     * @throws \Exception
     * @return void
     */
    protected function softDeleteRecord($entity): void
    {
        if (!method_exists($entity, 'setRemovedAt')) {
            throw new \Exception('Soft delete is not supported for ' . get_class($entity));
        }
        $entity->setRemovedAt(new \DateTime());
        $this->persistRecord($entity);
    }
}