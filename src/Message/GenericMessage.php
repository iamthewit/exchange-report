<?php


namespace App\Message;

/**
 * Class GenericMessage
 * @package App\Message
 */
class GenericMessage
{
    private string $type;
    private array $payload;

    /**
     * GenericMessage constructor.
     *
     * @param string $type
     * @param array  $payload
     */
    public function __construct(string $type, array $payload)
    {
        $this->type    = $type;
        $this->payload = $payload;
    }
}