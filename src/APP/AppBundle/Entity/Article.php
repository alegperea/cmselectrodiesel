<?php

namespace APP\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Articles
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="APP\AppBundle\Entity\ArticleRepository")
 */
class Article {

    const published = 1;
    const unpublished = 2;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="introtext", type="text")
     */
    private $introtext;

    /**
     * @var string
     *
     * @ORM\Column(name="fulltext", type="text")
     */
    private $fullText;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="integer")
     */
    private $state;

    /**
     * @var APP\AppBundle\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity = "APP\AppBundle\Entity\Category")
     * @ORM\JoinColumn(name = "category_id", referencedColumnName = "id")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="APP\UsuarioBundle\Entity\Usuario")
     */
    private $userAdd;

    /**
     * @ORM\ManyToOne(targetEntity="APP\UsuarioBundle\Entity\Usuario")
     */
    private $userMod;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAdd", type="datetime")
     */
    private $dateAdd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateMod", type="datetime")
     */
    private $dateMod;

    /**
     * @ORM\OneToMany(targetEntity="APP\CoreBundle\Entity\Image", mappedBy="article", cascade={"persist", "remove"})
     */
    private $images;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    function getTitle() {
        return $this->title;
    }

    function getIntrotext() {
        return $this->introtext;
    }

    function getFullText() {
        return $this->fullText;
    }

    function getState() {
        return $this->state;
    }

    function getCategory() {
        return $this->category;
    }

    function getUserAdd() {
        return $this->userAdd;
    }

    function getUserMod() {
        return $this->userMod;
    }

    function getDateAdd() {
        return $this->dateAdd;
    }

    function getDateMod() {
        return $this->dateMod;
    }

    function getImages() {
        return $this->images;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setIntrotext($introtext) {
        $this->introtext = $introtext;
    }

    function setFullText($fullText) {
        $this->fullText = $fullText;
    }

    function setState($state) {
        $this->state = $state;
    }

    function setCategory($category) {
        $this->category = $category;
    }

    function setUserAdd($userAdd) {
        $this->userAdd = $userAdd;
    }

    function setUserMod($userMod) {
        $this->userMod = $userMod;
    }

    function setDateAdd($dateAdd) {
        $this->dateAdd = $dateAdd;
    }

    function setDateMod( $dateMod) {
        $this->dateMod = $dateMod;
    }

    function setImages($images) {
        $this->images = $images;
    }

    public function setImagenes($imagenes) {
        foreach ($imagenes as $imagen) {
            $imagen->setVehiculo($this);
        }
        $this->imagenes = $imagenes;

        return $this;
    }

    public function getImagenes() {
        return $this->imagenes;
    }

    public function addImagenes($imagen) {
        $imagen->setVehiculo($this);
        $this->imagenes->add($imagen);
    }

    public function __toString() {
        return $this->category;
    }
    
    

}
