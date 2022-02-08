<?php

namespace app\models\entities;

class Foods extends \app\models\Model
{
        protected $id;
        protected $name;
        protected $protein;
        protected $carbohydrates;
        protected $fat;
        protected $calories;
        protected $user_id;
        protected $special_foods;
        protected $category_id;
        protected $image;
        protected $created_at;

        protected $props = [
            'name' => false,
            'protein' => false,
            'carbohydrates' => false,
            'fat' => false,
            'calories' => false,
            'user_id' => false,
            'special_foods' => false,
            'category_id' => false,
            'image' => false,
            'created_at' => false
        ];

        protected $protectedProps = [
            'created_at'
        ];

        /**
         * @param $name
         * @param $protein
         * @param $carbohydrates
         * @param $fat
         * @param $calories
         */
        public function __construct($name = null, $protein = null, $carbohydrates = null, $fat = null, $calories = null)
        {
            $this->name = $name;
            $this->protein = $protein;
            $this->carbohydrates = $carbohydrates;
            $this->fat = $fat;
            $this->calories = $calories;

        }


}