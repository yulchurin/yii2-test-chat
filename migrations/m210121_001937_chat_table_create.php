<?php

use yii\db\Migration;

/**
 * Class m210121_001937_chat_table_create
 */
class m210121_001937_chat_table_create extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%chat}}', [
            'id' => $this->primaryKey(),
            'userID' => $this->integer(),
            'message' => $this->text(),
            'timestamp' => $this->timestamp()->append('on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'),
            'ban' => $this->boolean()
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210121_001937_chat_table_create cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210121_001937_chat_table_create cannot be reverted.\n";

        return false;
    }
    */
}
