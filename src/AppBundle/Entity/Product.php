<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Util\Debug;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use AppBundle\Entity\ProductTag;

/**
 * Product
 *
 * @ORM\Table(name="jC_Products")
 * @ORM\Entity
 */
class Product
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", scale=100)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="date", type="integer")
     */
    private $date;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ProductTag", mappedBy="product", cascade={"all"})
     */
    private $prdTg;

    private $tags;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->prdTg = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }


    public function __toString()
    {
        return $this->name;
    }


    /*
     * Get Tags
     *
     * @return ArrayCollection
     */
    public function getTag()
    {
        $tags = new ArrayCollection();

        foreach($this->prdTg as $tg)
        {
            $tags[] = $tg->getTag();
        }

        return $tags;
    }

    /*
     * Set Tags
     *
     * @param Array $tags
     */
    public function setTag($tags)
    {
        foreach($tags as $t)
        {
            $pt = new ProductTag();

            $pt->setProduct($this);
            $pt->setTag($t);

            $this->addPrdTg($pt);

        }

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
     * Set name
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Product
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
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set date
     *
     * @param integer $date
     *
     * @return Product
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return integer
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Add prdTg
     *
     * @param \AppBundle\Entity\ProductTag $prdTg
     *
     * @return Product
     */
    public function addPrdTg($prdTg)
    {
        $this->prdTg[] = $prdTg;

        return $this;
    }

    /**
     * Remove prdTg
     *
     * @param \AppBundle\Entity\ProductTag $prdTg
     */
    public function removePrdTg($prdTg)
    {
        $this->prdTg->removeElement($prdTg);
    }

    /**
     * Get prdTg
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPrdTg()
    {
        return $this->prdTg;
    }

    // check if it's selected at least one tag (create & update product)
    public function validate(ExecutionContextInterface $context, $payload){
        if($this->getTag()->isEmpty()){
            $context->buildViolation('You must select at least one tag!')
                ->atPath('tag')
                ->addViolation();
        }
    }
}
