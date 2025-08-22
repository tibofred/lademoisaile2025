<?php

namespace Viweb\CarouselBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Viweb\BaseBundle\Entity\Media;

/**
 * Carousel
 *
 * @ORM\Table(name="carousels")
 * @ORM\Entity(repositoryClass="Viweb\CarouselBundle\Repository\CarouselRepository")
 */
class Carousel
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="Viweb\BaseBundle\Entity\Media", cascade={"persist"})
     * @ORM\JoinTable(name="carousels_images",
     *      joinColumns={@ORM\JoinColumn(name="carousel_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="image_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $images;


    public function __construct()
    {
        $this->images = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Carousel
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * Add image
     *
     * @param Media $image
     * @return Carousel
     */
    public function addImage(Media $image)
    {
        if (!$this->getImages()->contains($image)) {
            $this->getImages()->add($image);
        }

        return $this;
    }

    /**
     * Get images
     *
     * @return ArrayCollection
     */
    public function getImages()
    {
        return $this->images;
    }

    public function removeImage($image)
    {
        $this->images->removeElement($image);
    }
}

