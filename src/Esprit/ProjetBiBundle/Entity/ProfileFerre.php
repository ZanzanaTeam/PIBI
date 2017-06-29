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
 * Class ProfileFerre
 *
 * @package Esprit\ProjetBiBundle\Entity
 *
 * @ORM\Entity()
 */
class ProfileFerre extends FileImport
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="integer", length=3)
     */
    protected $semestre;

    /**
     * @return \DateTime
     */
    public function getSemestre()
    {
        return $this->semestre;
    }

    /**
     * @param \DateTime $semestre
     *
     * @return ProfileSurface
     */
    public function setSemestre($semestre)
    {
        $this->semestre = $semestre;

        return $this;
    }
}