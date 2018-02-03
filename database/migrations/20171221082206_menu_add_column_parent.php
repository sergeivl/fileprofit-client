<?php

use Phinx\Migration\AbstractMigration;

class MenuAddColumnParent extends AbstractMigration
{
    public function up()
    {
        $sql = 'ALTER TABLE `fp_menu` ADD COLUMN `parent` INT(11) DEFAULT 0 AFTER `link`';
        $this->execute($sql);
    }

    public function down()
    {
        $sql = 'ALTER TABLE `fp_menu` DROP COLUMN `parent`';
        $this->execute($sql);
    }
}
