<?php

namespace Trisk\Glip\ValueObjects\Response;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * Class Post
 *
 * @package Trisk\Glip\ValueObjects\Response
 */
final class Post
{
    /**
     * @var bool
     */
    protected $ok;

    /**
     * @var null|string
     */
    protected $error;

    /**
     * @var Collection
     */
    protected $records;

    /**
     * @param GlipApiResponse $glip
     */
    public function __construct(GlipApiResponse $glip)
    {
        $this->setOk($glip->ok())->setError($glip->error())->setRecords(collect(Arr::get($glip->response(), 'records', [])));
    }


    /**
     * @return bool
     */
    public function ok(): bool
    {
        return $this->ok;
    }

    /**
     * @param bool $ok
     *
     * @return GlipApiResponse
     */
    private function setOk(bool $ok): Post
    {
        $this->ok = $ok;

        return $this;
    }

    /**
     * @return string
     */
    public function error(): string
    {
        return $this->error;
    }

    /**
     * @param null|string $error
     *
     * @return GlipApiResponse
     */
    private function setError(?string $error): Post
    {
        $this->error = $error;

        return $this;
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
            return new PostRecord(\Illuminate\Support\Arr::get($data, 'id', ''), \Illuminate\Support\Arr::get($data, 'text'), \Illuminate\Support\Arr::get($data, 'description'));
        });

        return $this;
    }
}