<?php

namespace AppPhotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('AppPhotoBundle:Default:index.html.twig');
    }

    /**
     * @Route("/test", name="test")
     */
    public function testAction()
    {
        return $this->render('AppPhotoBundle:Default:test.html.twig');
    }
}
