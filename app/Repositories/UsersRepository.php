<?php

namespace App\Repositories;


use App\classes\User;
use swoole_table;

class UsersRepository
{
    private $users_table;

    public function __construct() {
        $this->reCreateUsersTable();
    }

    /**
     * @param int $id
     * @return User|false
     */
    public function get(int $id) {
        $userRow = $this->users_table->get($id);
        if ($userRow !== false) {
            return new User($id, $userRow['username']);
        }
        return false;
    }

    /**
     * Get all online users
     * @param int[] $ids
     * @return User[]
     */
    public function getByIds(array $ids) {
        $users = [];
        foreach ($ids as $id) {
            $row = $this->users_table->get($id);
            if ($row !== false) {
                $users[] = new User($id, $row['username']);
            }
        }
        return $users;
    }

    public function delete(int $id) {
        $this->users_table->del($id);
    }

    /**
     * Save user to table in memory;
     * @param User $user
     */
    public function save(User $user) {
        $result = $this->users_table->set($user->getId(), ['username' => $user->getUsername()]);
        if ($result === false) {
            $this->reCreateUsersTable();
            $this->users_table->set($user->getId(), ['username' => $user->getUsername()]);
        }
    }

    public function reCreateUsersTable() {
        if (isset($this->users_table)) {
            $this->users_table->destroy();
        }
        $this->users_table = new swoole_table(131072);
        $this->users_table->column('username', swoole_table::TYPE_STRING, 100);
        $this->users_table->create();
    }
}