<?php

namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    public static function tableName()
    {
        return 'user'; // имя таблицы в базе
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function getTrips() {
        return $this->hasMany(Trip::class, ['id' => 'trip_id'])
            ->viaTable('{{%trip_user}}', ['user_id' => 'id']);
    }

    public function getTripUsers() {
        return $this->hasMany(TripUser::class, ['user_id' => 'id']);
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Имя пользователя',
        ];
    }

    public function getTripStartDate($tripId)
    {
        return ServiceUser::find()
            ->joinWith('service')
            ->where(['service_user.user_id' => $this->id, 'service.trip_id' => $tripId])
            ->min('service.start_date');
    }

    public function getTripEndDate($tripId)
    {
        return ServiceUser::find()
            ->joinWith('service')
            ->where(['service_user.user_id' => $this->id, 'service.trip_id' => $tripId])
            ->max('service.end_date');
    }
}