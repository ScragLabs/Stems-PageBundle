<?php
namespace Stems\PageBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;


/** 
 * @ORM\Entity(repositoryClass="Stems\PageBundle\Repository\PageRepository")
 * @ORM\Table(name="stm_page_page")
 */
class Page
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** 
     * @ORM\Column(type="string", nullable=true)
     */
    protected $slug;

    /**
     * @ORM\ManyToOne(targetEntity="Layout", inversedBy="pages")
     * @ORM\JoinColumn(name="layout_id", referencedColumnName="id")
     */
    protected $layout;

    /**
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity="Page", mappedBy="parent")
     */
    protected $children; 

    /** 
     * @ORM\Column(type="string")
     */
    protected $type = 'content';

    /** 
     * @ORM\Column(type="string", length=64)
     */
    protected $title;

    /** 
     * @ORM\Column(type="string", length=64)
     */
    protected $windowTitle;

    /** 
     * @ORM\Column(type="text", length=512, nullable=true)
     */
    protected $excerpt;

    /** 
     * @ORM\Column(type="text", nullable=true)
     */
    protected $content;

    /** 
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $image;

    /** 
     * @ORM\Column(type="string", nullable=true)
     */
    protected $author;

    /**
     * @ORM\Column(type="string") 
     */
    protected $status = 'Draft';

    /**
     * @ORM\Column(type="boolean")
     */
    protected $deleted = false;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $showInMenu = true;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $noIndex = false;

    /** 
     * @ORM\Column(type="string", nullable=true)
     */
    protected $metaTitle;

    /** 
     * @ORM\Column(type="string", nullable=true)
     */
    protected $metaKeywords;

    /** 
     * @ORM\Column(type="string", nullable=true)
     */
    protected $metaDescription;

    protected $disableAnalytics = false;

    /** 
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /** 
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    /**
     * @ORM\OneToMany(targetEntity="Section", mappedBy="page")
     */
    protected $sections; 

    public function __construct()
    {
        $this->created = new \DateTime;
        $this->updated = new \DateTime;
    }

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
     * Set slug
     *
     * @param string $slug
     * @return Page
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        // override slug if the homepage is requested
        if ($this->slug == 'homepage') {
            return '/';
        } else {
            return $this->slug;
        }
    }

    /**
     * Set layout
     *
     * @param Layout $layout
     */
    public function setLayout(Layout $layout)
    {
        $this->layout = $layout;
    }

    /**
     * Get layout
     *
     * @return Layout
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * Set parent
     *
     * @param Page $parent
     */
    public function setParent(Page $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Get parent
     *
     * @return Page
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param Stems\childrenBundle\Entity\Page $children
     */
    public function addChildren(Page $children)
    {
        $this->children[] = $children;
    }

    /**
     * Get children
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Page
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Page
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set image
     *
     * @param integer $image
     * @return Page
     */
    public function setImage($image)
    {
        $this->image = $image;
    
        return $this;
    }

    /**
     * Get image
     *
     * @return integer 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set windowTitle
     *
     * @param string $windowTitle
     * @return Page
     */
    public function setWindowTitle($windowTitle)
    {
        $this->windowTitle = $windowTitle;
    
        return $this;
    }

    /**
     * Get windowTitle
     *
     * @return string 
     */
    public function getWindowTitle()
    {
        return $this->windowTitle;
    }

    /**
     * Set excerpt
     *
     * @param string $excerpt
     * @return Page
     */
    public function setExcerpt($excerpt)
    {
        $this->excerpt = $excerpt;
    
        return $this;
    }

    /**
     * Get excerpt
     *
     * @return string 
     */
    public function getExcerpt()
    {
        return $this->excerpt;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Page
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Page
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return Page
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    
        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean 
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set showInMenu
     *
     * @param boolean $showInMenu
     * @return Page
     */
    public function setShowInMenu($showInMenu)
    {
        $this->showInMenu = $showInMenu;
    
        return $this;
    }

    /**
     * Get showInMenu
     *
     * @return boolean 
     */
    public function getShowInMenu()
    {
        return $this->showInMenu;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Page
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    
        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set created
     *
     * @param datetime $created
     * @return Page
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return integer 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param datetime $updated
     * @return Page
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return integer 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Add section
     *
     * @param Section $section
     */
    public function addSection(Section $section)
    {
        $this->sections[] = $section;
    }

    /**
     * Get sections
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * Set noIndex
     *
     * @param boolean $noIndex
     * @return Page
     */
    public function setNoIndex($noIndex)
    {
        $this->noIndex = $noIndex;
    
        return $this;
    }

    /**
     * Get noIndex
     *
     * @return boolean 
     */
    public function getNoIndex()
    {
        return $this->noIndex;
    }

    /**
     * Set metaTitle
     *
     * @param string $metaTitle
     * @return Page
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
     * Set metaKeywords
     *
     * @param string $metaKeywords
     * @return Page
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;
    
        return $this;
    }

    /**
     * Get metaKeywords
     *
     * @return string 
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     * @return Page
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
     * Set disableAnalytics
     *
     * @param boolean $disableAnalytics
     * @return Page
     */
    public function setDisableAnalytics($disableAnalytics)
    {
        $this->disableAnalytics = $disableAnalytics;
    
        return $this;
    }

    /**
     * Get disableAnalytics
     *
     * @return boolean 
     */
    public function getDisableAnalytics()
    {
        return $this->disableAnalytics;
    }
}