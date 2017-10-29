<?php

namespace Tlc\InventoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderPurchaseProduct
 *
 * @ORM\Table(name="orderpurchase_product")
 * @ORM\Entity(repositoryClass="Tlc\InventoryBundle\Repository\OrderPurchaseProductRepository")
 */
class OrderPurchaseProduct
{

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer", nullable=true)
     */
    private $amount;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Tlc\InventoryBundle\Entity\Product", inversedBy="orderpurchaseProducts")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false)
     */
    private $product;
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Tlc\InventoryBundle\Entity\OrderPurchase", inversedBy="orderpurchaseProducts")
     * @ORM\JoinColumn(name="orderpurchase_id", referencedColumnName="id", nullable=false)
     */
    private $orderpurchase;

    /**
     * Set amount
     *
     * @param integer $amount
     *
     * @return OrderPurchaseProduct
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
     * Set product
     *
     * @param \Tlc\InventoryBundle\Entity\Product $product
     *
     * @return OrderPurchaseProduct
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
     * Set orderpurchase
     *
     * @param \Tlc\InventoryBundle\Entity\OrderPurchase $orderpurchase
     *
     * @return OrderPurchaseProduct
     */
    public function setOrderpurchase(\Tlc\InventoryBundle\Entity\OrderPurchase $orderpurchase)
    {
        $this->orderpurchase = $orderpurchase;

        return $this;
    }

    /**
     * Get orderpurchase
     *
     * @return \Tlc\InventoryBundle\Entity\OrderPurchase
     */
    public function getOrderpurchase()
    {
        return $this->orderpurchase;
    }
}
