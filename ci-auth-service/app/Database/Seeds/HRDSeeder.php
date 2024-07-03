<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HRDSeeder extends Seeder
{
    public function run()
    {
        $users = [['user_id' => 3, 'type' => 'email_password', 'name' => 'hrd1', 'secret' => 'hrd1@gmail.com', 'secret2' => password_hash('hrd1', PASSWORD_DEFAULT), 'force_reset' => 0, 'role' => 'hrd', 'role_id' => 3]];

        $db = \Config\Database::connect();
        foreach ($users as $user) {
            $builder = $db->table('users');
            $builder->insert(['username' => $user['name'], 'active' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
            $userId = $db->insertID();
            $builder = $db->table('auth_identities');
            $builder->insert(['user_id' => $userId, 'type' => $user['type'], 'name' => $user['name'], 'secret' => $user['secret'], 'secret2' => $user['secret2'], 'force_reset' => $user['force_reset'], 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
            $builder = $db->table('auth_groups_users');
            $builder->insert([
                'group' => $user['role'],
                'user_id'  => $userId,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
