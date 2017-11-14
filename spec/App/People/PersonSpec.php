<?php

namespace spec\App\People;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Ramsey\Uuid\UuidInterface;

class PersonSpec extends ObjectBehavior
{
    function it_exposes_its_values(UuidInterface $uuid)
    {
        $name = 'Max';
        $this->beConstructedThrough('create', [$uuid, $name]);

        $this->getUuid()->shouldBe($uuid);
        $this->getName()->shouldBe($name);
    }

    function it_should_validate_on_construction(UuidInterface $uuid)
    {
        $name = '';

        $this->beConstructedThrough('create', [$uuid, $name]);
        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }
}
