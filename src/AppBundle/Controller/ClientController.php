<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/manager/client")
 */
class ClientController extends Controller
{
    /**
     * @Route("/", name="manager_client")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('client/index.html.twig');
    }
}
