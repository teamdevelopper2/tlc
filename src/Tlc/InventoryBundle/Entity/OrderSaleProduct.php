<?php

namespace Tlc\InventoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderSaleProduct
 *
 * @ORM\Table(name="order_sale_product")
 * @ORM\Entity(repositoryClass="Tlc\InventoryBundle\Repository\OrderSaleProductRepository")
 */
class OrderSaleProduct
{

   /**
    * @ORM\Id()
    * @ORM\ManyToOne(targetEntity="Tlc\InventoryBundle\Entity\Product", inversedBy="orderSaleProducts")
    * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false)
    */
   protected $product;


   /**
    * @ORM\Id()
    * @ORM\ManyToOne(targetEntity="Tlc\InventoryBundle\Entity\OrderSale", inversedBy="orderSaleProducts")
    * @ORM\JoinColumn(name="order_sale_id", referencedColumnName="id", nullable=false)
    */
   protected $orderSale;


   /**
    * @var int
    *
    * @ORM\Column(name="amount", type="integer", nullable=true)
    */
   protected $amount;

    /**
     * Set amount
     *
     * @param integer $amount
     *
     * @return OrderSaleProduct
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set product
     *
     * @param \Tlc\InventoryBundle\Entity\Product $product
     *
     * @return OrderSaleProduct
     */
    public function setProduct(\Tlc\InventoryBundle\Entity\Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Tlc\InventoryBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set orderSale
     *
     * @param \Tlc\InventoryBundle\Entity\OrderSale $orderSale
     *
     * @return OrderSaleProduct
     */
    public function setOrderSale(\Tlc\InventoryBundle\Entity\OrderSale $orderSale)
    {
        $this->orderSale = $orderSale;

        return $this;
    }

    /**
     * Get orderSale
     *
     * @return \Tlc\InventoryBundle\Entity\OrderSale
     */
    public function getOrderSale()
    {
        return $this->orderSale;
    }
}
