<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUsersMigration extends AbstractMigration
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
        $table = $this->table('users');
        $table->addColumn('login', 'string', ['limit' => 50])
            ->addColumn('password_hash', 'string', ['limit' => 100 ,'null' => true])
            ->addColumn('role_id', 'integer', ['null' => true])
            ->addColumn('hash', 'string', ['limit' => 100 , 'null' => true])
            ->addColumn('email', 'string', ['limit' => 150 , 'null' => true])
            ->addColumn('email_confirm_hash', 'string', ['limit' => 100 , 'null' => true])
            ->addForeignKey('role_id', 'role', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->create();
    }
}
