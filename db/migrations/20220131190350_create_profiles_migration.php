<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateProfilesMigration extends AbstractMigration
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
        $table = $this->table('profiles', ['id' => false, 'primary_key' => ['user_id']]);
        $table->addColumn('user_id', 'integer')
            ->addColumn('gender', 'char', ['limit' => 1, 'null' => true])
            ->addColumn('disease_id', 'integer', ['null' => true])
            ->addColumn('weight', 'integer', ['null' => true])
            ->addColumn('firstname', 'string', ['limit' => 255 , 'null' => true])
            ->addColumn('lastname', 'string', ['limit' => 255 , 'null' => true])
            ->addColumn('height', 'integer', ['null' => true])
            ->addColumn('birthday', 'date', ['null' => true])
            ->addColumn('created_at','timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true])
            ->addForeignKey('disease_id', 'orphan_disease', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->addForeignKey('user_id', 'users', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->create();
    }
}
