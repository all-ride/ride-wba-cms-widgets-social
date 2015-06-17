<?php

namespace ride\web\cms\model;

use ride\library\config\Config;

class FlickrModel {

    /**
     * @var \ride\library\config\Config $config
     */
    protected $config;

    /**
     * @var FlickrCLient $flickrClient;
     */
    protected $flickrClient;

    /**
     * @param \ride\web\cms\model\FlickrClient $flickrClient
     * @param \ride\library\config\Config      $config
     */
    public function __construct(FlickrClient $flickrClient, Config $config) {
        $this->setConfig($config);
        $this->setFlickrClient($flickrClient);
    }

    public function setApiAuthentication($apiKey, $apiSecret) {
        $this->flickrClient->setApiKey($apiKey);
        $this->flickrClient->setApiSecret($apiSecret);
    }

    /**
     * @param String $method
     * @param array $arguments
     */
    public function call($method, $arguments = array()) {
        return $this->flickrClient->call($method, $arguments);
    }

    /**
     * @return Config
     */
    public function getConfig() {
        return $this->config;
    }

    /**
     * @param Config $config
     */
    public function setConfig($config) {
        $this->config = $config;
    }

    /**
     * @return FlickrCLient
     */
    public function getFlickrClient() {
        return $this->flickrClient;
    }

    /**
     * @param FlickrCLient $flickrClient
     */
    public function setFlickrClient($flickrClient) {
        $this->flickrClient = $flickrClient;
    }


}