<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;
// N'oubliez pas de rajouter ce « use », il définit le namespace pour les annotations de validation
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Partenaires
 *
 * @ORM\Table(name="partenaires")
 * @ORM\Entity(repositoryClass="Viweb\SiteBundle\Repository\PartenaireRepository")
 */
class Partenaire
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;
    
    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=255)
     */
    private $region;
    
    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=255)
     */
    private $telephone;
    
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

    

    public function __construct()
    {
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
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param string $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }


    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

}
