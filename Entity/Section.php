<?php
namespace Stems\PageBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;


/** 
 * @ORM\Entity
 * @ORM\Table(name="stm_page_section")
 */
class Section
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** 
     * @ORM\Column(type="integer")
     */
    protected $position = 1;

    /** 
     * @ORM\Column(type="integer")
     */
    protected $entity;

    /**
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="sections")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id")
     */
    protected $page;

    /**
     * @ORM\ManyToOne(targetEntity="SectionType", inversedBy="sections")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    protected $type;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set entity
     *
     * @param integer $entity
     * @return Section
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    
        return $this;
    }

    /**
     * Get entity
     *
     * @return integer 
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Section
     */
    public function setPosition($position)
    {
        $this->position = $position;
    
        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set page
     *
     * @param Stems\PageBundle\Entity\Page $page
     */
    public function setPage(\Stems\PageBundle\Entity\Page $page)
    {
        $this->page = $page;
    }

    /**
     * Get page
     *
     * @return Stems\PageBundle\Entity\Page 
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set type
     *
     * @param Stems\PageBundle\Entity\SectionType $type
     */
    public function setType(\Stems\PageBundle\Entity\SectionType $type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return Stems\PageBundle\Entity\SectionType 
     */
    public function getType()
    {
        return $this->type;
    }
}