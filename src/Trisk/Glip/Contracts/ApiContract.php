<?php

namespace Trisk\Glip\Contracts;

use Trisk\Glip\ValueObjects\Response\GlipApiResponse;

/**
 * Interface ApiContract
 *
 * @package Trisk\Glip\Contracts
 */
interface ApiContract
{
    /**
     * @param string $apiMethod
     * @param array  $parameters
     *
     * @return GlipApiResponse
     * @throws \Exception|\UnexpectedValueException
     */
    public function get(string $apiMethod, array $parameters = []): GlipApiResponse;

    /**
     * @param string $apiMethod
     * @param array  $parameters
     *
     * @return GlipApiResponse
     * @throws \Exception|\UnexpectedValueException
     */
    public function post(string $apiMethod, array $parameters = []): GlipApiResponse;

    /**
     * @param string $apiMethod
     * @param array  $parameters
     *
     * @return GlipApiResponse
     * @throws \Exception|\UnexpectedValueException
     */
    public function delete(string $apiMethod, array $parameters = []): GlipApiResponse;

    /**
     * @param string $apiMethod
     * @param array  $parameters
     *
     * @return GlipApiResponse
     * @throws \Exception|\UnexpectedValueException
     */
    public function put(string $apiMethod, array $parameters = []): GlipApiResponse;
}
