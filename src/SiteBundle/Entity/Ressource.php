<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ressource
 *
 * @ORM\Table(name="ressources")
 * @ORM\Entity(repositoryClass="SiteBundle\Repository\RessourceRepository")
 */
class Ressource
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
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="mini_description", type="string", length=255, nullable=true)
     */
    private $mini_description = "";

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=5000, nullable=true)
     */
    private $contenu = "";

    /**
     * @ORM\ManyToOne(targetEntity="SiteBundle\Entity\Ressource", inversedBy="childs")
     * @ORM\JoinColumn(nullable=true)
     */
    private $parent;

    /**
     * @ORM\ManyToOne(targetEntity="Viweb\BaseBundle\Entity\Media", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $image;

    /**
     * @var int
     *
     * @ORM\Column(name="ordre", type="integer")
     */
    private $ordre;

    /**
     * @ORM\OneToMany(targetEntity="SiteBundle\Entity\Ressource", mappedBy="parent")
     */
    private $childs;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->childs = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Page
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
     * @return Page
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get mini_description
     *
     * @return string
     */
    public function getMiniDescription()
    {
        return $this->mini_description;
    }

    /**
     * Set mini_description
     *
     * @param string $mini_description
     *
     * @return Page
     */
    public function setMiniDescription($mini_description)
    {
        $this->mini_description = $mini_description;

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
     * @return Page
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
     * @return Page
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return mixed
     */
    public function getChilds()
    {
        return $this->childs;
    }
}

