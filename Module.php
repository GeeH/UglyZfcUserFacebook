<?php
namespace UglyZfcUserFacebook;

use UglyZfcUserFacebook\Controller\LoginController;
use UglyZfcUserFacebook\Service\FacebookService;
use UglyZfcUserFacebook\View\Helper\FacebookLoginUrl;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\ServiceManager;
use Zend\View\HelperPluginManager;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'UglyZfcUserFacebook\Controller\LoginController' => function (ControllerManager $controllerManager) {
                    $facebookService = $controllerManager->getServiceLocator()->get(
                        'UglyZfcUserFacebook\Service\FacebookService'
                    );
                    $controller = new LoginController($facebookService);
                    return $controller;
                }
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'UglyZfcUserFacebook\Service\FacebookService' => function (ServiceManager $serviceManager) {
                    $config = $serviceManager->get('config');
                    if (!array_key_exists('uglyzfcuserfacebook', $config)) {
                        throw new \InvalidArgumentException('Cannot find config for UglyZfcUserFacebook');
                    }
                    $service = new FacebookService($config['uglyzfcuserfacebook']);
                    return $service;
                },
            ),
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'facebookLoginUrl' => function (HelperPluginManager $viewHelperManager) {
                    $config = $viewHelperManager->getServiceLocator()->get('config');
                    if (!array_key_exists('uglyzfcuserfacebook', $config)) {
                        throw new \InvalidArgumentException('Cannot find config for UglyZfcUserFacebook');
                    }
                    $viewHelper = new FacebookLoginUrl($config['uglyzfcuserfacebook']);
                    return $viewHelper;
                }
            ),
        );
    }
}
