<?php

namespace Tlc\InventoryBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * OrderSale
 *
 * @ORM\Table(name="ordersale")
 * @ORM\Entity(repositoryClass="Tlc\InventoryBundle\Repository\OrderSaleRepository")
 */
class OrderSale
{

   public function __construct()
   {
      $this->orderSaleProducts = new ArrayCollection();
      $this->status = false;
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
    * @ORM\Column(name="dateOrder", type="datetime")
    */
   private $dateOrder;

   /**
    * @var Client
    *
    * @ORM\ManyToOne(targetEntity="Tlc\InventoryBundle\Entity\Client", inversedBy="orderSales")
    */
   private $client;

   /**
    * @var OrderSaleProduct[]
    *
    * @ORM\OneToMany(targetEntity="Tlc\InventoryBundle\Entity\OrderSaleProduct", mappedBy="orderSale")
    */
   private $orderSaleProducts;

    /**
     * @var boolean
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;


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
    * Set dateOrder
    *
    * @param string $dateOrder
    *
    * @return OrderSale
    */
   public function setDateOrder($dateOrder)
   {
      $this->dateOrder = $dateOrder;

      return $this;
   }

    /**
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param bool $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }



   /**
    * Get dateOrder
    *
    * @return string
    */
   public function getDateOrder()
   {
      return $this->dateOrder;
   }

   /**
    * Set client
    *
    * @param \Tlc\InventoryBundle\Entity\Client $client
    *
    * @return OrderSale
    */
   public function setClient(\Tlc\InventoryBundle\Entity\Client $client = null)
   {
      $this->client = $client;

      return $this;
   }

   /**
    * Get client
    *
    * @return \Tlc\InventoryBundle\Entity\Client
    */
   public function getClient()
   {
      return $this->client;
   }

    /**
     * Add orderSaleProduct
     *
     * @param \Tlc\InventoryBundle\Entity\OrderSaleProduct $orderSaleProduct
     *
     * @return OrderSale
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

   /**
    * @return float|int
    */
   public function getTotalAmount()
    {
       $amounts = 0;

       foreach ($this->orderSaleProducts as $orderSaleProduct) {
          $amounts += $orderSaleProduct->getProduct()->getPrice() * $orderSaleProduct->getAmount();
       }
       return $amounts;
    }
}
