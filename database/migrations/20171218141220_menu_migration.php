<?php

use Phinx\Migration\AbstractMigration;

class MenuMigration extends AbstractMigration
{
    public function up()
    {
        $sql = 'CREATE TABLE `fp_menu` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `name` varchar(255) NOT NULL,
                  `link` varchar(255) NOT NULL,
                  `position` int(11) NOT NULL DEFAULT 0,
                  `class` varchar(255) NULL,
                PRIMARY KEY (`id`),
                  KEY `position` (`position`)
                )';
        $this->execute($sql);
    }

    public function down()
    {
        $sql = 'DROP TABLE `fp_menu`';
        $this->execute($sql);
    }
}
