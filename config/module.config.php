<?php
return array(
    'router' => array(
        'routes' => array(
            'facebook-login' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/facebook-login',
                    'defaults' => array(
                        'controller' => 'UglyZfcUserFacebook\Controller\LoginController',
                        'action' => 'login'
                    ),
                ),
            ),
        ),
    ),
);