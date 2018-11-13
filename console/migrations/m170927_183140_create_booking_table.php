<?php

use yii\db\Migration;

/**
 * Handles the creation of table `booking`.
 */
class m170927_183140_create_booking_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('booking', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),

            'phone' => $this->string(11)->notNull(),

            'status' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

            'start_date' => $this->integer()->notNull(),
            'end_date' => $this->integer()->notNull(),

            'box_id' => $this->integer()->notNull(),

            'total_amount' => $this->integer()->notNull(),
            'decimal_part' => $this->smallInteger(3)->defaultValue(100)->notNull(),

            'rated' => $this->smallInteger()->notNull()->defaultValue(0),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-booking-user_id',
            'booking',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-booking-user_id',
            'booking',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'RESTRICT'
        );

        /**
         * It need for faster search by start/end date
         */
        // creates index for column `start_date`
        $this->createIndex(
            'idx-booking-start_date',
            'booking',
            'start_date'
        );

        // creates index for column `end_date`
        $this->createIndex(
            'idx-booking-end_date',
            'booking',
            'end_date'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('booking');
    }
}
