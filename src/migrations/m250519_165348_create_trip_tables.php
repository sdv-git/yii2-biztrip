<?php

use yii\db\Migration;

class m250519_165348_create_trip_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('trip', [
            'id' => $this->primaryKey(),
            'start_date' => $this->dateTime(),
            'end_date' => $this->dateTime(),
        ]);

        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);

        $this->createTable('trip_user', [
            'trip_id' => $this->integer(),
            'user_id' => $this->integer(),
            'PRIMARY KEY(trip_id, user_id)',
        ]);

        $this->createTable('service', [
            'id' => $this->primaryKey(),
            'trip_id' => $this->integer(),
            'type' => $this->string()->notNull(), // 'flight', 'hotel', 'train', etc.
            'start_date' => $this->dateTime(),
            'end_date' => $this->dateTime(),
            'details' => $this->json(), // {hotel_name: "Ritz", flight_number: "SU-123"}
        ]);

        $this->createTable('service_user', [
            'service_id' => $this->integer(),
            'user_id' => $this->integer(),
            'is_completed' => $this->boolean()->defaultValue(false),
            'PRIMARY KEY(service_id, user_id)',
        ]);

// Внешние ключи
        $this->addForeignKey('fk_trip_user_trip', 'trip_user', 'trip_id', 'trip', 'id', 'CASCADE');
        $this->addForeignKey('fk_trip_user_user', 'trip_user', 'user_id', 'user', 'id', 'CASCADE');
        $this->addForeignKey('fk_service_trip', 'service', 'trip_id', 'trip', 'id', 'CASCADE');
        $this->addForeignKey('fk_service_user_service', 'service_user', 'service_id', 'service', 'id', 'CASCADE');
        $this->addForeignKey('fk_service_user_user', 'service_user', 'user_id', 'user', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('service_user');
        $this->dropTable('service');
        $this->dropTable('trip_user');
        $this->dropTable('user');
        $this->dropTable('trip');
    }


    // Use up()/down() to run migration code without a transaction.
/*    public function up()
    {

    }

    public function down()
    {
        echo "m250519_165348_create_trip_tables cannot be reverted.\n";

        return false;
    }
    */
}
