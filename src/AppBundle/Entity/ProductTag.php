<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductTag
 *
 * @ORM\Table(name="jC_ProductsTags", uniqueConstraints={@ORM\UniqueConstraint(name="product_tag", columns={"product_id", "tag_id"})})
 * @ORM\Entity
 */
class ProductTag
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
     * @var \AppBundle\Entity\Product
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Product", inversedBy="prdTg")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=true, onDelete="cascade")
     * })
     */
    private $product;

    /**
     * @var \AppBundle\Entity\Tag
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tag", inversedBy="tgPrd")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tag_id", referencedColumnName="id", nullable=false, onDelete="cascade")
     * })
     */
    private $tag;



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
     * Set product
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return ProductTag
     */
    public function setProduct(\AppBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \AppBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set tag
     *
     * @param \AppBundle\Entity\Tag $tag
     *
     * @return ProductTag
     */
    public function setTag(\AppBundle\Entity\Tag $tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return \AppBundle\Entity\Tag
     */
    public function getTag()
    {
        return $this->tag;
    }
}
