<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/manager")
 */
class ManagerController extends Controller
{
    /**
     * @Route("/", name="manager")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
    }
}
