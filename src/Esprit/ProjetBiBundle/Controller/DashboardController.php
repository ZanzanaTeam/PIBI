<?php
/**
 * Created by PhpStorm.
 * User: tritux
 * Date: 18/06/17
 * Time: 20:47
 */

namespace Esprit\ProjetBiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DashboardController
 *
 * @package Esprit\ProjetBiBundle\Controller
 */
class DashboardController extends Controller
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="esprit_projetbi_dashboard_index")
     */
    public function indexAction(Request $request)
    {
        return $this->render('EspritProjetBiBundle:Dashboard:index.html.twig');
    }
}