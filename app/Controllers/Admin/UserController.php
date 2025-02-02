<?php

namespace App\Controllers\Admin;

use App\Models\User;

class UserController
{
    private User $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function testBaseModel()
    {
        echo '<pre>';
        // print_r($this->user);

        // $data = $this->user->paginate($_GET['page'] ?? 1, 2);

        // $data = $this->user->find(2);

        // $data = $this->user->count();

        // $this->user->update(1, ['name' => 'QKA']);

        // $data = $this->user->delete(2);
        // print_r($data);

        // $newUserId = $this->user->insert([
        //     'name' => 'Ahihi3',
        //     'email' => 'john3@example.com',
        //     'password' => password_hash('12345678', PASSWORD_DEFAULT),
        //     'type' => 'client'
        // ]);

        // echo $newUserId;
    }
}
