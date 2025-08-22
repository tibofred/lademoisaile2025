<?php

namespace Viweb\TemoignageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Temoignage
 *
 * @ORM\Table(name="temoignage")
 * @ORM\Entity(repositoryClass="Viweb\TemoignageBundle\Repository\TemoignageRepository")
 */
class Temoignage
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
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;

    /**
     * @var string
     *
     * @ORM\Column(name="lien", type="string", length=255)
     */
    private $lien;

    /**
     * @var string
     *
     * @ORM\Column(name="personne", type="string", length=255)
     */
    private $personne;

    /**
     * @var int
     *
     * @ORM\Column(name="ordre", type="integer")
     */
    private $ordre;

    /**
     * @var string
     *
     * @ORM\Column(name="signature", type="string", length=255)
     */
    private $signature;


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
     * Set contenu.
     *
     * @param string $contenu
     *
     * @return Temoignage
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
     * Set lien.
     *
     * @param string $lien
     *
     * @return Temoignage
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
     * Set personne.
     *
     * @param string $personne
     *
     * @return Temoignage
     */
    public function setPersonne($personne)
    {
        $this->personne = $personne;

        return $this;
    }

    /**
     * Get personne.
     *
     * @return string
     */
    public function getPersonne()
    {
        return $this->personne;
    }

    /**
     * Set ordre.
     *
     * @param int $ordre
     *
     * @return Temoignage
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get ordre.
     *
     * @return int
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Set signature.
     *
     * @param string $signature
     *
     * @return Temoignage
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;

        return $this;
    }

    /**
     * Get signature.
     *
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }
}
