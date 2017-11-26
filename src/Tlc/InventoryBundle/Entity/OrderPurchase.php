<?php

namespace Tlc\InventoryBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * OrderPurchase
 * @ORM\Table(name="OrderPurchase")
 * @ORM\Entity(repositoryClass="Tlc\InventoryBundle\Repository\OrderPurchaseRepository")
 *
 */
class OrderPurchase
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
     * @var \DateTime
     *
     * @ORM\Column(name="createdDate", type="datetime")
     */
    private $dateOrder;

    /**
     * @var Provider
     * @ORM\ManyToOne(targetEntity="Provider")
     */
    private $provider;

    /**
     *
     * @ORM\OneToMany(targetEntity="Tlc\InventoryBundle\Entity\OrderPurchaseProduct", mappedBy="orderpurchase")
     */
    private $orderpurchaseProducts;

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
     * @param \DateTime $dateOrder
     *
     * @return OrderPurchase
     */
    public function setDateOrder($dateOrder)
    {
        $this->dateOrder = $dateOrder;

        return $this;
    }

    /**
     * Get dateOrder
     *
     * @return \DateTime
     */
    public function getDateOrder()
    {
        return $this->dateOrder;
    }

    /**
     * @return Provider
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @param Provider $provider
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->orderpurchaseProducts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add orderpurchaseProduct
     *
     * @param \Tlc\InventoryBundle\Entity\OrderPurchaseProduct $orderpurchaseProduct
     *
     * @return OrderPurchase
     */
    public function addOrderpurchaseProduct(\Tlc\InventoryBundle\Entity\OrderPurchaseProduct $orderpurchaseProduct)
    {
        $this->orderpurchaseProducts[] = $orderpurchaseProduct;

        return $this;
    }

    /**
     * Remove orderpurchaseProduct
     *
     * @param \Tlc\InventoryBundle\Entity\OrderPurchaseProduct $orderpurchaseProduct
     */
    public function removeOrderpurchaseProduct(\Tlc\InventoryBundle\Entity\OrderPurchaseProduct $orderpurchaseProduct)
    {
        $this->orderpurchaseProducts->removeElement($orderpurchaseProduct);
    }

    /**
     * Get orderpurchaseProducts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrderpurchaseProducts()
    {
        return $this->orderpurchaseProducts;
    }

   /**
    * @return float|int
    */
   public function getTotalAmount()
   {
      $amounts = 0;

      foreach ($this->orderpurchaseProducts as $orderpurchaseProduct) {
         $amounts += $orderpurchaseProduct->getProduct()->getPrice() * $orderpurchaseProduct->getAmount();
      }
      return $amounts;
   }
}
