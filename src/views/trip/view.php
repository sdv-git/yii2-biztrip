<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use yii\bootstrap5\Modal;

/** @var yii\web\View $this */
/** @var app\models\Trip $model */

$this->title = 'Командировка №' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Командировки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="trip-view">

    <h1><?= Html::encode($this->title) ?></h1>
<?/*
    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить командировку?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
*/?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'start_date',
            'end_date',
        ],
    ]) ?>

</div>
<div class="row">
    <div class="col-md-6">
        <h2>Участники:</h2>
        <ul>
            <?php foreach ($model->users as $user): ?>
                <li>
                    <?= $user->name ?>
                    (с <?= $user->getTripStartDate($model->id) ?>
                    по <?= $user->getTripEndDate($model->id) ?>)
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="col-md-6">
        <h2>Услуги:</h2>
        <!-- Кнопка для открытия модального окна -->
        <div class="mb-3">
            <?= \yii\bootstrap5\Html::button('Добавить услугу', [
                'class' => 'btn btn-success',
                'id' => 'add-service-btn',
            ]) ?>
        </div>
        <!-- Модальное окно -->
        <?php \yii\bootstrap5\Modal::begin([
            'id' => 'add-service-modal',
            'title' => 'Добавление новой услуги',
            'size' => Modal::SIZE_LARGE,
            'options' => ['tabindex' => false], // Важно для Bootstrap 5
        ]); ?>

        <!-- Содержимое модального окна -->
        <div class="modal-body">
            <?= $this->render('_service_form', [
                'model' => new \app\models\Service(['trip_id' => $model->id]),
                'users' => $model->users,
            ]) ?>
        </div>

        <?php Modal::end(); ?>
        <?php foreach ($model->services as $service): ?>
            <div class="service">
                <h3><?= $service->type ?></h3>
                <p>Даты: <?= $service->start_date ?> — <?= $service->end_date ?></p>
                <p>Участники: <?= implode(', ', $service->getUsers()->select('name')->column()) ?></p>
                <p>Данные: <?= $service->details ?></p>
                <?/*<button class="btn btn-success toggle-service" data-id="<?= $service->id ?>">
                    <?= $service->isCompleted ? 'Отменить' : 'Оформить' ?>
                </button>*/?>
                <?= Html::a('Удалить', '#', [
                    'class' => 'btn btn-danger btn-sm delete-service',
                    'data-id' => $service->id,
                ]) ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php
$js = <<<JS
// Инициализация модального окна
const addServiceModal = new bootstrap.Modal(document.getElementById('add-service-modal'));

// Обработчик кнопки
document.getElementById('add-service-btn').addEventListener('click', () => {
    addServiceModal.show();
});
JS;
$this->registerJs($js);

$js = <<<JS
$(document).on('click', '.delete-service', function(e) {
    //e.preventDefault();
    
    //if (!confirm($(this).data('confirm'))) return false;
    
    var btn = $(this);
    var serviceId = btn.data('id');
    $.ajax({
        url: '/service/delete',
        type: 'POST',
        data: {id: serviceId},
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Удаляем элемент из DOM
                btn.closest('.service').remove();
                // Или перезагружаем список
                // $.pjax.reload({container: '#services-container'});
            } else {
                alert(response.message);
            }
        },
        error: function() {
            alert('Ошибка');
        }
    });
});
JS;
$this->registerJs($js);

?>