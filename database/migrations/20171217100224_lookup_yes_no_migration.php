<?php

use Phinx\Migration\AbstractMigration;

class LookupYesNoMigration extends AbstractMigration
{
    public function up()
    {
        $sql = "
        INSERT INTO `fp_lookup` (`name`, `code`, `type`, `position`) VALUES
          ('Да',	1,	'YesNo',	1),
          ('Нет',	0,	'YesNo',	2);
        ";
        $this->execute($sql);

    }

    public function down()
    {
        $sql = "DELETE FROM `fp_lookup` WHERE `type`='YesNo'";
        $this->execute($sql);
    }
}
