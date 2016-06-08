<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/manager/client")
 */
class ClientController extends Controller
{
    /**
     * @Route("/", name="manager_client")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
    }
}
