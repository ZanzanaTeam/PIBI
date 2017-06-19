<?php
/**
 * Created by PhpStorm.
 * User: tritux
 * Date: 19/06/17
 * Time: 00:56
 */

namespace Esprit\ProjetBiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ValidationSurface
 *
 * @package Esprit\ProjetBiBundle\Entity
 * @ORM\Entity()
 */
class ValidationSurface extends FileImport
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}