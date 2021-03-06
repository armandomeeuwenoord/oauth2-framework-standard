<?php

declare(strict_types=1);

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2017 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace AppBundle\Listener;

use OAuth2Framework\Component\Server\Event\Client\ClientDeletedEvent;

final class ClientDeletedListener
{
    /**
     * @var ClientDeletedEvent[]
     */
    private $events = [];

    /**
     * @param ClientDeletedEvent $event
     */
    public function handle(ClientDeletedEvent $event)
    {
        $this->events[] = $event;
    }

    /**
     * @return ClientDeletedEvent[]
     */
    public function getEvents()
    {
        return $this->events;
    }
}
