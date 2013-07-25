<?php
namespace UglyZfcUserFacebook\Service;

use Zend\Http\Client;

class FacebookService
{

    /**
     * Facebook code exchange uri
     */
    const FACEBOOK_EXCHANGE_URI = 'https://graph.facebook.com/oauth/access_token';
    /**
     * @var array
     */
    protected $config;

    /**
     * @param array $config
     */
    function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param $code
     * @return array
     * @throws \Exception
     */
    public function processCode($code)
    {
        $query = array(
            'client_id' => $this->config['facebook-app-id'],
            'redirect_uri' => isset($this->config['facebook-redirect-uri'])
                ? $this->config['facebook-redirect-uri']
                : 'http://' . $_SERVER['HTTP_HOST'],
            'client_secret' => $this->config['facebook-app-secret'],
            'code' => $code,
        );
        $httpClient = new Client(self::FACEBOOK_EXCHANGE_URI);
        $httpClient->setParameterGet($query);
        $httpClient->setOptions(array('sslverifypeer' => false));
        $response = $httpClient->send();

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Bad response exchanging Facebook code - ' . $response->getBody());
        }

        parse_str($response->getBody(), $decodedResponse);
        $expires = new \DateTime();
        $expires->setTimestamp(time() + $decodedResponse['expires']);
        $token = $decodedResponse['access_token'];

        return array('token' => $token, 'expires' => $expires);
    }

    public function processFacebookToken(array $token)
    {

    }


}