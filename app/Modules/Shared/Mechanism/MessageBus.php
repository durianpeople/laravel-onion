<?php


namespace App\Modules\Shared\Mechanism;


use Closure;

class MessageBus
{
    private static array $listeners = [];
    private static string $current_channel = 'default';
    private static ?string $allowed_listener_channel = null;

    public static function setChannel(string $channel)
    {
        self::$current_channel = $channel;
    }

    public static function listenTo(string $channel, Closure $on_message_received)
    {
        self::$listeners[$channel][self::$current_channel][] = $on_message_received;
    }

    /**
     * Clear all registered listeners
     */
    public static function clearListeners()
    {
        self::$listeners = [];
    }

    /**
     * Broadcast message from source channel into queue.
     *
     * Message can be held by MessageBus::holdMessages() and reinserted into queue by MessageBus::releaseMessages() or discarded by MessageBus::resetMessage()
     *
     * @param string $source_channel
     * @param string $label
     * @param array $message
     */
    public static function broadcast(string $source_channel, string $label, array $message)
    {
        $payload = new Message($source_channel, $label, $message);

        MessageBusJob::dispatch($payload);
    }

    public static function disableListenersExceptOn(string $channel)
    {
        self::$allowed_listener_channel = $channel;
    }

    public static function enableListeners()
    {
        self::$allowed_listener_channel = null;
    }

    /**
     * THIS IS NOT A PUBLIC INTERFACE
     * @param Message $message
     */
    public static function process(Message $message)
    {
        if (!isset(self::$listeners[$message->getSourceChannel()])) {
            return;
        }

        foreach (self::$listeners[$message->getSourceChannel()] as $channel => $listeners) {
            if (self::$allowed_listener_channel !== null) {
                if ($channel != self::$allowed_listener_channel) {
                    continue;
                }
            }

            foreach ($listeners as $listener) {
                $listener($message->getLabel(), $message->getContent());
            }
        }
    }
}