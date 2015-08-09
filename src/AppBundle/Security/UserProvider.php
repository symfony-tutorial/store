<?php

namespace AppBundle\Security;

use AppBundle\Service\JsonRpcClient;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{

    const ID = 'app.user_provider';

    private $jsonRpcClient;

    public function __construct(JsonRpcClient $client) {
        $this->jsonRpcClient = $client;
    }

    public function loadUserByUsername($username) {
        $result = $this->jsonRpcClient->call(
                'loadUserByUsername',
                array('username' => $username)
        );
        $user = $result->result;
        return new User($user->username, $user->password, $user->roles);
    }

    public function refreshUser(UserInterface $user) {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
            sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }
        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class) {
        $className = '\Symfony\Component\Security\Core\User\User';
        return $class === $className || is_subclass_of($class, $className);
    }

}
