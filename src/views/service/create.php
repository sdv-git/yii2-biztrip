<?php
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'id' => 'service-form',
    'enableAjaxValidation' => true,
]); ?>

<?= $form->field($model, 'type')->dropDownList([
    'flight' => 'Авиабилет',
    'hotel' => 'Отель',
    'train' => 'ЖД билет'
], ['prompt' => 'Выберите тип услуги']) ?>

<?= $form->field($model, 'start_date')->textInput(['type' => 'datetime-local']) ?>

<?= $form->field($model, 'end_date')->textInput(['type' => 'datetime-local']) ?>

<?= $form->field($model, 'details')->textarea() ?>

<?= $form->field($model, 'userIds')->checkboxList(
    \yii\helpers\ArrayHelper::map($users, 'id', 'name'),
    ['separator' => '<br>']
) ?>

<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>