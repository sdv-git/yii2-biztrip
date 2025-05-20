<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Trip $model */

$this->title = 'Создать командировку';
$this->params['breadcrumbs'][] = ['label' => 'Командировки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trip-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
