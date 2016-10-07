<?php

namespace APP\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Product
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="APP\AppBundle\Entity\ProductRepository")
 */
class Product {

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
    private $code;

    /**
     * @var text
     *
     * @ORM\Column(name="introtext", type="text")
     */
    private $introtext;

    /**
     * @var text
     *
     * @ORM\Column(name="textfull", type="text")
     */
    private $textfull;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="string", length=255)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="equivalences", type="string", length=255)
     */
    private $equivalences;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateUpdate", type="datetime")
     */
    private $dateUpdate;

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
     * @ORM\JoinColumn(name = "category_id", referencedColumnName = "id", nullable = false)
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
     * @ORM\Column(name="dateEdit", type="datetime")
     */
    private $dateMod;

    /**
     * @ORM\OneToMany(targetEntity="APP\CoreBundle\Entity\Image", mappedBy="producto", cascade={"persist", "remove"})
     */
    private $images;

    /**
     * @var string
     *
     * @ORM\Column(name="mark", type="string", length=255)
     */
    private $mark;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    function getCode() {
        return $this->code;
    }

    function getIntrotext() {
        return $this->introtext;
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

    function setCode($code) {
        $this->code = $code;
    }

    function setIntrotext($introtext) {
        $this->introtext = $introtext;
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

    function setDateMod($dateMod) {
        $this->dateMod = $dateMod;
    }

    function getPrice() {
        return $this->price;
    }

    function getEquivalences() {
        return $this->equivalences;
    }

    function getDateUpdate() {
        return $this->dateUpdate;
    }

    function setPrice($price) {
        $this->price = $price;
    }

    function setEquivalences($equivalences) {
        $this->equivalences = $equivalences;
    }

    function setDateUpdate(\DateTime $dateUpdate) {
        $this->dateUpdate = $dateUpdate;
    }

    function getMark() {
        return $this->mark;
    }

    function setMark($mark) {
        $this->mark = $mark;
    }

    function getTextfull() {
        return $this->textfull;
    }

    function setTextfull($textfull) {
        $this->textfull = $textfull;
    }
            
    public function setImages($images) {
        foreach ($images as $image) {
            $image->setProduct($this);
        }
        $this->images = $images;

        return $this;
    }

    public function getImages() {
        return $this->images;
    }

    public function addImages($images) {
        $images->setProduct($this);
        $this->$images->add($images);
    }
    
    public function __toString() {
        return $this->category;
    }

}
