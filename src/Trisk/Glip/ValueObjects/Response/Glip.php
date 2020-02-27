<?php

namespace Trisk\Glip\ValueObjects\Response;

use RingCentral\SDK\Http\ApiResponse;

/**
 * Class Glip
 *
 * @package Trisk\Glip\ValueObjects\Response
 */
class Glip
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
     * Glip constructor.
     *
     * @param ApiResponse $response
     */
    public function __construct(ApiResponse $response)
    {
        $this->setOk($response->ok())
            ->setError($response->error());
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
     * @return Glip
     */
    private function setOk(bool $ok): Glip
    {
        $this->ok = $ok;

        return $this;
    }

    /**
     * @return null|string
     */
    public function error(): ?string
    {
        return $this->error;
    }

    /**
     * @param null|string $error
     *
     * @return Glip
     */
    private function setError(?string $error): Glip
    {
        $this->error = $error;

        return $this;
    }

    /**
     * @param ApiResponse $response $array
     * @param string      $key
     * @param mixed       $default
     *
     * @return mixed
     * @throws \Exception
     */
    protected function getResponseKey(ApiResponse $response, string $key, $default = null)
    {
        return collect(\Illuminate\Support\Arr::get($response->jsonArray(), $key, $default));
    }
}
