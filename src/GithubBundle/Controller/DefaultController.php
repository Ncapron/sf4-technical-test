<?php

namespace GithubBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->render('GithubBundle:Default:index.html.twig', array(
                'items' => '',
            ));
        }
        return $this->redirectToRoute('fos_user_security_login');
    }

    public function listAction(Request $req)
    {
        $data = $req->request->get('search');

        $ch = curl_init('https://api.github.com/search/users?q=' . $data);


        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Accept: application/vnd.github.v3+json',
          'User-Agent: GitHub-username'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $json = curl_exec($ch);
        $character = json_decode($json);
        $res = $character->items;

        return $this->render('GithubBundle:Default:list.html.twig', array(
            'items' => $res,
        ));
    }
}
