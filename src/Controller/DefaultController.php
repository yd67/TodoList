<?php

namespace App\Controller;

// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    /**
     * show homepage
     * @Route("/", name="homepage")
     */
    public function indexAction():Response
    {
        return $this->render('default/index.html.twig');
    }
}
