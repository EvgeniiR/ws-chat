<?php

namespace App\classes\Response;

use App\classes\User;

class UsersResponse extends Response
{
    const ACTION_NEW_USERS = 'new users';
    const ACTION_DISCONNECTED_USERS = 'disconnected';

    private $action;
    private $users = [];

    /**
     * @param string $action
     */
    public function __construct(string $action) {
        $this->action = $action;
    }

    protected function getType(): string {
        return 'users';
    }

    protected function getBody() {
        return ['action' => $this->action, 'users' => $this->users];
    }

    /**
     * @param User $user
     * @return UsersResponse
     */
    public function addUser(User $user) {
        $this->users[] = [
            'id' => $user->getId(),
            'username' => $user->getUsername()
        ];
        return $this;
    }
}