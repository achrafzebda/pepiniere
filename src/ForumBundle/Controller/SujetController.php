<?php

namespace ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SujetController extends Controller
{
    public function ajoutsujetAction()
    {
        return $this->render('@Forum/Sujet/ajoutersujet.html.twig');
    }
}
