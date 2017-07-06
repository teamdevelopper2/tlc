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
    * @ORM\ManyToMany(targetEntity="Tlc\UserBundle\Entity\Profil", cascade={"persist"})
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
    * Get all roles + ROLE_DEFAULT of the current user
    *
    * @return \Doctrine\Common\Collections\Collection
    */
   public function getRoles()
   {
      return array_unique(array_merge($this->profils->toArray(), [new Profil(parent::ROLE_DEFAULT)]));
   }

   /**
    * Pass a string, get the desired Profil object or null.
    *
    * @param $roleName
    * @return null|Profil
    * @internal param string $role
    */
   public function getRole($roleName)
   {
      foreach ($this->getRoles() as $profil)
      {
         if($roleName == $profil->getRole())
         {
            return $profil;
         }
      }
      return null;
   }

   /**
    * @param string $roleName
    * @return bool
    * @internal param string $role
    */
   public function hasRole($roleName)
   {
      if($this->getRole($roleName))
         return true;
      return false;
   }

   /**
    * Add profil
    *
    * @param Profil $profil
    * @return User
    * @throws \Exception
    * @internal param Profil $profil
    */
   public function addRole($profil)
   {
      if(!$profil instanceof Profil)
      {
         throw new \Exception("addRole takes a Profil object as the parameter");
      }
      if($this->hasRole($profil->getRole()))
      {
         return $this;
      }
      $this->profils->add($profil);

      return $this;
   }

   /**
    * Pass an ARRAY of Role objects and will clear the collection and re-set it with new Roles.
    * Type hinted array due to interface.
    * @param array $profils
    * @return mixed
    * @internal param array $roles Of Role objects.
    */
   public function setRoles(array $profils)
   {
      $this->profils->clear();
      foreach ($profils as $profil)
      {
         $this->addRole($profil);
      }
      return $this;
   }


   /**
    * @param string $role
    * @return $this|\FOS\UserBundle\Model\UserInterface|void
    */
   public function removeRole($role)
   {
      $profil = $this->getRole($role);
      if ($profil) {
         $this->profils->removeElement($profil);
      }
      return $this;
   }


   /**
    * Returns the true ArrayCollection of Roles.
    */
   public function getRolesCollection()
   {
      return $this->profils;
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
