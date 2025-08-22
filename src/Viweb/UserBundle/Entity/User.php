<?php
/**
 * Created by PhpStorm.
 * User: conta
 * Date: 2017-11-17
 * Time: 1:00 PM
 */

namespace Viweb\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;
    
    
     /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     */
    private $prenom;
    
     /**
     * @var string
     *
     * @ORM\Column(name="courteDescription", type="text", nullable=true)
     */
    private $courteDescription;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="text", nullable=true)
     */
    private $titre;
    
    /**
    * @ORM\OneToOne(targetEntity="Viweb\UserBundle\Entity\Avatar", cascade={"persist", "remove"}, fetch="EAGER")
    * @ORM\JoinColumn(nullable=true)
    */
      private $avatar;

    
        /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;
    
    
     /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Viweb\EcoleBundle\Entity\Ecole" , fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)
     *
     */
    private $ecole;
    
    

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Set nom.
     *
     * @param string $nom
     *
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom.
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom.
     *
     * @param string $prenom
     *
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom.
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set ecole.
     *
     * @param \Viweb\EcoleBundle\Entity\Ecole $ecole
     *
     * @return User
     */
    public function setEcole(\Viweb\EcoleBundle\Entity\Ecole $ecole)
    {
        $this->ecole = $ecole;

        return $this;
    }

    /**
     * Get ecole.
     *
     * @return \Viweb\EcoleBundle\Entity\Ecole
     */
    public function getEcole()
    {
        return $this->ecole;
    }

    /**
     * Set titre.
     *
     * @param string|null $titre
     *
     * @return User
     */
    public function setTitre($titre = null)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre.
     *
     * @return string|null
     */
    public function getTitre()
    {
        return $this->titre;
    }

    

    /**
     * Set courteDescription.
     *
     * @param string|null $courteDescription
     *
     * @return User
     */
    public function setCourteDescription($courteDescription = null)
    {
        $this->courteDescription = $courteDescription;

        return $this;
    }

    /**
     * Get courteDescription.
     *
     * @return string|null
     */
    public function getCourteDescription()
    {
        return $this->courteDescription;
    }

    /**
     * Set description.
     *
     * @param string|null $description
     *
     * @return User
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set avatar.
     *
     * @param \Viweb\UserBundle\Entity\Avatar|null $avatar
     *
     * @return User
     */
    public function setAvatar(\Viweb\UserBundle\Entity\Avatar $avatar = null)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar.
     *
     * @return \Viweb\UserBundle\Entity\Avatar|null
     */
    public function getAvatar()
    {
        return $this->avatar;
    }
}
