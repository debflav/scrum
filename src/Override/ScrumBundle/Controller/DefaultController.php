<?php

namespace Override\ScrumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('OverrideScrumBundle:Default:index.html.twig', array('name' => $name));
    }
}
