<?php

namespace App\Repositories;


use App\classes\User;
use Swoole\Connection\Iterator;
use swoole_table;

class UsersRepository
{
    public function __construct()
    {
        $this->users_table = new swoole_table(131072);
        $this->users_table->column('username', swoole_table::TYPE_STRING, 100);
        $this->users_table->create();
    }

    /**
     * @param int $id
     * @return User
     */
    public function get(int $id)
    {
        $userRow = $this->users_table->get($id);
        return new User($id, $userRow['username']);
    }

    /**
     * Get all online users
     * @return User[]
     */
    public function getAllOnline(Iterator $ids)
    {
        $users = [];
        foreach ($ids as $id) {
            $row = $this->users_table->get($id);
            if($row !== false)
            {
                $users[] = new User($id, $row['username']);
            }
        }
        return $users;
    }

    public function delete(int $id)
    {
        $this->users_table->del($id);
    }

    /**
     * Save user to table in memory;
     * @param User $user
     */
    public function save(User $user)
    {
        $this->users_table->set($user->getId(), ['username' => $user->getUsername()]);
    }
}