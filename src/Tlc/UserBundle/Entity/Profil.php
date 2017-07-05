<?php

namespace Tlc\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * Profil
 *
 * @ORM\Table(name="profil")
 * @ORM\Entity(repositoryClass="Tlc\UserBundle\Repository\ProfilRepository")
 */
class Profil implements RoleInterface
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
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=255, unique=true)
     */
    protected $role;

   /**
    * @var User[]
    *
    * @ORM\ManyToMany(targetEntity="Tlc\UserBundle\Entity\User")
    */
    private $users;

   /**
    * Profil constructor.
    * @param $role
    */
   function __construct($role)
   {
       $this->role = $role;
       $this->users = new ArrayCollection();
   }


   /**
    * @return int
    */
   public function getId()
   {
      return $this->id;
   }

   /**
    * @param $role
    * @return $this
    */
   public function setRole($role)
   {
      $this->role = $role;

      return $this;
   }

   /**
    * @return string
    */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Add user
     *
     * @param \Tlc\UserBundle\Entity\User $user
     *
     * @return Profil
     */
    public function addUser(\Tlc\UserBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \Tlc\UserBundle\Entity\User $user
     */
    public function removeUser(\Tlc\UserBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
