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
        $path = $this->container->getParameter('path_import_files');
        $path .= 'surface/validation/';
        $max_file_size = $this->container->getParameter('max_file_size');
        $accepted_file = ['csv','CSV'];
        $resp          = [];
        if ($request->getMethod() == 'POST') {
            try {
                /**
                 * @var UploadedFile $file
                 */
                $file      = $request->files->get('file');
                $extention = strtoupper($file->getClientOriginalExtension());
                if (in_array($extention, $accepted_file)){
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

        return $this->render(
            'EspritProjetBiBundle:Surface:Validation/new.html.twig',
            ['max_file_size' => $max_file_size, 'accepted_file' => implode(',',$accepted_file)]
        );

    }


    /**
     * @route ("/validation/list", name="admin_surface_validation_list")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listValidationAction()
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
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listProfileAction()
    {
        $em = $this->getDoctrine()->getManager();

        $horaires = $em->getRepository(ProfileSurface::class)->findBy([], ['importedAt' => 'DESC']);

        return $this->render('EspritProjetBiBundle:Surface:Profile/index.html.twig', ['horaires' => $horaires]);
    }


    /**
     * @Route ("/profile/new", name="admin_surface_profile")
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newprofileAction(Request $request)
    {
        $path = $this->container->getParameter('path_import_files');
        $path .= 'surface/validation/';
        $max_file_size = $this->container->getParameter('max_file_size');
        $accepted_file = ['csv','CSV'];
        $resp          = [];
        if ($request->getMethod() == 'POST') {
            try {
                /**
                 * @var UploadedFile $file
                 */
                $file     = $request->files->get('file');
                $semestre = $request->request->get('semestre');
                if ($semestre == 1) {
                    $path .= 'S1/';
                } else {
                    $path .= 'S2/';
                }
                $extention = strtoupper($file->getClientOriginalExtension());
                if (in_array($extention, $accepted_file)){
                    {if ($file->getClientSize() <=
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
                    $em->persist($validation);
                    $em->flush();
                } else {
                    $resp['error'] = "La taille de fichier depasse la limit";
                }
            }
            } else {
                    $resp['error'] = "Le fichier doit être de type .csv ou .CSV";
                }
            } catch (\Exception $ex) {
                $resp['error'] = "Couldn't upload file, reason: ".$ex->getMessage();
            }

            return new Response(json_encode($resp));
        }

        return $this->render(
            'EspritProjetBiBundle:Surface:Profile/new.html.twig',
            ['max_file_size' => $max_file_size, 'accepted_file' => implode(',',$accepted_file)]
        );
    }
}
   