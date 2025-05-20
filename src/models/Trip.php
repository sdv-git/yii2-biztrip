<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Expression;

class Trip extends ActiveRecord
{
    public $userIds = []; // Временное свойство для хранения ID пользователей

    public static function tableName() {
        return '{{%trip}}';
    }

    public function getUsers() {
        return $this->hasMany(User::class, ['id' => 'user_id'])
            ->viaTable('{{%trip_user}}', ['trip_id' => 'id']);
    }

    public function getTripUsers() {
        return $this->hasMany(TripUser::class, ['trip_id' => 'id']);
    }

    public function getServices() {
        return $this->hasMany(Service::class, ['trip_id' => 'id']);
    }

    /**
     * Расчёт даты начала командировки (минимум даты начала услуг для всех участников)
     */
    public function getStartDate() {
        return Service::find()
            ->where(['trip_id' => $this->id, 'status' => 1]) // 1 — оформленная услуга
            ->min('start_date');
    }

    /**
     * Расчёт даты окончания командировки (максимум даты окончания услуг для всех участников)
     */
    public function getEndDate() {
        return Service::find()
            ->where(['trip_id' => $this->id, 'status' => 1])
            ->max('end_date');
    }

    public function rules()
    {
        return [
            [['userIds'], 'safe'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => '№ Командировки',
            'start_date' => 'Дата начала',
            'end_date' => 'Дата завершения',
            'userIds' => 'Пользователи',
        ];
    }
}