<?php

namespace App\People\Repository;

use App\Entity\PersonEntity;
use App\People\Exception\PersonNotFoundException;
use App\People\Person;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

class DoctrinePeopleRepository implements PeopleRepository
{
    const ENTITY_CLASS = PersonEntity::class;

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findAll() : array
    {
        $people = $this->getEntityRepository()->findAll();

        return array_map(function (PersonEntity $entity) {
            return $entity->toPerson();
        }, $people);
    }

    public function find(UuidInterface $uuid) : Person
    {
        return $this->findEntity($uuid)->toPerson();
    }

    public function save(Person $person)
    {
        try {
            $entity = $this->findEntity($person->getUuid());
        } catch (PersonNotFoundException $e) {
            $entity = PersonEntity::fromPerson($person);
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function delete(UuidInterface $uuid)
    {
        $this->entityManager->remove($this->findEntity($uuid));
        $this->entityManager->flush();
    }

    private function findEntity(UuidInterface $uuid) : PersonEntity
    {
        if (null == ($entity = $this->getEntityRepository()->find((string) $uuid))) {
            throw new PersonNotFoundException();
        }

        return $entity;
    }

    private function getEntityRepository() : ObjectRepository
    {
        return $this->entityManager->getRepository(self::ENTITY_CLASS);
    }
}
