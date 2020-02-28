<?php

namespace Trisk\Glip\Contracts;

use Trisk\Glip\ValueObjects\Response\Post;

/**
 * Interface PostContract
 *
 * @package Trisk\Glip\Contracts
 */
interface PostContract
{
    /**
     * @param string $chatId
     * @param array  $parameters
     *
     * @return Post
     */
    public function get(string $chatId, array $parameters = []): Post;

    /**
     * @param array $parameters
     * @param string $chatId
     *
     * @return Post
     * @throws \RingCentral\SDK\Http\ApiException|\Exception
     */
    public function post(string $chatId, array $parameters = []): Post;
}