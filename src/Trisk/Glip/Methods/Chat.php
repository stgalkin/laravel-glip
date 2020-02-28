<?php

namespace Trisk\Glip\Methods;

use RingCentral\SDK\Http\ApiResponse;
use Trisk\Glip\Contracts\ChatContract;
use Trisk\Glip\Contracts\PersonContract;
use \Trisk\Glip\ValueObjects\Response\Chat as ChatResponse;

/**
 * Class Chat
 *
 * @package Trisk\Glip\Methods
 */
class Chat extends GlipMethod implements ChatContract
{
    /**
     * @inheritDoc
     */
    public function get(array $parameters = []): ChatResponse
    {
        return $this->_toResponse($this->api()->get('chats', $parameters));
    }

    /**
     * @param ApiResponse $response
     *
     * @return ChatResponse
     */
    private function _toResponse(ApiResponse $response): ChatResponse
    {
        return new ChatResponse($response);
    }

}
