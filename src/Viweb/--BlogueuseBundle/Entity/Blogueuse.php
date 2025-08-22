<?php

namespace Viweb\BlogueuseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Blogueuse
 *
 * @ORM\Table(name="blogueuse")
 * @ORM\Entity(repositoryClass="Viweb\BlogueuseBundle\Repository\BlogueuseRepository")
 */
class Blogueuse
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
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;
    
    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Viweb\EcoleBundle\Entity\Ecole" , fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $ecole;
        
    
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_planification", type="datetime", options={"default"="CURRENT_TIMESTAMP"})
     */
    private $datePlanification;
    
    
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
   * @ORM\OneToOne(targetEntity="Viweb\BlogueuseBundle\Entity\Photo", cascade={"persist", "remove"}, fetch="EAGER")
   * @ORM\JoinColumn(nullable=true)
   */
  private $photo;
    
    /**
     * @ORM\OneToOne(targetEntity="Viweb\BlogueuseBundle\Entity\miniPhoto", cascade={"persist", "remove"}, fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)
   */
  private $miniPhoto;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    

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
     * @return Blogueuse
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
     * @return Blogueuse
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
     * Set description.
     *
     * @param string $description
     *
     * @return Blogueuse
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set ecole.
     *
     * @param \Viweb\EcoleBundle\Entity\Ecole $ecole
     *
     * @return Blogueuse
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
     * Set photo.
     *
     * @param \Viweb\BlogueuseBundle\Entity\Photo|null $photo
     *
     * @return Blogueuse
     */
    public function setPhoto(\Viweb\BlogueuseBundle\Entity\Photo $photo = null)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo.
     *
     * @return \Viweb\BlogueuseBundle\Entity\Photo|null
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set miniPhoto.
     *
     * @param \Viweb\BlogueuseBundle\Entity\miniPhoto|null $miniPhoto
     *
     * @return Blogueuse
     */
    public function setMiniPhoto(\Viweb\BlogueuseBundle\Entity\miniPhoto $miniPhoto = null)
    {
        $this->miniPhoto = $miniPhoto;

        return $this;
    }

    /**
     * Get miniPhoto.
     *
     * @return \Viweb\BlogueuseBundle\Entity\miniPhoto|null
     */
    public function getMiniPhoto()
    {
        return $this->miniPhoto;
    }

    /**
     * Set datePlanification.
     *
     * @param \DateTime $datePlanification
     *
     * @return Article
     */
    public function setDatePlanification($datePlanification)
    {
        $this->datePlanification = $datePlanification;

        return $this;
    }

    /**
     * Get datePlanification.
     *
     * @return \DateTime
     */
    public function getDatePlanification()
    {
        return $this->datePlanification;
    }
}
