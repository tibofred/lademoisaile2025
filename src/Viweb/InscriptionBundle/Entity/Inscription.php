<?php

namespace Viweb\InscriptionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;
// N'oubliez pas de rajouter ce « use », il définit le namespace pour les annotations de validation
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Inscription
 *
 * @ORM\Table(name="inscriptions")
 * @ORM\Entity(repositoryClass="Viweb\InscriptionBundle\Repository\InscriptionRepository")
 */
class Inscription
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nomEcole", type="string", length=255)
     */
    private $nomEcole;
    
    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;
    
    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="string", length=255)
     */
    private $facebook;
    
    /**
     * @var string
     *
     * @ORM\Column(name="instagram", type="string", length=255)
     */
    private $instagram;
    
    /**
     * @var string
     *
     * @ORM\Column(name="courriel", type="string", length=255)
     * @Assert\Email(
     *     message = "Ce courriel '{{ value }}' n'est pas valide.",
     *     checkMX = true
     * )
     */
    private $courriel;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    
    /**
     * @var string
     *
     * @ORM\Column(name="article", type="text")
     */
    private $article;

    

    public function __construct()
    {
        $this->date = new \Datetime();
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * @param string $facebook
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;
    }

    /**
     * @return string
     */
    public function getInstagram()
    {
        return $this->instagram;
    }

    /**
     * @param string $instagram
     */
    public function setInstagram($instagram)
    {
        $this->instagram = $instagram;
    }


    /**
     * @return string
     */
    public function getCourriel()
    {
        return $this->courriel;
    }

    /**
     * @param string $courriel
     */
    public function setCourriel($courriel)
    {
        $this->courriel = $courriel;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param string $article
     */
    public function setArticle($article)
    {
        $this->article = $article;
    }



    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }




    /**
     * Set nomEcole.
     *
     * @param string $nomEcole
     *
     * @return Inscription
     */
    public function setNomEcole($nomEcole)
    {
        $this->nomEcole = $nomEcole;

        return $this;
    }

    /**
     * Get nomEcole.
     *
     * @return string
     */
    public function getNomEcole()
    {
        return $this->nomEcole;
    }

}
