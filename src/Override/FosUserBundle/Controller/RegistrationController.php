<?php

namespace Override\FosUserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Controller\RegistrationController as BaseController;

class RegistrationController extends BaseController
{

    public function registerAction(Request $request)
    {
        $securityService = $this->container->get('security.context');
        if ($securityService->isGranted('ROLE_SECRETARY') ||
            $securityService->isGranted('ROLE_ADMIN'))
        {

            return parent::registerAction($request);
        }
        return parent::registerAction($request);
        //throw new \Exception();
    }
}