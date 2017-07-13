<?php

namespace Tlc\UserBundle\Entity;

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
    private $role;

   /**
    * @var string
    *
    * @ORM\Column(name="description", type="string", length=255, nullable=true)
    */
    private $description;


   /**
    * Profil constructor.
    * @param $role
    */
   function __construct($role)
   {
       $this->role = strtoupper($role);
   }


   /**
    * @return int
    */
   public function getId()
   {
      return $this->id;
   }

   /**
    * @param string $role
    * @return $this
    */
   public function setRole($role)
   {
      $this->role = strtoupper($role);

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
    * @return string
    */
   public function getDescription()
   {
      return $this->description;
   }

   /**
    * @param string $description
    */
   public function setDescription($description)
   {
      $this->description = $description;
   }



    function __toString()
    {
       return $this->role;
    }

}
