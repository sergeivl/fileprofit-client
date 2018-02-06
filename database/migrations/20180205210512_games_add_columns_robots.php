<?php

use Phinx\Migration\AbstractMigration;

class GamesAddColumnsRobots extends AbstractMigration
{
    public function up()
    {
        $sqls = [
            'ALTER TABLE `fp_games` ADD COLUMN `is_noindex`  TINYINT(1) NOT NULL DEFAULT 0',
            'ALTER TABLE `fp_games` ADD COLUMN `is_nofollow` TINYINT(1) NOT NULL DEFAULT 0'
        ];

        foreach ($sqls as $sql) {
            $this->execute($sql);
        }

    }

    public function down()
    {
        $sqls = [
            'ALTER TABLE `fp_games` DROP COLUMN `is_noindex`',
            'ALTER TABLE `fp_games` DROP COLUMN `is_nofollow`'
        ];

        foreach ($sqls as $sql) {
            $this->execute($sql);
        }
    }
}
