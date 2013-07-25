<?php
namespace UglyZfcUserFacebook\Controller;

use UglyZfcUserFacebook\Service\FacebookService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Validator\Regex;

class LoginController extends AbstractActionController
{
    /**
     * @var \UglyZfcUserFacebook\Service\FacebookService
     */
    protected $facebookService;

    /**
     * @param FacebookService $facebookService
     */
    public function __construct(FacebookService $facebookService)
    {
        $this->facebookService = $facebookService;
    }

    public function loginAction()
    {
        $code = $this->params()->fromQuery('code', null);
        $code = filter_var($code, FILTER_SANITIZE_STRING, FILTER_NULL_ON_FAILURE);
        if(!empty($code) && $code === $this->params()->fromQuery('code', null)) {
            $token = $this->facebookService->processCode($code);
            $this->facebookService->processFacebookToken($token);

        }
        $this->redirect()->toRoute('home');
    }
}