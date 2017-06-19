<?php
/**
 * Created by PhpStorm.
 * User: tritux
 * Date: 18/06/17
 * Time: 17:07
 */
namespace Esprit\ProjetBiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Esprit\ProjetBiBundle\Entity\ProfileSurface;
use Esprit\ProjetBiBundle\Entity\ValidationSurface;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SurfaceController
 *
 * @package Esprit\ProjetBiBundle\Controller
 * @Route("/surface")
 */
class SurfaceController extends Controller
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @route ("/validation/new", name="admin_surface_validation")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newValidationAction(Request $request)
    {
        if ($request->getMethod() == "POST") {
            $resp = [];
            try {
                /**
                 * @var UploadedFile $file
                 */
                $file          = $request->files->get('file');
                $path          = $this->container->getParameter('path_import_files');
                $max_file_size = $this->container->getParameter('max_file_size');
                $accepted_file = 'CSV';
                $extention     = strtoupper($file->getClientOriginalExtension());

                if ($extention == $accepted_file) {
                    if ($file->getClientSize() <=
                        ($max_file_size * 1048576)
                    ) { //getClientSize return size file in bytes
                        $filename = time()."-".$file->getClientOriginalName();
                        $file->move($path, $filename);
                        //database
                        $em         = $this->getDoctrine()->getManager();
                        $validation = new ValidationSurface();
                        $validation->setFilename($filename);
                        $validation->setUser($this->getUser());
                        $validation->setImportedAt(new \DateTime('now'));
                        $validation->setStatus(ValidationSurface::WAITING); //waiting
                        $output = [];
                        $em->persist($validation);
                        $em->flush();
                    } else {
                        $resp['error'] = "La taille de fichier depasse la limit";
                    }
                } else {
                    $resp['error'] = "Le fichier doit être de type .csv ou .CSV";
                }
            } catch (\Exception $ex) {
                $resp['error'] = "Couldn't upload file, reason: ".$ex->getMessage();
            }

            return new Response(json_encode($resp));
        }

        return $this->render('EspritProjetBiBundle:Surface:Validation/new.html.twig', []);

    }

    /**
     * @route ("/validation/list", name="admin_surface_validation_list")
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listValidationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $validations = $em->getRepository(ValidationSurface::class)->findBy([], ['importedAt' => 'DESC']);

        return $this->render(
            'EspritProjetBiBundle:Surface:Validation/index.html.twig',
            ['validations' => $validations]
        );
    }

    /**
     * @route ("/profile/list", name="admin_surface_profile_list")
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listProfileAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $validations = $em->getRepository(ProfileSurface::class)->findBy([], ['importedAt' => 'DESC']);

        return $this->render('EspritProjetBiBundle:Surface:validation.html.twig', ['validations' => $validations]);
    }


    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @route ("/profile", name="admin_surface_profile")
     */
    public function newprofileAction(Request $request)
    {

    }
}