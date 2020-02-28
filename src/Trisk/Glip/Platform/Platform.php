<?php

namespace Trisk\Glip\Platform;

use Illuminate\Support\Arr;
use Trisk\Glip\ValueObjects\PlatformConfig;
use Trisk\Glip\ValueObjects\Response\GlipApiResponse;
use Trisk\Glip\ValueObjects\UserCredentials;

/**
 * Class Platform
 *
 * @package Trisk\Glip\Platform
 */
class Platform
{
    const RC_SERVER_URL_PART = '/restapi/v1.0';

    const SANDBOX = "https://platform.devtest.ringcentral.com";

    const PRODUCTION = "https://platform.ringcentral.com";

    /**
     * @var PlatformConfig
     */
    private $config;

    /**
     * @var string
     */
    private $serverUrl;

    /**
     * @var Auth|null
     */
    private $auth;

    /**
     * @param PlatformConfig $credentials
     * @param string         $serverUrl
     */
    function __construct(PlatformConfig $credentials, string $serverUrl = self::SANDBOX)
    {
        $this->config = $credentials;
        $this->serverUrl = $serverUrl;
    }

    /**
     * @return PlatformConfig
     */
    private function _config(): PlatformConfig
    {
        if (!$this->config instanceof PlatformConfig) {
            throw new \UnexpectedValueException('Credentials is not set!');
        }

        return $this->config;
    }

    /**
     * @param UserCredentials $userCredentials
     *
     * @return Platform
     */
    public function authorize(UserCredentials $userCredentials): Platform
    {
        $requestData = [
            'grant_type' => 'password',
            'username' => $userCredentials->username(),
            'extension' => $userCredentials->extension(),
            'password' => $userCredentials->password(),
        ];

        $this->authCall($requestData);

        return $this;
    }

    /**
     * @return bool
     */
    public function accessTokenValid(): bool
    {
        return $this->auth instanceof Auth && $this->auth->accessTokenValid();
    }

    /**
     * @return array
     */
    public function refreshToken(): array
    {
        $requestData = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->auth->refreshToken(),
        ];

        return $this->authCall($requestData);
    }

    /**
     * @param array $requestData
     *
     * @return array
     */
    private function authCall($requestData = []): array
    {
        $ch = curl_init($this->tokenUrl());

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Basic ' . $this->getApiKey(),
            'Content-Type: ' . 'application/x-www-form-urlencoded;charset=UTF-8',
        ]);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($requestData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseBody = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $responseData = json_decode($responseBody, true);

        $this->auth = new Auth($responseData);

        return $responseData;
    }

    /**
     * @return string
     */
    private function getApiKey(): string
    {
        $apiKey = base64_encode($this->_config()->clientId() . ':' . $this->_config()->clientSecret());

        return preg_replace('/[\s\t\r\n]/', '', $apiKey);
    }

    /**
     * @return string
     */
    private function tokenUrl(): string
    {
        return $this->serverUrl . '/restapi/oauth/token';
    }

    /**
     * @param $contentType
     * @param $body
     *
     * @return string
     */
    private function prepareBody($contentType, $body): string
    {
        if ($contentType == 'application/json') {
            if (is_array($body)) {
                $body = json_encode($body);
            }
        } elseif ($contentType == 'application/x-www-form-urlencoded') {
            if (is_array($body)) {
                $body = http_build_query($body);
            }
        }

        return $body;
    }

    /**
     * @param $url
     * @param $params
     *
     * @return GlipApiResponse
     */
    public function get($url, $params): GlipApiResponse
    {
        return $this->apiCall('GET', $url, $params);
    }

    /**
     * @param $url
     * @param $params
     *
     * @return GlipApiResponse
     */
    public function post($url, $params): GlipApiResponse
    {
        return $this->apiCall('POST', $url, $params);
    }

    /**
     * @param $url
     * @param $params
     *
     * @return GlipApiResponse
     */
    public function put($url, $params): GlipApiResponse
    {
        return $this->apiCall('PUT', $url, $params);
    }

    /**
     * @param $url
     * @param $params
     *
     * @return GlipApiResponse
     */
    public function delete($url, $params): GlipApiResponse
    {
        return $this->apiCall('DELETE', $url, $params);
    }

    /**
     * @param string $verb
     * @param string $url
     * @param array $params
     *
     * @return GlipApiResponse
     */
    private function apiCall(string $verb, string $url, array $params): GlipApiResponse
    {
        if (!$this->auth->accessTokenValid()) {
            $this->refreshToken();
        }

        $ch = curl_init($this->inflateUrl($url, $params));
        $ct = $this->getContentTypeForParams($params);
        if (strlen($ct) > 0) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $this->auth->accessToken(),
                'Content-Type: ' . $ct,
            ]);
        } else {
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $this->auth->accessToken(),
            ]);
        }
        if ($verb == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->getBodyForParams($params));
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseBody = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $response = json_decode($responseBody, true);
        if (preg_match('/^4[0-9][0-9]$/', $httpCode)) {
            return new GlipApiResponse([], false, Arr::get($response, 'message', ''));
        }

        return new GlipApiResponse($response, true, '');
    }

    /**
     * @param $params
     *
     * @return string
     */
    private function getContentTypeForParams($params): string
    {
        if (array_key_exists('json', $params)) {
            return 'application/json';
        }

        return '';
    }

    /**
     * @param $params
     *
     * @return mixed
     */
    private function getBodyForParams($params)
    {
        if (array_key_exists('json', $params)) {
            return $this->prepareBody('application/json', $params['json']);
        }

        return $params;
    }

    /**
     * @param string $urlIn
     * @param array  $queryParams
     *
     * @return string
     */
    private function inflateUrl($urlIn, array $queryParams): string
    {
        $queryString = "";

        if (is_array($queryParams)) {
            foreach ($queryParams as $key => $value) {
                if (is_array($value)){
                    foreach ($value as $val) {
                        $queryString .= $key."=".urlencode($val)."&";
                    }
                }else{
                    $queryString .= $key."=".urlencode($value)."&";
                }
            }
        }

        $queryString = rtrim($queryString,'&');

        if ($queryString != "") {
            $urlIn = $urlIn . (stristr($urlIn, '?') ? '&' : '?') . $queryString;
        }

        if (preg_match('/^\//', $urlIn)) {
            return $this->serverUrl . self::RC_SERVER_URL_PART . $urlIn;
        }

        return $this->serverUrl . self::RC_SERVER_URL_PART . '/' . $urlIn;
    }
}