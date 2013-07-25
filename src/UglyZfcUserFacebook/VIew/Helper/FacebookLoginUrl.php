<?php
namespace UglyZfcUserFacebook\View\Helper;

use Zend\View\Helper\AbstractHelper;

class FacebookLoginUrl extends AbstractHelper
{

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

    public function __invoke($scope = '')
    {
        $query = array(
            'client_id' => '522673097792786',
            'redirect_uri' => isset($this->config['facebook-redirect-uri'])
                ? $this->config['facebook-redirect-uri']
                : 'http://' . $_SERVER['HTTP_HOST'],
            'scope' => $scope,
        );
        $parts = array(
            "scheme" => "https",
            "host" => "www.facebook.com",
            "path" => "dialog/oauth",
            "query" => http_build_query($query)
        );
        $url = $parts['scheme'] . '://' . $parts['host'] . '/' . $parts['path'] . '?' . $parts['query'];
        return $url;
    }
}