<?php declare (strict_types = 1);

namespace Corvus\Core;

class Jwt
{
    /**
     * @var EntityManager;
     */
    private $entityManager;
    /**
     * {@inheritdoc}
     */
    public static function create($email, $jwt_secret)
    {
        $factory = new \PsrJwt\Factory\Jwt();

        $builder = $factory->builder();
        $token = $builder->setSecret($jwt_secret)
            ->setPayloadClaim('email', $email)
            ->setExpiration(time() + 300000)
            ->setIssuedAt(time())
            ->build();
        return $token;
    }
}
