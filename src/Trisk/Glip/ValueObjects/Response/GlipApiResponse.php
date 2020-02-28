<?php

namespace Trisk\Glip\ValueObjects\Response;

/**
 * Class GlipApiResponse
 *
 * @package Trisk\Glip\ValueObjects\Response
 */
class GlipApiResponse
{
    /**
     * @var array
     */
    private $response;

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
     * @param array  $response
     * @param bool  $ok
     * @param string $error
     */
    public function __construct(array $response, bool $ok = false, string $error = "")
    {
        $this->setResponse($response)
            ->setOk($ok)
            ->setError($error);
    }

    /**
     * @return array
     */
    public function response(): array
    {
        return $this->response;
    }

    /**
     * @param array $response
     *
     * @return GlipApiResponse
     */
    private function setResponse(array $response): GlipApiResponse
    {
        $this->response = $response;

        return $this;
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
    private function setOk(bool $ok): GlipApiResponse
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
    private function setError(?string $error): GlipApiResponse
    {
        $this->error = $error;

        return $this;
    }
}
