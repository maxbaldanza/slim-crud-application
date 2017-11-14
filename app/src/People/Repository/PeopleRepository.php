<?php

namespace App\People\Repository;

use App\People\Person;
use Ramsey\Uuid\UuidInterface;

interface PeopleRepository
{
    public function findAll();

    public function find(UuidInterface $uuid);

    public function save(Person $person);

    public function delete(UuidInterface $uuid);
}
