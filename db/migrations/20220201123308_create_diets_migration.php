<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateDietsMigration extends AbstractMigration
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
        $table = $this->table('diets');
        $table->addColumn('session_id','string', ['limit' => 255, 'null' => true])
            ->addColumn('user_id', 'integer', ['null' => true])
            ->addColumn('diet_user_id', 'integer', ['null' => true])
            ->addColumn('foods_id', 'integer')
            ->addColumn('count','smallinteger')
            ->addColumn('created_at','timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true])
            ->addColumn('updated_at','timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true])
            ->create();
    }
}
