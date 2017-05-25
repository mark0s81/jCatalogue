<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tag
 *
 * @ORM\Table(name="jC_Tags")
 * @ORM\Entity
 */
class Tag
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
     * @ORM\Column(name="name", type="string", length=100, unique=true)
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ProductTag", mappedBy="tag", cascade={"all"})
     */
    private $tgPrd;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tgPrd = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Tag
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
     * Add tgPrd
     *
     * @param \AppBundle\Entity\ProductTag $tgPrd
     *
     * @return Tag
     */
    public function addTgPrd(\AppBundle\Entity\ProductTag $tgPrd)
    {
        $this->tgPrd[] = $tgPrd;

        return $this;
    }

    /**
     * Remove tgPrd
     *
     * @param \AppBundle\Entity\ProductTag $tgPrd
     */
    public function removeTgPrd(\AppBundle\Entity\ProductTag $tgPrd)
    {
        $this->tgPrd->removeElement($tgPrd);
    }

    /**
     * Get tgPrd
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTgPrd()
    {
        return $this->tgPrd;
    }

    public function __toString()
    {
        return $this->name;
    }
}
