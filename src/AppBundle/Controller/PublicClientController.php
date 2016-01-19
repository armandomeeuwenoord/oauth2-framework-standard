<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/manager/client/public")
 */
class PublicClientController extends Controller
{
    /**
     * @Route("/", name="manager_public_clients")
     * @Method("GET")
     */
    public function indexAction()
    {
        $manager = $this->get('oauth2_server.public_client.client_manager');
        $user = $this->get('security.token_storage')->getToken()->getUser();

        return $this->render('public/index.html.twig', [
            'clients' => $manager->getClientsOfUser($user),
        ]);
    }

    /**
     * @Route("/add", name="manager_public_client_add")
     * @Method("GET|POST")
     */
    public function addAction(Request $request)
    {
        $manager = $this->get('oauth2_server.public_client.client_manager');
        $form = $this->get('oauth2_server.public_client.form');
        $handler = $this->get('oauth2_server.public_client.form_handler');

        $client = $manager->createClient();
        $form->setData($client);

        if (false === $handler->handle($form, $request)) {
            return $this->render('public/add.html.twig', [
                'form'   => $form->createView(),
                'client' => $client,
            ]);
        } else {
            return $this->redirectToRoute('manager_public_clients');
        }
    }
}
