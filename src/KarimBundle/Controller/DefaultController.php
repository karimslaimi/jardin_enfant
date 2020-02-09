<?php

namespace KarimBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @\Symfony\Component\Routing\Annotation\Route("/karim")
     */
    public function indexAction()
    {
        return new Response("hello world");
    }
}
