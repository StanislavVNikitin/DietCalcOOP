<?php


use Phinx\Seed\AbstractSeed;

class UsersSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */

    public function getDependencies()
    {
        return [
            'OrphaneDiseaseSeeder',
            'RoleSeeder'
        ];
    }

    public function run()
    {


        $data = [
            [
                'login' => 'admin',
                'password_hash' => password_hash('123', PASSWORD_DEFAULT),
                'role_id' =>  1
            ],
            [
                'login' => 'user',
                'password_hash' => password_hash('123', PASSWORD_DEFAULT),
                'role_id' =>  2,
                'email' => 'user@example.com'
            ]

        ];

        $user = $this->table('users');
        $user->insert($data)
            ->saveData();
    }
}
