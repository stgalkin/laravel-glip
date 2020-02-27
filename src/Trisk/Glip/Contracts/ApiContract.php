<?php

namespace Trisk\Glip\Contracts;

use RingCentral\SDK\Http\ApiResponse;

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
     * @return ApiResponse
     * @throws \RingCentral\SDK\Http\ApiException|\Exception|\UnexpectedValueException
     */
    public function get(string $apiMethod, array $parameters = []): ApiResponse;

    /**
     * @param string $apiMethod
     * @param array  $parameters
     *
     * @return ApiResponse
     * @throws \RingCentral\SDK\Http\ApiException|\Exception|\UnexpectedValueException
     */
    public function post(string $apiMethod, array $parameters = []): ApiResponse;

    /**
     * @param string $apiMethod
     * @param array  $parameters
     *
     * @return ApiResponse
     * @throws \RingCentral\SDK\Http\ApiException|\Exception|\UnexpectedValueException
     */
    public function delete(string $apiMethod, array $parameters = []): ApiResponse;

    /**
     * @param string $apiMethod
     * @param array  $parameters
     *
     * @return ApiResponse
     * @throws \RingCentral\SDK\Http\ApiException|\Exception|\UnexpectedValueException
     */
    public function put(string $apiMethod, array $parameters = []): ApiResponse;

    /**
     * @param string $apiMethod
     * @param array  $parameters
     *
     * @return ApiResponse
     * @throws \RingCentral\SDK\Http\ApiException|\Exception|\UnexpectedValueException
     */
    public function patch(string $apiMethod, array $parameters = []): ApiResponse;
}
