<?php declare (strict_types = 1);

namespace Corvus\Core;

class Jwt
{
    /**
     * {@inheritdoc}
     */
    public static function create($email)
    {
        $factory = new \PsrJwt\Factory\Jwt();

        $builder = $factory->builder();
        $token = $builder->setSecret('!secReT$123*')
            ->setPayloadClaim('email', $email)
            ->setExpiration(time() + 300000)
            ->setIssuedAt(time())
            ->build();
        return $token;
    }
}
