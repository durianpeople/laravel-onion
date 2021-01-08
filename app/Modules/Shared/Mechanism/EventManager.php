<?php


namespace App\Modules\Shared\Mechanism;

/**
 * Application event manager.
 * @package App\Modules\Shared\Mechanism
 */
class EventManager
{
    private static array $events = [];
    private static bool $on_hold = false;

    public static function hold()
    {
        self::$on_hold = true;
    }

    /**
     * Directly publish domain event.
     * @param $event
     */
    public static function publish($event)
    {
        if (self::$on_hold) {
            self::$events[] = $event;
        } else {
            event($event);
        }
    }

    public static function release()
    {
        self::$on_hold = false;

        while (!empty(self::$events)) {
            $event = array_shift(self::$events);
            event($event);
        }
    }

    public static function reset()
    {
        self::$events = [];
    }
}