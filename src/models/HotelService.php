<?php

namespace app\models;

use yii\db\ActiveRecord;

class HotelService extends ActiveRecord
{
    public static function tableName() {
        return '{{%hotel_service}}';
    }

    public function getService() {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }
}