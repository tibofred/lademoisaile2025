<?php

namespace Viweb\ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Viweb\SeoBundle\Entity\FullSEO;
use Viweb\ArticleBundle\Entity\Categorie;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="Viweb\ArticleBundle\Repository\ArticleRepository")
 */
class Article extends FullSEO
{
    /**
     * @var string
     * Many Categories have Many articles.
     * @ORM\ManyToMany(targetEntity="Viweb\ArticleBundle\Entity\Categorie" , inversedBy="articles")
     * @ORM\JoinTable(name="article_categorie")
     *
     */
    private $categories;

    public function __construct() {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }
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
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;

     /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Viweb\BlogueuseBundle\Entity\Blogueuse" , fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $blogueuse;



    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_publication", type="datetime")
     */
    private $datePublication;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_planification", type="datetime")
     */
    private $datePlanification;

    /**
     * @var bool
     *
     * @ORM\Column(name="brouillon", type="boolean")
     */
    private $brouillon;

    /**
     * @var bool
     *
     * @ORM\Column(name="coupdecoeur", type="boolean")
     */
    private $coupdecoeur;

    /**
     * @var bool
     *
     * @ORM\Column(name="journee", type="boolean")
     */
    private $journee;

    /**
     * @var bool
     *
     * @ORM\Column(name="lainee", type="boolean")
     */
    private $lainee;

    /**
     * @var bool
     *
     * @ORM\Column(name="lblog", type="boolean")
     */
    private $lblog;

    /**
    * @ORM\OneToOne(targetEntity="Viweb\ArticleBundle\Entity\Photo", cascade={"persist", "remove"}, fetch="EAGER")
    * @ORM\JoinColumn(nullable=true)
    */
      private $photo;



    /**
     * @var int
     *
     * @ORM\Column(name="anne_scolaire", type="integer")
     */
    private $anneScolaire;




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
     * @return Article
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
     * @return Article
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
     * Set contenu.
     *
     * @param string $contenu
     *
     * @return Article
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu.
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }



    /**
     * Set datePublication.
     *
     * @param \DateTime $datePublication
     *
     * @return Article
     */
    public function setDatePublication($datePublication)
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    /**
     * Get datePublication.
     *
     * @return \DateTime
     */
    public function getDatePublication()
    {
        return $this->datePublication;
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

    /**
     * Set brouillon.
     *
     * @param bool $brouillon
     *
     * @return Article
     */
    public function setBrouillon($brouillon)
    {
        $this->brouillon = $brouillon;

        return $this;
    }

    /**
     * Get brouillon.
     *
     * @return bool
     */
    public function getBrouillon()
    {
        return $this->brouillon;
    }



    /**
     * Set coupdecoeur.
     *
     * @param bool $coupdecoeur
     *
     * @return Article
     */
    public function setCoupdecoeur($coupdecoeur)
    {
        $this->coupdecoeur = $coupdecoeur;

        return $this;
    }

    /**
     * Get coupdecoeur.
     *
     * @return bool
     */
    public function getCoupdecoeur()
    {
        return $this->coupdecoeur;
    }


    /**
     * Set journee.
     *
     * @param bool $journee
     *
     * @return Article
     */
    public function setJournee($journee)
    {
        $this->journee = $journee;

        return $this;
    }

    /**
     * Get journee.
     *
     * @return bool
     */
    public function getJournee()
    {
        return $this->journee;
    }


    /**
     * Set lainee.
     *
     * @param bool $lainee
     *
     * @return Article
     */
    public function setLainee($lainee)
    {
        $this->lainee = $lainee;

        return $this;
    }

    /**
     * Get lainee.
     *
     * @return bool
     */
    public function getLainee()
    {
        return $this->lainee;
    }


    /**
     * Set lblog.
     *
     * @param bool $lblog
     *
     * @return Article
     */
    public function setLblog($lblog)
    {
        $this->lblog = $lblog;

        return $this;
    }

    /**
     * Get lblog.
     *
     * @return bool
     */
    public function getLblog()
    {
        return $this->lblog;
    }



    /**
     * Set anneScolaire.
     *
     * @param int $anneScolaire
     *
     * @return Article
     */
    public function setAnneScolaire($anneScolaire)
    {
        $this->anneScolaire = $anneScolaire;

        return $this;
    }

    /**
     * Get anneScolaire.
     *
     * @return int
     */
    public function getAnneScolaire()
    {
        return $this->anneScolaire;
    }



    /**
     * Set blogueuse.
     *
     * @param \Viweb\BlogueuseBundle\Entity\Blogueuse $blogueuse
     *
     * @return Article
     */
    public function setBlogueuse(\Viweb\BlogueuseBundle\Entity\Blogueuse $blogueuse)
    {
        $this->blogueuse = $blogueuse;

        return $this;
    }

    /**
     * Get blogueuse.
     *
     * @return \Viweb\BlogueuseBundle\Entity\Blogueuse
     */
    public function getBlogueuse()
    {
        return $this->blogueuse;
    }

    /**
     * Set categories.
     *
     * @param \Viweb\ArticleBundle\Entity\Categorie $categorie
     *
     * @return Article
     */
    public function setCategories(\Viweb\ArticleBundle\Entity\Categorie $categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Get categories.
     *
     * @return \Viweb\ArticleBundle\Entity\Categorie
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set photo.
     *
     * @param \Viweb\ArticleBundle\Entity\Photo|null $photo
     *
     * @return Article
     */
    public function setPhoto(\Viweb\ArticleBundle\Entity\Photo $photo = null)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo.
     *
     * @return \Viweb\ArticleBundle\Entity\Photo|null
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set slug.
     *
     * @param string $slug
     *
     * @return Article
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
}
