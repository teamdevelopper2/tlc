<?php

namespace Tlc\InventoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="Tlc\InventoryBundle\Repository\ProductRepository")
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=255)
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="mark", type="string", length=255)
     */
    private $mark;

    /**
     * @var string
     *
     * @ORM\Column(name="designation", type="string", length=255)
     */
    private $designation;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;

   /**
    * @var Category
    *
    * @ORM\ManyToOne(targetEntity="Tlc\InventoryBundle\Entity\Category")
    */
    private $category;

   /**
    * @var Provider
    *
    * @ORM\ManyToOne(targetEntity="Tlc\InventoryBundle\Entity\Provider")
    */
    private $provider;

   /**
    * @var Invoice[]
    *
    * @ORM\ManyToMany(targetEntity="Tlc\InventoryBundle\Entity\Invoice")
    */
    private $invoces;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return Product
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set mark
     *
     * @param string $mark
     *
     * @return Product
     */
    public function setMark($mark)
    {
        $this->mark = $mark;

        return $this;
    }

    /**
     * Get mark
     *
     * @return string
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * Set designation
     *
     * @param string $designation
     *
     * @return Product
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * Get designation
     *
     * @return string
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set amount
     *
     * @param integer $amount
     *
     * @return Product
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->invoces = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set category
     *
     * @param \Tlc\InventoryBundle\Entity\Category $category
     *
     * @return Product
     */
    public function setCategory(\Tlc\InventoryBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Tlc\InventoryBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set provider
     *
     * @param \Tlc\InventoryBundle\Entity\Provider $provider
     *
     * @return Product
     */
    public function setProvider(\Tlc\InventoryBundle\Entity\Provider $provider = null)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Get provider
     *
     * @return \Tlc\InventoryBundle\Entity\Provider
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Add invoce
     *
     * @param \Tlc\InventoryBundle\Entity\Invoice $invoce
     *
     * @return Product
     */
    public function addInvoce(\Tlc\InventoryBundle\Entity\Invoice $invoce)
    {
        $this->invoces[] = $invoce;

        return $this;
    }

    /**
     * Remove invoce
     *
     * @param \Tlc\InventoryBundle\Entity\Invoice $invoce
     */
    public function removeInvoce(\Tlc\InventoryBundle\Entity\Invoice $invoce)
    {
        $this->invoces->removeElement($invoce);
    }

    /**
     * Get invoces
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInvoces()
    {
        return $this->invoces;
    }
}