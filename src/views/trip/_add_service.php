<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

use app\models\User;

/** @var yii\web\View $this */
/** @var app\models\Trip $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin([
    'id' => 'service-form',
    'action' => Url::to(['service/create', 'trip_id' => $model->trip_id]),
    'enableAjaxValidation' => true,
]); ?>
<?= $form->field($service, 'type')->dropDownList(['flight' => 'Авиа', 'hotel' => 'Отель']) ?>
<?= $form->field($service, 'start_date')->input('datetime-local') ?>
<?= $form->field($service, 'end_date')->input('datetime-local') ?>
<?= $form->field($service, 'userIds')->checkboxList(
    $model->getUsers()->select(['name', 'id'])->indexBy('id')->column()
) ?>