<?php

namespace Trisk\Glip\Methods;

use Trisk\Glip\Contracts\PostContract;
use Trisk\Glip\ValueObjects\Response\GlipApiResponse;
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
    public function post(string $chatId, array $parameters = []): PostResponse
    {
        return $this->_toResponse($this->api()->post("chats/{$chatId}/posts", $parameters));
    }

    /**
     * @param GlipApiResponse $response
     *
     * @return PostResponse
     * @throws \Exception
     */
    private function _toResponse(GlipApiResponse $response): PostResponse
    {
        return new PostResponse($response);
    }

}
