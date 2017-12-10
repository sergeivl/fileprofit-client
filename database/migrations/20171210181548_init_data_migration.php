<?php

use Phinx\Migration\AbstractMigration;

class InitDataMigration extends AbstractMigration
{
    public function up()
    {
        $sql = file_get_contents('database/data/initialData.sql', true);
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "DELETE FROM `fp_pages` WHERE `alias`='main'";
        $this->execute($sql);
    }
}
