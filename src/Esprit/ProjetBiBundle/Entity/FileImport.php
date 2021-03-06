<?php

namespace Esprit\ProjetBiBundle\Entity;

use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * ValidationImport
 *
 * @ORM\Table(name="file_import")
 * @ORM\Entity(repositoryClass="Esprit\ProjetBiBundle\Repository\ValidationImportRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap(
 *     {
 *          "v_surface"         = "ValidationSurface",
 *          "v_ferre"           = "ValidationFerre",
 *          "profile_surface"   = "ProfileSurface",
 *          "profile_ferre"     = "ProfileFerre",
 *     }
 * )
 */
class FileImport
{
    /**
     * 0: waiting
     * 1: syntaxe validation
     * 2: provisioning
     * 3: sytaxe error
     * 4: finished
     */
    const WAITING  = 0;
    const FINISHED = 1;
    const ERROR    = 2;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255)
     */
    private $filename;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="importedAt", type="datetime")
     */
    private $importedAt;
    /**
     * 0: waiting
     * 1: syntaxe validation
     * 2: provisioning
     * 3: sytaxe error
     * 4: finished
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status;
    /**
     * @ORM\Column(name="status_text", type="text", nullable=true)
     */
    private $statusText;
    /**
     * @var int
     *
     * @ORM\Column(name="nbLines", type="integer", nullable=false, options={"default":0})
     */
    private $nbLines = 0;
    /**
     * @var int
     *
     * @ORM\Column(name="nbInserred", type="integer", nullable=false, options={"default":0})
     */
    private $nbInserred = 0;
    /**
     * @var int
     *
     * @ORM\Column(name="nbErrors", type="integer", nullable=false, options={"default":0})
     */
    private $nbErrors = 0;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true))
     **/
    private $user;

    public function getStatusName()
    {
        $list = self::getListStatus();
        if (!array_key_exists($this->getStatus(), $list)) {
            return 'n-a';
        }

        return $list[$this->getStatus()];
    }

    public static function getListStatus()
    {
        return [
            self::WAITING  => 'En attente',
            self::FINISHED => 'Fini',
            self::ERROR    => 'Erreur',
        ];
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set filename
     *
     * @param string $filename
     *
     * @return FileImport
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get importedAt
     *
     * @return \DateTime
     */
    public function getImportedAt()
    {
        return $this->importedAt;
    }

    /**
     * Set importedAt
     *
     * @param \DateTime $importedAt
     *
     * @return FileImport
     */
    public function setImportedAt($importedAt)
    {
        $this->importedAt = $importedAt;

        return $this;
    }

    /**
     * Get nbLines
     *
     * @return integer
     */
    public function getNbLines()
    {
        return $this->nbLines;
    }

    /**
     * Set nbLines
     *
     * @param integer $nbLines
     *
     * @return FileImport
     */
    public function setNbLines($nbLines)
    {
        $this->nbLines = $nbLines;

        return $this;
    }

    /**
     * @return int
     */
    public function getNbInserred()
    {
        return $this->nbInserred;
    }

    /**
     * @param int $nbInserred
     *
     * @return FileImport
     */
    public function setNbInserred($nbInserred)
    {
        $this->nbInserred = $nbInserred;

        return $this;
    }

    /**
     * Get nbErrors
     *
     * @return integer
     */
    public function getNbErrors()
    {
        return $this->nbErrors;
    }

    /**
     * Set nbErrors
     *
     * @param integer $nbErrors
     *
     * @return FileImport
     */
    public function setNbErrors($nbErrors)
    {
        $this->nbErrors = $nbErrors;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return $this
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatusText()
    {
        return $this->statusText;
    }

    /**
     * Set status_text
     *
     * @param string $statusText
     *
     * @return $this
     */
    public function setStatusText($statusText)
    {
        $this->statusText = $statusText;

        return $this;
    }
}
