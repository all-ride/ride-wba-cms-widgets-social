<?php

namespace ride\web\cms\model;

use ride\library\http\client\CurlClient;
use ride\library\http\HeaderContainer;
use ride\library\config\Config;
use ride\library\http\HttpFactory;
use ride\library\http\Request;

class FlickrClient extends CurlClient {

    /**
     * @var String hostname
     */
    protected $host = 'https://api.flickr.com/services/rest';

    /**
     * @var String $apiKey;
     */
    private $apiKey;

    /**
     * @var String $apiSecret;
     */
    private $apiSecret;

    /**
     * @var String $oauthToken;
     */
    private $oauthToken;

    /**
     * @var String $oauthSecretToken;
     */
    private $oauthSecretToken;

    /**
     * @param String $method
     * @param array $params
     */
    public function call($method, $params = array()) {
        $params['method'] = $method;
        $params['api_key'] = $this->getApiKey();
        $params['format'] = 'json';
        $params['nojsoncallback'] = 1;

        $encoded_params = array();

        foreach ($params as $key => $value) {
            $encoded_params[] = urlencode($key) . '='  . urlencode($value);
        }

        $url = $this->getHost() . '?' . implode('&', $encoded_params);

        $request = $this->createRequest('GET', $url);
        $response = $this->sendRequest($request);
        return $this->convertResponse($response);
    }

    /**
     * Convert a JSON response and return an array.
     *
     * @param \ride\library\http\Response $response
     * @return array
     */
    public function convertResponse($response) {
        if ($response->getStatusCode() != 200) {
            return null;
        }

        $body = $response->getBody();
        $response->setBody(json_decode($body));

        return $response;
    }

    /**
     * @return String
     */
    public function getHost() {
        return $this->host;
    }

    /**
     * @param String $host
     */
    public function setHost($host) {
        $this->host = $host;
    }

    /**
     * @return mixed
     */
    public function getApiKey() {
        return $this->apiKey;
    }

    /**
     * @param mixed $apiKey
     */
    public function setApiKey($apiKey) {
        $this->apiKey = $apiKey;
    }

    /**
     * @return String
     */
    public function getApiSecret() {
        return $this->apiSecret;
    }

    /**
     * @param String $apiSecret
     */
    public function setApiSecret($apiSecret) {
        $this->apiSecret = $apiSecret;
    }

    /**
     * @return String
     */
    public function getOauthToken() {
        return $this->oauthToken;
    }

    /**
     * @param String $oauthToken
     */
    public function setOauthToken($oauthToken) {
        $this->oauthToken = $oauthToken;
    }

    /**
     * @return String
     */
    public function getOauthSecretToken() {
        return $this->oauthSecretToken;
    }

    /**
     * @param String $oauthSecretToken
     */
    public function setOauthSecretToken($oauthSecretToken) {
        $this->oauthSecretToken = $oauthSecretToken;
    }

}
