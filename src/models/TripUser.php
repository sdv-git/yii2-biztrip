<?php

namespace app\models;

use yii\db\ActiveRecord;

class TripUser extends ActiveRecord
{
    public static function tableName() {
        return '{{%trip_user}}';
    }

    public function getUser() {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getTrip() {
        return $this->hasOne(Trip::class, ['id' => 'trip_id']);
    }
}