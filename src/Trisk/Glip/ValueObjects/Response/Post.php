<?php

namespace Trisk\Glip\ValueObjects\Response;

use Illuminate\Support\Collection;
use RingCentral\SDK\Http\ApiResponse;

/**
 * Class Post
 *
 * @package Trisk\Glip\ValueObjects\Response
 */
final class Post extends Glip
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
     * @return Post
     */
    private function setRecords(Collection $records): Post
    {
        $this->records = $records->map(function(array $data) {
            return new PostRecord(\Illuminate\Support\Arr::get($data, 'id', ''), \Illuminate\Support\Arr::get($data, 'text'));
        });

        return $this;
    }
}