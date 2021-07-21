<?php

use yii\db\Migration;

/**
 * Class m210720_163255_create_table_short_url
 */
class m210720_163255_create_table_short_url extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
		$tableOptions = null;

		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
		}

		$this->createTable('short_url', [
			'id'			=> $this->primaryKey(),
			'url' 			=> $this->text()->notNull(),
			'short_code' 	=> $this->string(8)->unique()->notNull(),
			'max_visits' 	=> $this->integer()->notNull()->defaultValue(0),
			'total_visits' 	=> $this->integer()->defaultValue(0),
			'expire' 		=> $this->integer(),
			'created_at' 	=> $this->integer(),
			'updated_at' 	=> $this->integer()
		], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
		$this->dropTable('short_url');
    }
}
