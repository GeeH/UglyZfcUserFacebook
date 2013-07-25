<?php
namespace UglyZfcUserFacebookTest\View\Helper;

class FacebookLoginUrlTest extends \PHPUnit_Framework_TestCase
{



    public function testInvoke()
    {
        $scope = 'email';
        $settings = array(
            'facebook-app-id' => '123456789',
            'facebook-app-secret' => 'secret-as-fuck',
            'login-redirect-route' => 'home',
            'facebook-redirect-uri' => 'http://rmywebsite.dev/facebook-login',
        );
        $viewHelper = new FacebookLoginUrl($settings);
        pr($viewHelper());
    }
}