<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Page
 *
 * @ORM\Table(name="blocs")
 * @ORM\Entity(repositoryClass="SiteBundle\Repository\BlocRepository")
 */
class Bloc
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=2000)
     */
    private $contenu;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Bloc
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        if ($this->image != null) {
            return str_replace("{{BLOC_IMG}}", $this->image->getRenderPath(), $this->contenu);
        }
        return $this->contenu;
    }


    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Bloc
     */
    public function setContenu($contenu)
    {
        if ($this->image != null) {
            $contenu = str_replace($this->image->getRenderPath(), "{{BLOC_IMG}}", $contenu);
        }

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
     * @return Bloc
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
    }

}

