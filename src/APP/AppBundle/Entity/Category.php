<?php

namespace APP\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Category
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="APP\AppBundle\Entity\CategoryRepository")
 */
class Category {

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
     * @ORM\ManyToOne(targetEntity="APP\UsuarioBundle\Entity\Usuario")
     */
    private $userAdd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAdd", type="datetime")
     */
    private $dateAdd;

    /**
     * @var String
     *
     * @ORM\Column(name="typecat", type="integer")
     */
    private $typeCat;


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

    function getUserAdd() {
        return $this->userAdd;
    }

    function getDateAdd() {
        return $this->dateAdd;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setUserAdd($userAdd) {
        $this->userAdd = $userAdd;
    }

    function setDateAdd(\DateTime $dateAdd) {
        $this->dateAdd = $dateAdd;
    }

    function getTypeCat() {
        return $this->typeCat;
    }

    function setTypeCat($typeCat) {
        $this->typeCat = $typeCat;
    }

    public function __toString() {
        return $this->title;
    }



}
