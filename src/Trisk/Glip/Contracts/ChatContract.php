<?php

namespace Trisk\Glip\Contracts;

use Trisk\Glip\ValueObjects\Response\Chat;

/**
 * Interface ChatContract
 *
 * @package Trisk\Glip\Contracts
 */
interface ChatContract
{
    /**
     * @param array $parameters
     *
     * @return Chat
     * @throws \RingCentral\SDK\Http\ApiException
     */
    public function get(array $parameters = []): Chat;
}
