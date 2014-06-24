<?php
namespace Stems\PageBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;


/** 
 * @ORM\Entity
 * @ORM\Table(name="stm_page_section_magazine")
 */
class SectionMagazine
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** 
     * @ORM\Column(type="text", nullable=true)
     */
    protected $contentA;

    /** 
     * @ORM\Column(type="text", nullable=true)
     */
    protected $contentB;

    /** 
     * @ORM\Column(type="text", nullable=true)
     */
    protected $contentC;

    /** 
     * @ORM\Column(type="text", nullable=true)
     */
    protected $imageA;

    /** 
     * @ORM\Column(type="text", nullable=true)
     */
    protected $imageB;

    /** 
     * @ORM\Column(type="text", nullable=true)
     */
    protected $imageC;

    /** 
     * @ORM\Column(type="text", nullable=true)
     */
    protected $positionA = 'bottom';

    /** 
     * @ORM\Column(type="text", nullable=true)
     */
    protected $positionB = 'bottom';

    /** 
     * @ORM\Column(type="text", nullable=true)
     */
    protected $positionC = 'bottom';

    /** 
     * @ORM\Column(type="text", nullable=true)
     */
    protected $captionA;

    /** 
     * @ORM\Column(type="text", nullable=true)
     */
    protected $captionB;

    /** 
     * @ORM\Column(type="text", nullable=true)
     */
    protected $captionC;

    /** 
     * @ORM\Column(type="text", nullable=true)
     */
    protected $linkA;

    /** 
     * @ORM\Column(type="text", nullable=true)
     */
    protected $linkB;

    /** 
     * @ORM\Column(type="text", nullable=true)
     */
    protected $linkC;

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
     * Set contentA
     *
     * @param string $contentA
     * @return Section
     */
    public function setContentA($contentA)
    {
        $this->contentA = $contentA;
    
        return $this;
    }

    /**
     * Get contentA
     *
     * @return string 
     */
    public function getContentA()
    {
        return $this->contentA;
    }

    /**
     * Set contentB
     *
     * @param string $contentB
     * @return Section
     */
    public function setContentB($contentB)
    {
        $this->contentB = $contentB;
    
        return $this;
    }

    /**
     * Get contentB
     *
     * @return string 
     */
    public function getContentB()
    {
        return $this->contentB;
    }

    /**
     * Set contentC
     *
     * @param string $contentC
     * @return Section
     */
    public function setContentC($contentC)
    {
        $this->contentC = $contentC;
    
        return $this;
    }

    /**
     * Get contentC
     *
     * @return string 
     */
    public function getContentC()
    {
        return $this->contentC;
    }

    /**
     * Set imageA
     *
     * @param string $imageA
     * @return SectionMagazine
     */
    public function setImageA($imageA)
    {
        $this->imageA = $imageA;
    
        return $this;
    }

    /**
     * Get imageA
     *
     * @return string 
     */
    public function getImageA()
    {
        return $this->imageA;
    }

    /**
     * Set imageB
     *
     * @param string $imageB
     * @return SectionMagazine
     */
    public function setImageB($imageB)
    {
        $this->imageB = $imageB;
    
        return $this;
    }

    /**
     * Get imageB
     *
     * @return string 
     */
    public function getImageB()
    {
        return $this->imageB;
    }

    /**
     * Set imageC
     *
     * @param string $imageC
     * @return SectionMagazine
     */
    public function setImageC($imageC)
    {
        $this->imageC = $imageC;
    
        return $this;
    }

    /**
     * Get imageC
     *
     * @return string 
     */
    public function getImageC()
    {
        return $this->imageC;
    }

    /**
     * Set positionA
     *
     * @param string $positionA
     * @return SectionMagazine
     */
    public function setPositionA($positionA)
    {
        $this->positionA = $positionA;
    
        return $this;
    }

    /**
     * Get positionA
     *
     * @return string 
     */
    public function getPositionA()
    {
        return $this->positionA;
    }

    /**
     * Set positionB
     *
     * @param string $positionB
     * @return SectionMagazine
     */
    public function setPositionB($positionB)
    {
        $this->positionB = $positionB;
    
        return $this;
    }

    /**
     * Get positionB
     *
     * @return string 
     */
    public function getPositionB()
    {
        return $this->positionB;
    }

    /**
     * Set positionC
     *
     * @param string $positionC
     * @return SectionMagazine
     */
    public function setPositionC($positionC)
    {
        $this->positionC = $positionC;
    
        return $this;
    }

    /**
     * Get positionC
     *
     * @return string 
     */
    public function getPositionC()
    {
        return $this->positionC;
    }

    /**
     * Set captionA
     *
     * @param string $captionA
     * @return SectionMagazine
     */
    public function setCaptionA($captionA)
    {
        $this->captionA = $captionA;
    
        return $this;
    }

    /**
     * Get captionA
     *
     * @return string 
     */
    public function getCaptionA()
    {
        return $this->captionA;
    }

    /**
     * Set captionB
     *
     * @param string $captionB
     * @return SectionMagazine
     */
    public function setCaptionB($captionB)
    {
        $this->captionB = $captionB;
    
        return $this;
    }

    /**
     * Get captionB
     *
     * @return string 
     */
    public function getCaptionB()
    {
        return $this->captionB;
    }

    /**
     * Set captionC
     *
     * @param string $captionC
     * @return SectionMagazine
     */
    public function setCaptionC($captionC)
    {
        $this->captionC = $captionC;
    
        return $this;
    }

    /**
     * Get captionC
     *
     * @return string 
     */
    public function getCaptionC()
    {
        return $this->captionC;
    }

    /**
     * Set linkA
     *
     * @param string $linkA
     * @return SectionMagazine
     */
    public function setLinkA($linkA)
    {
        $this->linkA = $linkA;
    
        return $this;
    }

    /**
     * Get linkA
     *
     * @return string 
     */
    public function getLinkA()
    {
        return $this->linkA;
    }

    /**
     * Set linkB
     *
     * @param string $linkB
     * @return SectionMagazine
     */
    public function setLinkB($linkB)
    {
        $this->linkB = $linkB;
    
        return $this;
    }

    /**
     * Get linkB
     *
     * @return string 
     */
    public function getLinkB()
    {
        return $this->linkB;
    }

    /**
     * Set linkC
     *
     * @param string $linkC
     * @return SectionMagazine
     */
    public function setLinkC($linkC)
    {
        $this->linkC = $linkC;
    
        return $this;
    }

    /**
     * Get linkC
     *
     * @return string 
     */
    public function getLinkC()
    {
        return $this->linkC;
    }
}