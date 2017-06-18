<?php

namespace Esprit\ProjetBiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('EspritProjetBiBundle:Default:index.html.twig');
    }
}
