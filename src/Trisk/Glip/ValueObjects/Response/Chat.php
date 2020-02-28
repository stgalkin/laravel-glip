<?php

namespace Trisk\Glip\ValueObjects\Response;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * Class Chat
 *
 * @package Trisk\Glip\ValueObjects\Response
 */
final class Chat
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
    private function setOk(bool $ok): Chat
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
    private function setError(?string $error): Chat
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
     * @return Chat
     */
    private function setRecords(Collection $records): Chat
    {
        $this->records = $records->map(function (array $data) {
            return new ChatRecord(\Illuminate\Support\Arr::get($data, 'id', ''), \Illuminate\Support\Arr::get($data, 'name', ''), \Illuminate\Support\Arr::get($data, 'description', ''));
        });

        return $this;
    }
}