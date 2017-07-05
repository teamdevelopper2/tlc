<?php

namespace Tlc\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Tlc\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

   /**
    * @var Profil[]
    *
    * @ORM\ManyToMany(targetEntity="Tlc\UserBundle\Entity\Profil")
    */
    protected $profils;


    public function __construct()
    {
       parent::__construct();
       $this->profils = new ArrayCollection();
    }

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
     * Add profil
     *
     * @param \Tlc\UserBundle\Entity\Profil $profil
     *
     * @return User
     */
    public function addProfil(\Tlc\UserBundle\Entity\Profil $profil)
    {
        $this->profils[] = $profil;

        return $this;
    }

    /**
     * Remove profil
     *
     * @param \Tlc\UserBundle\Entity\Profil $profil
     */
    public function removeProfil(\Tlc\UserBundle\Entity\Profil $profil)
    {
        $this->profils->removeElement($profil);
    }

    /**
     * Get profils
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProfils()
    {
        return $this->profils;
    }
}
