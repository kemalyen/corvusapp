<?php

namespace Corvus\Services;

use Corvus\Entities\User;
use Corvus\Exceptions\ConstraintViolationException;
use Corvus\Exceptions\GeneralException;
use Corvus\Exceptions\UniqueConstraintViolationException as DuplicatedEmail;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Validation;

class UserService
{
    /**
     * @var EntityManager;
     */
    private $entityManager;

    /**
     * @Inject
     * @var Psr\Log\LoggerInterface
     */
    private $logger;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getUser(string $email, string $password)
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(array('email' => $email, 'password' => md5($password)));
        return $user;
    }

    public function getUserByEmail(string $email)
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(array('email' => $email));
        return $user;
    }

    public function create($request)
    {
        $user = new User;
        $user->setEmail($request['email']);
        $user->setPassword(md5($request['password']));

        $validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();

        $violations = $validator->validate($user);

        if (0 !== count($violations)) {
            // there are errors, now you can show them
            foreach ($violations as $violation) {
                var_dump($violation->getMessage());
                throw new ConstraintViolationException($violation->getMessage());
            }
        }

        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch(\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
            throw new DuplicatedEmail($e);
     
        } catch (DBALException $e) {
            throw new GeneralException($e);
        } catch (\Exception $e) {
            throw new GeneralException($e);
        } catch (UniqueConstraintViolationException $e) {
            throw new DuplicatedEmail($e);
        } catch (PDOException $e){
            throw new DuplicatedEmail($e);
        }  
 
    }
}
