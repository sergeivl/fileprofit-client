<?php

use Phinx\Migration\AbstractMigration;

class LookupMigration extends AbstractMigration
{
    public function up()
    {
        $sql = 'CREATE TABLE `fp_lookup` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `name` varchar(128) NOT NULL,
                  `code` int(11) NOT NULL,
                  `type` varchar(128) NOT NULL,
                  `position` int(11) NOT NULL,
                PRIMARY KEY (`id`),
                  KEY `type` (`type`),
                  KEY `code` (`code`)
                )';
        $this->execute($sql);
    }

    public function down()
    {
        $sql = 'DROP TABLE `fp_lookup`';
        $this->execute($sql);
    }
}
