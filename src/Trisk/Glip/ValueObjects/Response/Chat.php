<?php

namespace Trisk\Glip\ValueObjects\Response;

use Illuminate\Support\Collection;
use RingCentral\SDK\Http\ApiResponse;

/**
 * Class Chat
 *
 * @package Trisk\Glip\ValueObjects\Response
 */
final class Chat extends Glip
{
    /**
     * @var Collection
     */
    protected $records;

    /**
     * @param ApiResponse $response
     *
     * @throws \Exception
     */
    public function __construct(ApiResponse $response)
    {
        parent::__construct($response);

        $this->setRecords($this->getResponseKey($response, 'records', []));
    }

    /**
     * @return Collection
     */
    public function records(): Collection
    {
        return $this->records;
    }

    /**
     * @param Collection $records
     *
     * @return Chat
     */
    private function setRecords(Collection $records): Chat
    {
        $this->records = $records->map(function(array $data) {
            return new ChatRecord(\Illuminate\Support\Arr::get($data, 'id', ''), \Illuminate\Support\Arr::get($data, 'name'), \Illuminate\Support\Arr::get($data, 'description'));
        });

        return $this;
    }
}