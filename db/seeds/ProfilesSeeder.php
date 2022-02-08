<?php


use Phinx\Seed\AbstractSeed;

class ProfilesSeeder extends AbstractSeed
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
            'UsersSeeder'
        ];
    }

    public function run()
    {


        $data = [
            [
                "user_id" => 1,
                "gender" => "m",
                "disease_id" => 100,
                "weight" => 107,
                "firstname" => "Administrator",
                "lastname" => "IT",
                "height" => 180,
                "birthday" => "1976-07-07"
            ],
            [
                "user_id" => 2,
                "gender" => "m",
                "disease_id" => 1,
                "weight" => 42,
                "firstname" => "Stanislav",
                "lastname" => "Nikitin",
                "height" => 144,
                "birthday" => "2008-06-23"
            ]
        ];

        $profiles = $this->table('profiles');
        $profiles->insert($data)
            ->saveData();

    }
}
