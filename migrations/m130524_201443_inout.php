<?php

use app\models\Migrate;

class m130524_201443_inout extends Migrate
{
    public function up()
    {
        $this->createTable('{{%out}}', [
            'id' => $this->primaryKey(),
            'type_out_id' => $this->integer()->notNull(),
            'name' => $this->string(),
            'status' => $this->tinyInt()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        $this->createTable('{{%in}}', [
            'id' => $this->primaryKey(),
            'type_in_id' => $this->integer()->notNull(),
            'name' => $this->string(),
            'status' => $this->tinyInt()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        $this->createTable('{{%type_out}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'title' => $this->string(),
            'slug' => $this->string(),
        ]);
        $this->insert('{{%type_out}}',[
            'id' => 1,
            'parent_id' => 1,
            'title' => 'Расход',
            'slug' => 'out'
        ]);
        $this->createTable('{{%type_in}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'title' => $this->string(),
            'slug' => $this->string(),
        ]);
        $this->insert('{{%type_in}}',[
            'id' => 1,
            'parent_id' => 1,
            'title' => 'Приход',
            'slug' => 'in'
        ]);
        $this->addForeignKey('fk-out_type', '{{%out}}', 'type_out_id', '{{%type_out}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-in_type', '{{%in}}', 'type_in_id', '{{%type_in}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-type_out_parent', '{{%type_out}}', 'parent_id', '{{%type_out}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-type_in_parent', '{{%type_in}}', 'parent_id', '{{%type_in}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk-type_out_parent', '{{%type_out}}');
        $this->dropForeignKey('fk-type_in_parent', '{{%type_in}}');
        $this->dropForeignKey('fk-out_type', '{{%out}}');
        $this->dropForeignKey('fk-in_type', '{{%in}}');
        $this->dropTable('{{%type_out}}');
        $this->dropTable('{{%type_in}}');
        $this->dropTable('{{%out}}');
        $this->dropTable('{{%in}}');
    }
}
