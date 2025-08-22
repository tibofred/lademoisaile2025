<?php

namespace Viweb\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Media
 *
 * @ORM\Table(name="media")
 * @ORM\Entity(repositoryClass="Viweb\MediaBundle\Repository\MediaRepository")
 */
class Media
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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

     /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=255)
     */
    private $categorie;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
   * @ORM\OneToOne(targetEntity="Viweb\MediaBundle\Entity\ImageMedia", cascade={"persist", "remove"}, fetch="EAGER")
   * @ORM\JoinColumn(nullable=true)
   */
    private $imageMedia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="lien", type="string", length=255)
     */
    private $lien;


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
     * Set titre.
     *
     * @param string $titre
     *
     * @return Media
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre.
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Media
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
     * Set imageMedia.
     *
     * @param \Viweb\MediaBundle\Entity\ImageMedia|null $imageMedia
     *
     * @return Media
     */
    public function setImageMedia(\Viweb\MediaBundle\Entity\ImageMedia $imageMedia = null)
    {
        $this->imageMedia = $imageMedia;

        return $this;
    }

    /**
     * Get imageMedia.
     *
     * @return \Viweb\MediaBundle\Entity\ImageMedia|null
     */
    public function getImageMedia()
    {
        return $this->imageMedia;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return Media
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set lien.
     *
     * @param string $lien
     *
     * @return Media
     */
    public function setLien($lien)
    {
        $this->lien = $lien;

        return $this;
    }

    /**
     * Get lien.
     *
     * @return string
     */
    public function getLien()
    {
        return $this->lien;
    }

    /**
     * Set categorie.
     *
     * @param string $categorie
     *
     * @return Media
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie.
     *
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }
}
