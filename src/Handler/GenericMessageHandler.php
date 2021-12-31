<?php


namespace App\Handler;

use App\Message\GenericMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class GenericMessageHandler
 * @package App\Handler
 */
class GenericMessageHandler implements MessageHandlerInterface
{
    public function __invoke(GenericMessage $genericMessage)
    {
        dump('Generic Message Handled!');

        // TODO: update reports
            // total trades executed
            // total traders on exchange
            // total shares on exchange
            // total shares by symbol (FOO, BAR, etc) on exchange
    }
}