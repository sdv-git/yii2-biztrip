<?php

namespace app\models;

use yii\db\ActiveRecord;

class Service extends ActiveRecord
{
    public $userIds = []; // Временное свойство для хранения ID пользователей

    public static function tableName() {
        return '{{%service}}';
    }

    public function getTrip() {
        return $this->hasOne(Trip::class, ['id' => 'trip_id']);
    }

    public function getUsers() {
        return $this->hasMany(User::class, ['id' => 'user_id'])
            ->viaTable('{{%service_user}}', ['service_id' => 'id']);
    }

    public function getHotelService() {
        return $this->hasOne(HotelService::class, ['service_id' => 'id']);
    }

    public function getTrainService() {
        return $this->hasOne(TrainService::class, ['service_id' => 'id']);
    }

    public function rules()
    {
        return [
            [['trip_id', 'type', 'start_date', 'end_date'], 'required'], // Все обязательные поля
            [['trip_id'], 'integer'],
            [['type'], 'string', 'max' => 50],
            [['details'], 'string'],
            [['userIds'], 'safe'],
        ];
    }
}