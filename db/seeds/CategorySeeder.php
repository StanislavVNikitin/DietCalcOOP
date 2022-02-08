<?php


use Phinx\Seed\AbstractSeed;

class CategorySeeder extends AbstractSeed
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
                "name" => "Без категории",
                "image" => "notcategory.jpg"
            ],
            [
                "name" => "Фрукты",
                "image" => "fruts.jpg"
            ],
            [
                "name" => "Овощи",
                "image" => "veget.jpg"
            ],
            [
                "name" => "Орехи",
                "image" => "nuts.jpg"
            ],
            [
                "name" => "Морепродукты",
                "image" => "fish.jpg"
            ],
            [
                "name" => "Мясные продукты",
                "image" => "meat.jpg"
            ],
            [
                "name" => "Крупы",
                "image" => "krup.jpg"
            ],
            [
                "name" => "Грибы",
                "image" => "grib.jpg"
            ],
            [
                "name" => "Напитки",
                "image" => "napitki.jpg"
            ],
            [
                "name" => "Зерновые",
                "image" => "notcategory.jpg"
            ],
            [
                "name" => "Мучное",
                "image" => "notcategory.jpg"
            ],
            [
                "name" => "Бобовые",
                "image" => "notcategory.jpg"
            ],
            [
                "name" => "Специи",
                "image" => "species.jpg"
            ]
        ];

        $category = $this->table('category');
        $category->insert($data)
            ->saveData();

    }
}
