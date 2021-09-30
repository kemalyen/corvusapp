<?php
namespace Corvus\Entities;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Corvus\Exceptions\UniqueUserEmailException;
use Doctrine\ORM\HasLifecycleCallbacks;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="users",uniqueConstraints={@ORM\UniqueConstraint(name="unique_email", fields={"email"})})
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\Email
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;


    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
    * @Orm\PrePersist @Orm\PreUpdate
     */
    public function assertUniqueUserEmail(LifecycleEventArgs $eventArgs) {

        $entity = $eventArgs->getEntity();
        $em = $eventArgs->getEntityManager();
        $user = $em->getRepository(User::class)->findBy(['email' => $this->email]);
        if($user){
            throw new UniqueUserEmailException('user email must be unique: '. $this->email);
        }
    }    
}
