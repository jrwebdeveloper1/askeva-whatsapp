<?php

namespace Askeva\WhatsApp\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Askeva\WhatsApp\AskEvaClient
 */
class AskEva extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'askeva';
    }
}
