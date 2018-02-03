<?php

use Phinx\Migration\AbstractMigration;

class GamesAddColumnDatePublic extends AbstractMigration
{
    public function up()
    {
        $sql = 'ALTER TABLE `fp_games` ADD COLUMN `date_public` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP';
        $this->execute($sql);
    }

    public function down()
    {
        $sql = 'ALTER TABLE `fp_games` DROP COLUMN `date_public`';
        $this->execute($sql);
    }
}
