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
     * Get all roles + ROLE_DEFAULT of the current user
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoles()
    {
        return array_merge($this->profils->toArray(), [new Profil(parent::ROLE_DEFAULT)]);
    }

   /**
    * @param string $role
    * @return bool
    */
   public function hasRole($role)
    {
       if($this->getRole($role))
          return true;
       return false;
    }

   /**
    * Add profil
    *
    * @param Profil $role
    * @return User
    * @throws \Exception
    * @internal param Profil $profil
    */
   public function addRole($role)
   {
      if(!$role instanceof Profil)
      {
         throw new \Exception("addRole takes a Profil object as the parameter");
      }
      if($this->hasRole($role->getRole()))
      {
         $this->profils->add($role);
      }
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
   }


   /**
    * Pass a string, get the desired Role object or null.
    *
    * @param string $role
    * @return Profil|null
    */
   public function getRole($role)
   {
      foreach ($this->getRoles() as $profil)
      {
         if ($role == $profil->getRole())
         {
            return $profil;
         }
      }
      return null;
   }

   /**
    * Returns the true ArrayCollection of Roles.
    */
   public function getRolesCollection()
   {
      return $this->profils;
   }

   /**
    * Directly set the ArrayCollection of Roles. Type hinted as Collection which is the parent of (Array|Persistent)Collection.
    * @param Collection $collection
    */
   public function setRolesCollection(Collection $collection)
   {
      $this->profils = $collection;
   }

}
