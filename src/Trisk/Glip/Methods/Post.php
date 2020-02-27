<?php

namespace Trisk\Glip\Methods;


use RingCentral\SDK\Http\ApiResponse;
use Trisk\Glip\Contracts\PostContract;
use Trisk\Glip\ValueObjects\Response\Post as PostResponse;

/**
 * Class Post
 *
 * @package Trisk\Glip\Methods
 */
class Post extends GlipMethod implements PostContract
{
    /**
     * @inheritDoc
     */
    public function get(string $chatId, array $parameters = []): PostResponse
    {
        return $this->_toResponse($this->api()->get("chats/{$chatId}/posts", $parameters));
    }

    /**
     * @inheritDoc
     */
    public function post(array $parameters = []): PostResponse
    {
        return $this->_toResponse($this->api()->post('posts', $parameters));
    }

    /**
     * @param ApiResponse $response
     *
     * @return PostResponse
     * @throws \Exception
     */
    private function _toResponse(ApiResponse $response): PostResponse
    {
        return new PostResponse($response);
    }

}