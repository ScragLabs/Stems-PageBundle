<?php

namespace Stems\PageBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;
use Stems\CoreBundle\Definition\SectionInstanceInterface;

/** 
 * @ORM\Entity
 * @ORM\Table(name="stm_page_section_heading")
 */
class SectionHeading implements SectionInstanceInterface
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
    protected $content;

    /** 
     * @ORM\Column(type="text")
     */
    protected $style = 'h6';

    /** 
     * @ORM\Column(type="text", length=16)
     */
    protected $alignment = 'left';

    /**
     * Build the html for rendering in the front end, using any necessary custom code
     */
    public function render($services, $link)
    {
        // render the twig template
        return $services->getTwig()->render('StemsPageBundle:Section:heading.html.twig', array(
            'section'   => $this,
            'link'      => $link,
        ));
    }

    /**
     * Build the html for admin editor form
     */
    public function editor($services, $link)
    {
        // build the section from using the generic builder method
        $form = $services->createSectionForm($link, $this);

        // render the admin form html
        return $services->getTwig()->render('StemsPageBundle:Section:headingForm.html.twig', array(
            'form'      => $form->createView(),
	        'section'   => $this,
            'link'      => $link,
        ));
    }

    /**
     * Update the section from posted data
     */
    public function save($services, $parameters, $request, $link)
    {
        // save the values
        $this->setContent(stripslashes($parameters['content']));
	    $this->setAlignment(stripslashes($parameters['alignment']));
	    $this->setStyle(stripslashes($parameters['style']));

        $services->getManager()->persist($this);
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
     * Set content
     *
     * @param string $content
     * @return Section
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
     * Set style
     *
     * @param string $style
     * @return Section
     */
    public function setStyle($style)
    {
        $this->style = $style;
    
        return $this;
    }

    /**
     * Get style
     *
     * @return string 
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Set alignment
     *
     * @param string $alignment
     * @return Section
     */
    public function setAlignment($alignment)
    {
        $this->alignment = $alignment;
    
        return $this;
    }

    /**
     * Get alignment
     *
     * @return string 
     */
    public function getAlignment()
    {
        return $this->alignment;
    }
}