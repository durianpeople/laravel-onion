<?php


namespace App\Modules\Shared\Mechanism;


use Closure;

class MessageBus
{
    private static array $listeners = [];
    private static array $messages = [];
    private static int $stack = -1;

    public static function listenTo(string $channel, Closure $on_message_received)
    {
        if (!isset(self::$listeners[$channel])) {
            self::$listeners[$channel] = [];
        }

        self::$listeners[$channel][] = $on_message_received;
    }

    /**
     * Hold broadcast messages from being processed into stack
     */
    public static function holdMessages()
    {
        self::$stack++;
        self::$messages[self::$stack] = [];
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

        if (self::$stack == -1) {
            MessageBusJob::dispatch($payload);
        } else {
            array_push(self::$messages[self::$stack], $payload);
        }
    }

    /**
     * Release held messages into queue for processing
     */
    public static function releaseMessages()
    {
        while (self::$stack >= 0) {
            foreach (self::$messages[self::$stack] as $message) {
                MessageBusJob::dispatch($message);
            }

            unset(self::$messages[self::$stack]);
            self::$stack--;
        }
    }

    /**
     * Discard all messages held in stack
     */
    public static function resetMessages()
    {
        unset(self::$messages[self::$stack]);
        self::$stack--;
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

        foreach (self::$listeners[$message->getSourceChannel()] as $listener) {
            $listener($message->getLabel(), $message->getContent());
        }
    }
}