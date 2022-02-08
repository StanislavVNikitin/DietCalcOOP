<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateFoodsMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('foods');
        $table->addColumn('name', 'string', ['limit' => 100])
            ->addColumn('protein','decimal',['precision' => 3, 'scale' => 1])
            ->addColumn('carbohydrates','decimal',['precision' => 3, 'scale' => 1])
            ->addColumn('fat','decimal',['precision' => 3, 'scale' => 1])
            ->addColumn('calories','smallinteger')
            ->addColumn('user_id', 'integer', ['null' => true, 'default' => 1])
            ->addColumn('special_foods', 'boolean', ['null' => true])
            ->addColumn('category_id', 'integer', ['null' => true])
            ->addColumn('image', 'string', ['limit' => 100 ,'default' => 'defaultfood.jpg','null' => true])
            ->addColumn('created_at','timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true])
            ->addForeignKey('category_id', 'category', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->addForeignKey('user_id', 'users', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->create();
    }
}
