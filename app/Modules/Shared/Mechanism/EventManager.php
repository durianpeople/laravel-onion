<?php


namespace App\Modules\Shared\Mechanism;

/**
 * Application event manager.
 * @package App\Modules\Shared\Mechanism
 */
class EventManager
{
    /**
     * Directly publish domain event.
     * @param $event
     */
    public static function publish($event)
    {
        event($event);
    }
}