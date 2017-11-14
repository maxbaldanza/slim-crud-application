<?php

namespace spec\App\People\Repository;

use App\Entity\PersonEntity;
use App\People\Exception\PersonNotFoundException;
use App\People\Person;
use App\People\Repository\DoctrinePeopleRepository;
use App\People\Repository\PeopleRepository;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Ramsey\Uuid\Uuid;

class DoctrinePeopleRepositorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PeopleRepository::class);
    }

    function let(EntityManagerInterface $entityManager)
    {
        $this->beConstructedWith($entityManager);
    }

    function it_should_be_able_to_find_all_people(
        EntityManagerInterface $entityManager,
        ObjectRepository $repository,
        PersonEntity $entity,
        Person $person
    ) {
        $entityManager->getRepository(DoctrinePeopleRepository::ENTITY_CLASS)->willReturn($repository);
        $repository->findAll()->willReturn([$entity]);

        $entity->toPerson()->shouldBeCalled()->willReturn($person);

        $this->findAll()->shouldBe([$person]);
    }

    function it_should_be_able_to_find_a_single_person(
        EntityManagerInterface $entityManager,
        ObjectRepository $repository,
        PersonEntity $entity,
        Person $person,
        Uuid $uuid
    ) {
        $entityManager->getRepository(DoctrinePeopleRepository::ENTITY_CLASS)->willReturn($repository);
        $uuid->__toString()->willReturn('123');
        $repository->find($uuid)->willReturn($entity);

        $entity->toPerson()->shouldBeCalled()->willReturn($person);

        $this->find($uuid)->shouldBe($person);
    }

    function it_throws_an_exception_when_invalid_person(
        EntityManagerInterface $entityManager,
        ObjectRepository $repository,
        Uuid $uuid
    ) {
        $entityManager->getRepository(DoctrinePeopleRepository::ENTITY_CLASS)->willReturn($repository);
        $uuid->__toString()->willReturn('123');
        $repository->find($uuid)->willReturn(null);

        $this->shouldThrow(PersonNotFoundException::class)->during('find', [$uuid]);
    }

    function it_can_save_an_existing_person(
        EntityManagerInterface $entityManager,
        ObjectRepository $repository,
        PersonEntity $entity,
        Person $person,
        Uuid $uuid
    ) {
        $entityManager->getRepository(DoctrinePeopleRepository::ENTITY_CLASS)->willReturn($repository);
        $person->getUuid()->willReturn($uuid);
        $uuid->__toString()->willReturn('123');
        $repository->find($uuid)->willReturn($entity);

        $entityManager->persist($entity)->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();

        $this->save($person);
    }

    function it_can_create_a_new_person_when_saving(
        EntityManagerInterface $entityManager,
        ObjectRepository $repository,
        Person $person,
        Uuid $uuid
    ) {
        $name = 'Max';
        $entityManager->getRepository(DoctrinePeopleRepository::ENTITY_CLASS)->willReturn($repository);
        $person->getUuid()->willReturn($uuid);
        $person->getName()->willReturn($name);
        $uuid->__toString()->willReturn('123');
        $repository->find($uuid)->willReturn(null);

        $entityManager->persist(Argument::any())->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();

        $this->save($person);
    }

    function it_can_delete_a_person(
        EntityManagerInterface $entityManager,
        ObjectRepository $repository,
        PersonEntity $entity,
        Uuid $uuid
    ) {
        $entityManager->getRepository(DoctrinePeopleRepository::ENTITY_CLASS)->willReturn($repository);
        $uuid->__toString()->willReturn('123');
        $repository->find($uuid)->willReturn($entity);

        $entityManager->remove($entity)->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();

        $this->delete($uuid);
    }
}
