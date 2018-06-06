<?php

/**
 * Created by PhpStorm.
 * User: tritux
 * Date: 01/07/17
 * Time: 13:21
 */

namespace Esprit\ProjetBiBundle\Command;

use Doctrine\ORM\EntityManager;
use Esprit\ProjetBiBundle\Entity\FileImport;
use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class updateFilesCommand
 *
 * @package Esprit\ProjetBiBundle\Command
 */
class updateFilesCommand extends ContainerAwareCommand
{

    protected $container;

    protected function configure()
    {
        $this
            ->setName('projetbi:update-files')
            ->setAliases(array('projetbi:update-files'))
            ->setDescription('Mettre à jours les fichiers en attentes.');
    }


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->container = $this->getContainer();
        /**
         * @var EntityManager $em
         */
        $em = $this->container->get('doctrine')->getManager();

        while (1) {
            $files = $em->getRepository(FileImport::class)->findBy(['status' => 0]);
            /**
             * @var FileImport $file
             */
            if (count($files)) {
                foreach ($files as $file) {
                    $file->setStatus(FileImport::FINISHED);
                    $nbLibes  = rand(50000, 800000);
                    $nbValide = rand($nbLibes - 2000, $nbLibes);
                    $nbErrors = $nbLibes - $nbValide;
                    $file->setNbLines($nbLibes);
                    $file->setNbInserred($nbValide);
                    $file->setNbErrors($nbErrors);
                    $em->persist($file);
                }
                $em->flush();
                $output->writeln(count($files)." a été mis à jours");
            } else {
                $output->writeln("rien a mettre à jours");
            }
            sleep(180);
        }
    }
}