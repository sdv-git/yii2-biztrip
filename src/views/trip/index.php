<?php

use app\models\Trip;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Командировки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trip-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать командировку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            /*['class' => 'yii\grid\SerialColumn'],*/

            [
                'attribute' => 'id',
                'format' => 'raw', // Важно! Позволяет использовать HTML
                'value' => function ($model) {
                    // Делаем ID ссылкой на просмотр командировки
                    return Html::a(
                        $model->id,
                        ['trip/view', 'id' => $model->id],
                        [
                            'title' => 'Просмотр командировки',
                            'data-pjax' => '0'
                        ]
                    );
                },
                'headerOptions' => ['style' => 'width: 80px;'] // Опционально
            ],
            'start_date',
            'end_date',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Trip $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
