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
     * @param array  $arguments
     * @return array
     */
    public function call($method, $arguments = array()) {
        return $this->flickrClient->call($method, $arguments);
    }

    /**
     * https://www.flickr.com/services/api/flickr.photosets.getPhotos.html
     * @param int $setId
     * @param int $page
     * @param int $itemsPerPage
     * @return array
     */
    public function getPhotoSet($setId, $page = 1, $itemsPerPage = 5) {
        $response = $this->call('flickr.photosets.getPhotos', array (
            'photoset_id' => $setId,
            'page' => 1,
            'per_page' => 5,
            'extras' => 'url_m',
        ));

        $response = $response->getBody();
        if (!$response->photoset) {
            return array();
        }

        return $response->photoset;
    }

    /**
     * https://www.flickr.com/services/api/flickr.photos.getInfo.html
     * @param $photoid
     * @return mixed
     */
    public function getPhotoInfo($photoid) {
        $response = $this->call('flickr.photos.getInfo', array(
           'photo_id' => $photoid,
        ));

        $response = $response->getBody();

        return $response->photo;
    }

    /**
     * Builds the image url using provided parameters.
     * Url is a build like this : https://www.flickr.com/photos/{owner_name}/sets/{set_id}
     * @param array $params
     * @return null|string
     */
    public function getPhotoImageUrl($params) {
        if (!isset($params['farm']) || !isset($params['server']) || !isset($params['id']) || !isset($params['secret'])) {
            return null;
        }

        return 'https://farm' . $params['farm'] . '.staticflickr.com/' . $params['server'] . '/' . $params['id'] . '_' . $params['secret'] . '.jpg';
    }

    /**
     * Get the url of a photo embedded in the Flickr interface
     * @param $params array $params
     */
    public function getPhotoUrl($params) {
        if (!isset($params['ownername']) || !isset($params['id'])) {
            return null;
        }

        return 'https://www.flickr.com/photos/' . $params['ownername'] . '/' . $params['id'];
    }

    /**
     * Builds a photo_set url using provided parameters.
     * Url is a build like this : https://farm{farm-id}.staticflickr.com/{server-id}/{id}_{secret}.jpg
     * @param array $params
     * @return null|string
     */
    public function getPhotoSetUrl($params) {
        if (!isset($params['id']) || !isset($params['ownername'])) {
            return null;
        }

        return 'https://www.flickr.com/photos/' . $params['ownername'] . '/sets/' . $params['id'];
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