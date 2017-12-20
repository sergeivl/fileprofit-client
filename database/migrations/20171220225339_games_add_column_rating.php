<?php

use Phinx\Migration\AbstractMigration;

class GamesAddColumnRating extends AbstractMigration
{

    public function up()
    {
        $sql = 'ALTER TABLE `fp_games` ADD COLUMN `rating` INT(3) DEFAULT NULL AFTER `genre`';
        $this->execute($sql);
    }

    public function down()
    {
        $sql = 'ALTER TABLE `fp_games` DROP COLUMN `rating`';
        $this->execute($sql);
    }

}
