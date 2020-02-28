<?php

namespace Trisk\Glip;

use RingCentral\SDK\Http\ApiResponse;
use RingCentral\SDK\SDK;
use Trisk\Glip\Contracts\ApiContract;
use Trisk\Glip\ValueObjects\UserCredentials;
use Trisk\Glip\ValueObjects\ClientCredentials;
use Illuminate\Support\Traits\Macroable;

/**
 * Class GlipApi
 *
 * @package Trisk\Glip
 */
class GlipApi implements ApiContract
{
    const SANDBOX = "https://platform.devtest.ringcentral.com";

    const PRODUCTION = "https://platform.ringcentral.com";

    const GLIP_REQUEST_PATH = "/glip/";

    use Macroable;

    /**
     * @var SDK
     */
    private $ringCentral;

    /**
     * @var UserCredentials
     */
    private $userCredentials;

    /**
     * @param ClientCredentials $credentials
     */
    public function __construct(ClientCredentials $credentials)
    {
        if (\App::isLocal()) {
            $server = static::SANDBOX;
        } else {
            $server = static::PRODUCTION;
        }

        $this->ringCentral = new SDK($credentials->clientId(), $credentials->clientSecret(), $server, config('glip.appName', ''), config('glip.appVersion', ''));
    }

    /**
     * @return \RingCentral\SDK\Http\ApiResponse
     * @throws \RingCentral\SDK\Http\ApiException
     */
    public function authorize()
    {
        return $this->_ringCentral()->platform()->login($this->_userCredentials()->username(), null, $this->_userCredentials()->password());
    }

    /**
     * @return bool
     */
    public function isAuthorized(): bool
    {
        return $this->_ringCentral()->platform()->auth()->accessTokenValid();
    }

    /**
     * @inheritdoc
     */
    public function get(string $apiMethod, array $parameters = []): ApiResponse
    {
        return $this->_ringCentral()->platform()->get($this->path($apiMethod), $parameters);
    }

    /**
     * @inheritdoc
     */
    public function post(string $apiMethod, array $parameters = []): ApiResponse
    {
        return $this->_ringCentral()->platform()->post($this->path($apiMethod), $parameters);
    }

    /**
     * @param string $apiMethod
     *
     * @return string
     * @throws \RingCentral\SDK\Http\ApiException
     */
    private function path(string $apiMethod): string
    {
        if (!$this->isAuthorized()) {
            $this->authorize();
        }

        return static::GLIP_REQUEST_PATH . $apiMethod;
    }

    /**
     * @inheritdoc
     */
    public function put(string $apiMethod, array $parameters = []): ApiResponse
    {
        return $this->_ringCentral()->platform()->put($this->path($apiMethod), $parameters);
    }

    /**
     * @inheritdoc
     */
    public function delete(string $apiMethod, array $parameters = []): ApiResponse
    {
        return $this->_ringCentral()->platform()->delete($this->path($apiMethod), $parameters);
    }

    /**
     * @inheritdoc
     */
    public function patch(string $apiMethod, array $parameters = []): ApiResponse
    {
        return $this->_ringCentral()->platform()->patch($this->path($apiMethod), $parameters);
    }

    /**
     * Loads an Glip Method by its contract short name.
     *
     * @param string $method
     *
     * @return mixed
     */
    public function load(string $method)
    {
        if (str_contains($method, '.')) {
            return app($method);
        }

        $contract = __NAMESPACE__ . '\\Contracts\\Glip' . studly_case($method);

        if (class_exists($contract)) {
            return app($contract);
        }

        return app('glip.' . snake_case($method));
    }

    /**
     * Alias to ::load.
     *
     * @param string $method
     *
     * @return mixed
     */
    public function __invoke(string $method)
    {
        return $this->load($method);
    }

    /**
     * @return SDK
     * @throws \UnexpectedValueException
     */
    private function _ringCentral(): SDK
    {
        if (!$this->ringCentral instanceof SDK) {
            throw new \UnexpectedValueException("ringCentral does't init properly");
        }

        return $this->ringCentral;
    }

    /**
     * @return UserCredentials
     */
    private function _userCredentials(): UserCredentials
    {
        if (!$this->userCredentials instanceof UserCredentials) {
            throw new \UnexpectedValueException("userCredentials does't init properly");
        }

        return $this->userCredentials;
    }

    /**
     * @param UserCredentials $userCredentials
     *
     * @return GlipApi
     */
    public function setUserCredentials(UserCredentials $userCredentials): GlipApi
    {
        $this->userCredentials = $userCredentials;

        return $this;
    }
}
