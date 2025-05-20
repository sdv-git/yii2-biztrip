<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\User;

/** @var yii\web\View $this */
/** @var app\models\Trip $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="trip-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'userIds')->checkboxList(
        \app\models\User::find()
            ->select(['name', 'id'])
            ->indexBy('id')
            ->column(),
        [
            'item' => function($index, $label, $name, $checked, $value) {
                return '<div class="checkbox">' .
                    Html::checkbox($name, $checked, ['value' => $value, 'label' => $label]) .
                    '</div>';
            }
        ]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
