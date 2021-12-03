<?php


use yii\db\Migration;
use yii\db\Schema;

class m130524_201442_learning extends Migration
{

    /**
     * @inheritdoc
     */
    public function up()
    {
        // MySql table options
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        // table blog_category
        $this->createTable(
            '{{%loop_category}}',
            [
                'id' => Schema::TYPE_PK,
                'parent_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
                'title' => Schema::TYPE_STRING . '(255) NOT NULL',
                'slug' => Schema::TYPE_STRING . '(128) NOT NULL',
                'status' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 1',
                'count' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
                'last_update' => Schema::TYPE_DATETIME,
            ],
            $tableOptions
        );

        // Indexes
        $this->createIndex('status', '{{%loop_category}}', 'status');

        // table blog_post
        $this->createTable(
            '{{%loop_learn}}',
            [
                'id' => Schema::TYPE_PK,
                'category_id' => Schema::TYPE_INTEGER . ' NOT NULL',
                'title' => Schema::TYPE_STRING . '(255) NOT NULL',
                'link' => Schema::TYPE_STRING,
                'count' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
                'last_update' => Schema::TYPE_DATETIME,
            ],
            $tableOptions
        );

        // Indexes
        $this->createIndex('category_id', '{{%loop_learn}}', 'category_id');

        // table blog_post
        $this->createTable(
            '{{%loop_note}}',
            [
                'id' => Schema::TYPE_PK,
                'learn_id' => Schema::TYPE_INTEGER . ' NOT NULL',
                'title' =>  Schema::TYPE_TEXT,
                'link' => Schema::TYPE_STRING,
                'count' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
                'last_update' => Schema::TYPE_DATETIME,
            ],

            $tableOptions
            
        );

        $this->createIndex('learn_id', '{{%loop_note}}', 'learn_id');
    }


    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%loop_note}}');
        $this->dropTable('{{%loop_learn}}');
        $this->dropTable('{{%loop_category}}');
    }
}
