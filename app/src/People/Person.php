<?php

namespace App\People;

use Ramsey\Uuid\UuidInterface;

class Person
{
    /**
     * @var UuidInterface
     */
    private $uuid;

    /**
     * @var string
     */
    private $name;

    private function __construct()
    {
    }

    public static function create(UuidInterface $uuid, string $name) : Person
    {
        $person = new self();
        $person->uuid = $uuid;
        $person->name = $name;
        $person->validate();

        return $person;
    }

    public function getUuid() : UuidInterface
    {
        return $this->uuid;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function validate()
    {
        if (empty($this->name)) {
            throw new \InvalidArgumentException('Name is required');
        }
    }
}
