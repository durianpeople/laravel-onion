<?php


namespace App\Modules\Shared\Mechanism;

/**
 * THIS IS NOT A PUBLIC INTERFACE
 * @package App\Modules\Shared\Mechanism
 */
class Message
{
    private string $label;
    private array $content;
    private string $source_channel;

    public function __construct(string $source_channel, string $label, array $content)
    {
        $this->label = $label;
        $this->content = $content;
        $this->source_channel = $source_channel;
    }

    public function getSourceChannel(): string
    {
        return $this->source_channel;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getContent(): array
    {
        return $this->content;
    }
}