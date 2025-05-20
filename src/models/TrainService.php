<?php

namespace app\models;

use yii\db\ActiveRecord;

class TrainService extends ActiveRecord
{
    public static function tableName() {
        return '{{%train_service}}';
    }

    public function getService() {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }
}