<?php

namespace Trisk\Glip\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class GlipChat
 *
 * @package Trisk\Glip\Facades
 */
class GlipChat extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'glip.chat';
    }
}
