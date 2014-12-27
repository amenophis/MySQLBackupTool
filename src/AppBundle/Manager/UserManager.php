<?php

namespace AppBundle\Manager;

use AppBundle\Configuration\User;
use AppBundle\Exception\UserNotFoundException;

class UserManager
{
    /** @var User[]\array  */
    protected $users = [];

    public function __construct(array $users = [])
    {
        $this->users = [];

        foreach ($users as $username => $user) {
            $this->users[$username] = new User($username, $user['password'], $user['roles']);
        }
    }

    /**
     * @return \AppBundle\Configuration\User[]\array
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param $username
     *
     * @return \AppBundle\Configuration\User
     * @throws \Exception
     */
    public function getUser($username)
    {
        if (isset($this->users[$username])) {
            return $this->users[$username];
        }

        throw new UserNotFoundException();
    }
}
