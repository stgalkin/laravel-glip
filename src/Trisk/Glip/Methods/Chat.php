<?php

namespace Trisk\Glip\Methods;

use Trisk\Glip\Contracts\ChatContract;
use \Trisk\Glip\ValueObjects\Response\Chat as ChatResponse;
use Trisk\Glip\ValueObjects\Response\GlipApiResponse;

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
     * @param GlipApiResponse $response
     *
     * @return ChatResponse
     */
    private function _toResponse(GlipApiResponse $response): ChatResponse
    {
        return new ChatResponse($response);
    }

}
