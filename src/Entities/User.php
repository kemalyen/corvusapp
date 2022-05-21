<?php
namespace Corvus\Entities;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Corvus\Exceptions\UniqueUserEmailException;
use Doctrine\ORM\HasLifecycleCallbacks;
use Doctrine\ORM\Event\LifecycleEventArgs;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Column;

 
#[Entity]
#[Table('users')]
class User
{
    #[Id]
    #[Column, GeneratedValue]
    private int $id;

    #[Column(name: 'email', unique: true)]
    protected string $email;

    #[Column]
    private string $password;


    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email): User
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword(): User
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password): User
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
