<?php


namespace App\Modules\Shared\Mechanism;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

/**
 * THIS IS NOT A PUBLIC INTERFACE
 * @package App\Modules\Shared\Mechanism
 */
class MessageBusJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    private Message $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function handle()
    {
        MessageBus::process($this->message);
    }
}