<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<?php $form = ActiveForm::begin([
    'id' => 'service-form',
    'action' => Url::to(['service/create', 'trip_id' => $model->trip_id]),
    'enableAjaxValidation' => false,
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
    \yii\helpers\ArrayHelper::map($users, 'id', 'name')
) ?>

    <div class="form-group">
        <?= \yii\bootstrap5\Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

<?php
// AJAX обработка формы
$js = <<<JS
$('#service-form').on('beforeSubmit', function(e) {
    e.preventDefault();
    var form = $(this);
    var btn = form.find('[type="submit"]');
    
    // Блокируем кнопку
    btn.prop('disabled', true)
       .html('<span class="spinner-border spinner-border-sm"></span> Сохранение...');
    
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        complete: function() {
            btn.prop('disabled', false).html('Сохранить'); // Разблокируем при любом исходе
        },
        success: function(response) {
            if (response.success) {
                $('#add-service-modal').modal('hide');
                location.reload(); // Перезагружаем страницу
            } else {
                // Обновляем форму с ошибками
                alert('ошибки в форме');
                form.yiiActiveForm('updateMessages', response.errors, true);
            }
        }
    });
    return false;
});
JS;
$this->registerJs($js);
?>