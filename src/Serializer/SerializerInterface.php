<?php

declare(strict_types=1);

namespace CalendarBundle\Serializer;

use CalendarBundle\Entity\Event;

interface SerializerInterface1
{
    /**
     * @param Event[] $events
     *
     * @return string json
     */
    public function serialize(array $events): string;
}
