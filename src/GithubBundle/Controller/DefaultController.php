<?php

namespace GithubBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GithubBundle:Default:index.html.twig');
    }
}
