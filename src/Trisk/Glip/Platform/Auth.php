<?php

namespace Trisk\Glip\Platform;

/**
 * Class Auth
 *
 * @package Trisk\Glip\Platform
 */
class Auth
{
    /**
     * @var string
     */
    protected $tokenType;

    /**
     * @var string
     */
    protected $accessToken;

    /**
     * @var int
     */
    protected $expiresIn;

    /**
     * @var int
     */
    protected $expireTime;

    /**
     * @var string
     */
    protected $refreshToken;

    /**
     * Auth constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->tokenType = \Illuminate\Support\Arr::get($data, 'token_type', '');
        $this->accessToken = \Illuminate\Support\Arr::get($data, 'access_token', '');
        $this->expiresIn = \Illuminate\Support\Arr::get($data, 'expires_in', 0);

        if (empty($data['expire_time']) && !empty($data['expires_in'])) {
            $this->expireTime = time() + $this->expiresIn;
        } elseif (!empty($data['expire_time'])) {
            $this->expireTime = \Illuminate\Support\Arr::get($data, 'expire_time', 0);
        }

        $this->refreshToken = \Illuminate\Support\Arr::get($data, 'refresh_token', '');
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'token_type' => $this->tokenType,
            'access_token' => $this->accessToken,
            'expires_in' => $this->expiresIn,
            'expire_time' => $this->expireTime,
            'refresh_token' => $this->refreshToken,
        ];
    }

    /**
     * Get the access token.
     *
     * @return string
     */
    public function accessToken()
    {
        return $this->accessToken;
    }

    /**
     * Get the refresh token.
     *
     * @return string
     */
    public function refreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * Get the token type.
     *
     * @return string
     */
    public function tokenType()
    {
        return $this->tokenType;
    }

    /**
     * Return whether or not the access token is valid (i.e. not expired).
     *
     * @return bool True if the access token is valid, otherwise false.
     */
    public function accessTokenValid()
    {
        return $this->expireTime > time();
    }
}