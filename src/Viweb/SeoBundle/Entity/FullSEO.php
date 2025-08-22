<?php

namespace Viweb\SeoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/** @ORM\MappedSuperclass */
class FullSEO
{
    

    /**
     * @var string
     *
     * @ORM\Column(name="meta_title", type="string", length=255, nullable=true)
     * @Assert\Length(min=10)
     */
    private $metaTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_description", type="string", length=255, nullable=true)
     */
    private $metaDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="ogtitle", type="string", length=255, nullable=true)
     */
    private $ogtitle;

    /**
     * @var string
     *
     * @ORM\Column(name="ogdescription", type="string", length=255, nullable=true)
     */
    private $ogdescription;

    /**
     * @ORM\ManyToOne(targetEntity="Viweb\BaseBundle\Entity\Media", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $fb_img;

    

    /**
     * Set metaTitle
     *
     * @param string $metaTitle
     *
     * @return FullSEO
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    /**
     * Get metaTitle
     *
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     *
     * @return FullSEO
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * Get metaDescription
     *
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }


    /**
     * Set ogtitle
     *
     * @param string $ogtitle
     *
     * @return FullSEO
     */
    public function setOgtitle($ogtitle)
    {
        $this->ogtitle = $ogtitle;

        return $this;
    }

    /**
     * Get ogtitle
     *
     * @return string
     */
    public function getOgtitle()
    {
        return $this->ogtitle;
    }

    /**
     * Set ogdescription
     *
     * @param string $ogdescription
     *
     * @return FullSEO
     */
    public function setOgdescription($ogdescription)
    {
        $this->ogdescription = $ogdescription;

        return $this;
    }

    /**
     * Get ogdescription
     *
     * @return string
     */
    public function getOgdescription()
    {
        return $this->ogdescription;
    }

    /**
     * @return mixed
     */
    public function getFbImg()
    {
        return $this->fb_img;
    }

    /**
     * @param mixed $fb_img
     */
    public function setFbImg($fb_img)
    {
        $this->fb_img = $fb_img;

        return $this;
    }
}