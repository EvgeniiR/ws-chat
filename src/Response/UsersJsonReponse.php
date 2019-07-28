<?php

namespace App\Response;

use App\User;

class UsersJsonReponse extends JsonReponse
{
    const ACTION_NEW_USERS = 'new users';
    const ACTION_DISCONNECTED_USERS = 'disconnected';

    /**
     * @var string
     */
    private $action;
    /**
     * @var array
     */
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

    protected function getBody(): array {
        return ['action' => $this->action, 'users' => $this->users];
    }

    /**
     * @param User $user
     * @return UsersJsonReponse
     */
    public function addUser(User $user) {
        $this->users[] = [
            'id' => $user->getId(),
            'name' => $user->getUsername()
        ];
        return $this;
    }
}