<?php
namespace Stems\PageBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;
use Stems\CoreBundle\Definition\SectionInstanceInterface;

/** 
 * @ORM\Entity
 * @ORM\Table(name="stm_page_section_image")
 */
class SectionImage implements SectionInstanceInterface
{
	/** 
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/** 
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $image;

	/** 
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $position = 'center';

	/** 
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $caption;

	/** 
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $link;

	/**
	 * Build the html for rendering in the front end, using any nessary custom code
	 *
	 * @param  Sections 	$services  	The section manager service
	 * @param  Section 		$link  		The section link entity
	 * @return string 					The rendered section html
	 */
	public function render($services, $link)
	{
		// Render the twig template
		return $services->getTwig()->render('StemsBlogBundle:Section:image.html.twig', array(
			'section'   => $this,
			'link'      => $link,
		));
	}

	/**
	 * Build the html for admin editor form
	 *
	 * @param  Sections 	$services  	The section manager service
	 * @param  Section 		$link  		The section link entity
	 * @return string 					The rendered html for the section admin form
	 */
	public function editor($services, $link)
	{
		// Build the section from using the generic builder method
		$form = $services->createSectionForm($link, $this);

		// Render the admin form html
		return $services->getTwig()->render('StemsBlogBundle:Section:imageForm.html.twig', array(
			'form'      => $form->createView(),
			'section'	=> $this,
			'link'      => $link,
		));
	}

	/**
	 * Update the section from posted data
	 *
	 * @param  Sections 	$services  		The section manager service
	 * @param  array 		$parameters 	Posted parameters for this section's form
	 * @param  Request  	$request 		The request object
	 * @param  Section 		$link  			The section link entity
	 */
	public function save($services, $parameters, $request, $link)
	{
		// Save the values
		$this->setImage($parameters['image']);
		$this->setCaption($parameters['caption']);
		$this->setPosition($parameters['position']);
		$this->setLink($parameters['link']);
		
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
	 * Set image
	 *
	 * @param string $image
	 * @return SectionImage
	 */
	public function setImage($image)
	{
		$this->image = $image;
	
		return $this;
	}

	/**
	 * Get image
	 *
	 * @return string 
	 */
	public function getImage()
	{
		return $this->image;
	}

	/**
	 * Set position
	 *
	 * @param string $position
	 * @return SectionImage
	 */
	public function setPosition($position)
	{
		$this->position = $position;
	
		return $this;
	}

	/**
	 * Get position
	 *
	 * @return string 
	 */
	public function getPosition()
	{
		return $this->position;
	}

	/**
	 * Set caption
	 *
	 * @param string $caption
	 * @return SectionImage
	 */
	public function setCaption($caption)
	{
		$this->caption = $caption;
	
		return $this;
	}

	/**
	 * Get caption
	 *
	 * @return string 
	 */
	public function getCaption()
	{
		return $this->caption;
	}

	/**
	 * Set link
	 *
	 * @param string $link
	 * @return SectionImage
	 */
	public function setLink($link)
	{
		$this->link = $link;
	
		return $this;
	}

	/**
	 * Get link
	 *
	 * @return string 
	 */
	public function getLink()
	{
		return $this->link;
	}
}