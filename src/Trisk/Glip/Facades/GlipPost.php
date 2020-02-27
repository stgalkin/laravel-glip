<?php

namespace Trisk\Glip\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class GlipPost
 *
 * @package Trisk\Glip\Facades
 */
class GlipPost extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'glip.post';
    }
}
