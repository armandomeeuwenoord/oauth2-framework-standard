<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
