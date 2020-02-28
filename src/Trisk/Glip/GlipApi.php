<?php

namespace Trisk\Glip;

use Trisk\Glip\Contracts\ApiContract;
use Trisk\Glip\Platform\Platform;
use Trisk\Glip\ValueObjects\Response\GlipApiResponse;
use Trisk\Glip\ValueObjects\UserCredentials;
use Trisk\Glip\ValueObjects\PlatformConfig;
use Illuminate\Support\Traits\Macroable;

/**
 * Class GlipApi
 *
 * @package Trisk\Glip
 */
class GlipApi implements ApiContract
{
    const GLIP_REQUEST_PATH = "/glip/";

    use Macroable;

    /**
     * @var Platform
     */
    private $platform;

    /**
     * @var UserCredentials
     */
    private $userCredentials;

    /**
     * @param PlatformConfig $config
     */
    public function __construct(PlatformConfig $config)
    {
        if (\App::isLocal()) {
            $server = Platform::SANDBOX;
        } else {
            $server = Platform::PRODUCTION;
        }

        $this->platform = new Platform($config, $server);
    }

    /**
     * @return GlipApi
     */
    public function authorize(): GlipApi
    {
        $this->_platform()->authorize($this->_userCredentials());

        return $this;
    }

    /**
     * @return bool
     */
    public function isAuthorized(): bool
    {
        return $this->_platform()->accessTokenValid();
    }

    /**
     * @inheritdoc
     */
    public function get(string $apiMethod, array $parameters = []): GlipApiResponse
    {
        return $this->_platform()->get($this->path($apiMethod), $parameters);
    }

    /**
     * @inheritdoc
     */
    public function post(string $apiMethod, array $parameters = []): GlipApiResponse
    {
        return $this->_platform()->post($this->path($apiMethod), ['json' => $parameters]);
    }

    /**
     * @param string $apiMethod
     *
     * @return string
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
    public function put(string $apiMethod, array $parameters = []): GlipApiResponse
    {
        return $this->_platform()->put($this->path($apiMethod), $parameters);
    }

    /**
     * @inheritdoc
     */
    public function delete(string $apiMethod, array $parameters = []): GlipApiResponse
    {
        return $this->_platform()->delete($this->path($apiMethod), $parameters);
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
     * @return Platform
     * @throws \UnexpectedValueException
     */
    private function _platform(): Platform
    {
        if (!$this->platform instanceof Platform) {
            throw new \UnexpectedValueException("Platform does't init properly");
        }

        return $this->platform;
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
