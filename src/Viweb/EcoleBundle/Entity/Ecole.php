<?php

namespace Viweb\EcoleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Ecole
 *
 * @ORM\Table(name="ecole")
 * @ORM\Entity(repositoryClass="Viweb\EcoleBundle\Repository\EcoleRepository")
 */
class Ecole
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
     * @ORM\Column(name="nom", type="string", length=255, unique=true)
     */
    private $nom;
    

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;
    
     /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, unique=true)
     */
    private $adresse;
    
    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255, unique=true)
     */
    private $ville;
    
    /**
     * @var string
     *
     * @ORM\Column(name="codepostal", type="string", length=255)
     */
    private $codepostal;
    
     /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=255)
     */
    private $telephone;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="responsable", type="string", length=255)
     */
    private $responsable;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="titreResponsable", type="string", length=255)
     */
    private $titreResponsable;
    
    
    
    /**
    * @ORM\OneToOne(targetEntity="Viweb\EcoleBundle\Entity\imgResponsable", cascade={"persist", "remove"}, fetch="EAGER")
    * @ORM\JoinColumn(nullable=true)
    */
      private $imgResponsable;
    
     /**
     *
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     *
     * @Assert\Email(
     *     message = "Le courriel '{{ value }}' n'est pas valide.",
     *     checkMX = true
     * )
     */
     private $email;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Viweb\EcoleBundle\Entity\Region" , fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $region;
    
    
    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Viweb\EcoleBundle\Entity\Commission" , fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)
     *
     */
    private $commission;
    

    /**
   * @ORM\OneToOne(targetEntity="Viweb\EcoleBundle\Entity\Logo", cascade={"persist", "remove"}, fetch="EAGER")
   * @ORM\JoinColumn(nullable=true)
   */
  private $logo;
  private $ecole;



    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=50)
     */
    private $latitude;
    
    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=50)
     */
    private $longitude;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom.
     *
     * @param string $nom
     *
     * @return Ecole
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



     public function setLogo(Logo $logo = null)
  {
    $this->logo = $logo;
  }
    
    
  public function getLogo()
  {
    return $this->logo;
  }
    
    
    /**
     * Set region.
     *
     * @param \Viweb\EcoleBundle\Entity\Region $region
     *
     * @return Ecole
     */
    public function setRegion(\Viweb\EcoleBundle\Entity\Region $region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region.
     *
     * @return \Viweb\EcoleBundle\Entity\Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set commission.
     *
     * @param \Viweb\EcoleBundle\Entity\Commission $commission
     *
     * @return Ecole
     */
    public function setCommission(\Viweb\EcoleBundle\Entity\Commission $commission)
    {
        $this->commission = $commission;

        return $this;
    }

    /**
     * Get commission.
     *
     * @return \Viweb\EcoleBundle\Entity\Commission
     */
    public function getCommission()
    {
        return $this->commission;
    }

    /**
     * Set slug.
     *
     * @param string $slug
     *
     * @return Ecole
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set adresse.
     *
     * @param string $adresse
     *
     * @return Ecole
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse.
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set ville.
     *
     * @param string $ville
     *
     * @return Ecole
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville.
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }
    
    
    /**
     * Set email.
     *
     * @param string $email
     *
     * @return Ecole
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    

    /**
     * Set codepostal.
     *
     * @param string $codepostal
     *
     * @return Ecole
     */
    public function setCodepostal($codepostal)
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    /**
     * Get codepostal.
     *
     * @return string
     */
    public function getCodepostal()
    {
        return $this->codepostal;
    }

    /**
     * Set telephone.
     *
     * @param string $telephone
     *
     * @return Ecole
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone.
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set responsable.
     *
     * @param string $responsable
     *
     * @return Ecole
     */
    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get responsable.
     *
     * @return string
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * Set titreResponsable.
     *
     * @param string $titreResponsable
     *
     * @return Ecole
     */
    public function setTitreResponsable($titreResponsable)
    {
        $this->titreResponsable = $titreResponsable;

        return $this;
    }

    /**
     * Get titreResponsable.
     *
     * @return string
     */
    public function getTitreResponsable()
    {
        return $this->titreResponsable;
    }

    /**
     * Set imgResponsable.
     *
     * @param \Viweb\EcoleBundle\Entity\imgResponsable|null $imgResponsable
     *
     * @return Ecole
     */
    public function setImgResponsable(\Viweb\EcoleBundle\Entity\imgResponsable $imgResponsable = null)
    {
        $this->imgResponsable = $imgResponsable;

        return $this;
    }

    /**
     * Get imgResponsable.
     *
     * @return \Viweb\EcoleBundle\Entity\imgResponsable|null
     */
    public function getImgResponsable()
    {
        return $this->imgResponsable;
    }


    public function getEcole() {
      return $this->ecole;
    }
    
    
    /**
     * Set latitude.
     *
     * @param string $latitude
     *
     * @return Ecole
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude.
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }
    /**
     * Set longitude.
     *
     * @param string $longitude
     *
     * @return Ecole
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude.
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

}
