<?php

use yii\db\Migration;

/**
 * Handles the creation of table `blog`.
 */
class m171201_052143_create_blog_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('blog', [
            'id' => $this->primaryKey(),
            'title' => $this->string(100)->notNull()->defaultValue(''),
            'content' => $this->text(),
            'create_time' => $this->dateTime(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('blog');
    }
}
