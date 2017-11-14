<?php

namespace App\Entity;

use App\People\Person;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="person")
 */
class PersonEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="NONE")
     *
     * @var UuidInterface
     */
    private $uuid;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    public $name;

    public function toPerson() : Person
    {
        return Person::create($this->uuid, $this->name);
    }

    public static function fromPerson(Person $person)
    {
        $entity = new self();
        $entity->uuid = $person->getUuid();
        $entity->name = $person->getName();

        return $entity;
    }
}
