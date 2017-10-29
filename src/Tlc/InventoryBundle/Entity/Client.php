<?php

namespace Tlc\InventoryBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="Tlc\InventoryBundle\Repository\ClientRepository")
 */
class Client
{

   public function __construct()
   {
      $this->orderSales = new ArrayCollection();
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
     * @ORM\Column(name="fisrtname", type="string", length=255)
     */
    private $fisrtname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var OrderSale[]
     *
     * @ORM\OneToMany(targetEntity="Tlc\InventoryBundle\Entity\OrderSale", mappedBy="client")
     */
    private $orderSales;


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
     * Set fisrtname
     *
     * @param string $fisrtname
     *
     * @return Client
     */
    public function setFisrtname($fisrtname)
    {
        $this->fisrtname = $fisrtname;

        return $this;
    }

    /**
     * Get fisrtname
     *
     * @return string
     */
    public function getFisrtname()
    {
        return $this->fisrtname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Client
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Client
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Client
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Client
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Add orderSale
     *
     * @param \Tlc\InventoryBundle\Entity\OrderSale $orderSale
     *
     * @return Client
     */
    public function addOrderSale(\Tlc\InventoryBundle\Entity\OrderSale $orderSale)
    {
        $this->orderSales[] = $orderSale;

        return $this;
    }

    /**
     * Remove orderSale
     *
     * @param \Tlc\InventoryBundle\Entity\OrderSale $orderSale
     */
    public function removeOrderSale(\Tlc\InventoryBundle\Entity\OrderSale $orderSale)
    {
        $this->orderSales->removeElement($orderSale);
    }

    /**
     * Get orderSales
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrderSales()
    {
        return $this->orderSales;
    }
}
