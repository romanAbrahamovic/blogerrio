<?php

namespace App\Service;

use App\Entity\User;
use App\Exception\InvalidParamsException;
use App\Repository\UserRepository;

/**
 * Class UserService
 * @package App\Service
 */
class UserService
{
    private UserRepository $userRepository;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $firstName
     * @return User
     */
    public function addAnonymousUser(string $firstName): User
    {
        if (empty($firstName)) {
            throw new InvalidParamsException('Firstname cannot be empty');
        }

        $user = new User();
        $user->setRoles([User::USER_ROLES['ROLE_ANONYMOUS']]);
        $user->setFirstName($firstName);
        $this->userRepository->add($user, true);

        return $user;
    }
}