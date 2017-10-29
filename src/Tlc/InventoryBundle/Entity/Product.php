<?php

namespace Tlc\InventoryBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use TeamDeveloppe\UploadBundle\Annotation\Uploadable;
use TeamDeveloppe\UploadBundle\Annotation\UploadableField;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="Tlc\InventoryBundle\Repository\ProductRepository")
 * @Uploadable()
 */
class Product
{

   /**
    * Constructor
    */
   public function __construct()
   {
      $this->invoces = new ArrayCollection();
      $this->orderSaleProducts = new ArrayCollection();
   }


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
     * @ORM\Column(name="mark", type="string", length=255, nullable=true)
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
     * @ORM\Column(name="amount", type="integer", nullable=true)
     */
    private $amount;

    /**
     * @var string
     * @ORM\Column(name="filename", type="string", length=255)
     */
    private $filename;

    /**
     * @UploadableField(filename="filename", path="uploads")
     * @Assert\Image(maxWidth="2000", maxHeight = "2000")
     */
    private $file;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

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
     * @ORM\OneToMany(targetEntity="Tlc\InventoryBundle\Entity\Model" , mappedBy="product")
     */
    private $models;

    /**
    * @var Invoice[]
    *
    * @ORM\ManyToMany(targetEntity="Tlc\InventoryBundle\Entity\Invoice")
    */
    private $invoces;

   /**
    * @var OrderSaleProduct[]
    *
    * @ORM\OneToMany(targetEntity="Tlc\InventoryBundle\Entity\OrderSaleProduct", mappedBy="product")
    */
   private $orderSaleProducts;


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

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return File|null
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param File $file|null
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return mixed
     */
    public function getModels()
    {
        return $this->models;
    }

    /**
     * @param mixed $models
     */
    public function setModels($models)
    {
        $this->models = $models;
    }

    /**
     * Add model
     *
     * @param \Tlc\InventoryBundle\Entity\Model $model
     *
     * @return Product
     */
    public function addModel(\Tlc\InventoryBundle\Entity\Model $model)
    {
        $this->models[] = $model;

        return $this;
    }

    /**
     * Remove model
     *
     * @param \Tlc\InventoryBundle\Entity\Model $model
     */
    public function removeModel(\Tlc\InventoryBundle\Entity\Model $model)
    {
        $this->models->removeElement($model);
    }


    /**
     * Add orderSaleProduct
     *
     * @param \Tlc\InventoryBundle\Entity\OrderSaleProduct $orderSaleProduct
     *
     * @return Product
     */
    public function addOrderSaleProduct(\Tlc\InventoryBundle\Entity\OrderSaleProduct $orderSaleProduct)
    {
        $this->orderSaleProducts[] = $orderSaleProduct;

        return $this;
    }

    /**
     * Remove orderSaleProduct
     *
     * @param \Tlc\InventoryBundle\Entity\OrderSaleProduct $orderSaleProduct
     */
    public function removeOrderSaleProduct(\Tlc\InventoryBundle\Entity\OrderSaleProduct $orderSaleProduct)
    {
        $this->orderSaleProducts->removeElement($orderSaleProduct);
    }

    /**
     * Get orderSaleProducts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrderSaleProducts()
    {
        return $this->orderSaleProducts;
    }
}
