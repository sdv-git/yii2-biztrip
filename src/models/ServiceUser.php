<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "service_user".
 *
 * @property int $service_id
 * @property int $user_id
 * @property int|null $is_completed
 *
 * @property Service $service
 * @property User $user
 */
class ServiceUser extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_completed'], 'default', 'value' => 0],
            [['service_id', 'user_id'], 'required'],
            [['service_id', 'user_id', 'is_completed'], 'integer'],
            [['service_id', 'user_id'], 'unique', 'targetAttribute' => ['service_id', 'user_id']],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => Service::class, 'targetAttribute' => ['service_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'service_id' => 'Service ID',
            'user_id' => 'User ID',
            'is_completed' => 'Is Completed',
        ];
    }

    /**
     * Gets query for [[Service]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
