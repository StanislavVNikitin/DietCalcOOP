<?php


use Phinx\Seed\AbstractSeed;

class OrphaneDiseaseSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {


        $data = [
            [
                "id" => 1,
                "name" => "MMA",
                "description" => "МетилМалоновая ацидемия"
            ],
            [
                "id" => 2,
                "name" => "PA",
                "description" => "Пропионовая ацидурия"
            ],
            [
                "id" => 3,
                "name" => "GA1",
                "description" => "Глутаровая ацидурия 1 тип"
            ],
            [
                "id" => 4,
                "name" => "MCU",
                "description" => "Болезнь клинового сиропа"
            ],
            [
                "id" => 100,
                "name" => "NOT OD",
                "description" => "Нет заболеваний"
            ]
        ];


        $orphanedisease = $this->table('orphan_disease');
        $orphanedisease->insert($data)
            ->saveData();

    }
}
