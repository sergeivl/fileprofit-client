<?php

use Phinx\Migration\AbstractMigration;

class InitSchemaMigration extends AbstractMigration
{
    public function up()
    {
        $sql = file_get_contents('database/data/initialSchema.sql', true);
        $this->query($sql);
    }

    public function down()
    {
        $sqlQueries = [];
        $sqlQueries[] = 'SET foreign_key_checks = 0;';
        $sqlQueries[] = 'DROP `fp_categories`, `fp_gamesm`, `fp_pages`, `fp_taxonomy`, `fp_users`';
        $sqlQueries[] = 'SET foreign_key_checks = 1;';

        foreach ($sqlQueries as $sql) {
            $this->execute($sql);
        }

    }

}
