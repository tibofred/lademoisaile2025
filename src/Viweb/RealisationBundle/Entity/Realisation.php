<?php

namespace Viweb\RealisationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Viweb\SeoBundle\Entity\FullSEO;

/**
 * Realisation
 *
 * @ORM\Table(name="realisations")
 * @ORM\Entity(repositoryClass="Viweb\RealisationBundle\Repository\RealisationRepository")
 */
class Realisation extends FullSEO
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
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;
    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=5000, nullable=true)
     */
    private $contenu = "";

    /**
     * @ORM\ManyToOne(targetEntity="Viweb\CarouselBundle\Entity\Carousel")
     * @ORM\JoinColumn(name="carousel_id", referencedColumnName="id", nullable=true)
     */
    private $carousel;

    /**
     * @var int
     *
     * @ORM\Column(name="ordre", type="integer")
     */
    private $ordre;

    /**
     * Constructor
     */
    public function __construct()
    {
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
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Realisation
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Realisation
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Realisation
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get ordre
     *
     * @return int
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Set ordre
     *
     * @param integer $ordre
     *
     * @return Realisation
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCarousel()
    {
        return $this->carousel;
    }

    /**
     * @param mixed $carousel
     */
    public function setCarousel($carousel)
    {
        $this->carousel = $carousel;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
}

