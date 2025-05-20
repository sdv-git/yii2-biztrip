<?php

namespace app\controllers;

use Yii;
use app\models\Service;
use app\models\ServiceUser;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ServiceController extends \yii\web\Controller
{
    /*public function actionIndex()
    {
        return $this->render('index');
    }*/
    public function actionCreate($trip_id)
    {
        $model = new Service(['trip_id' => $trip_id]);

        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if ($model->load(Yii::$app->request->post())) {
                // Дополнительная валидация
                if (!$model->validate()) {
                    return ['success' => false, 'errors' => $model->errors];
                }

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($model->save()) {
                        // Очищаем старые связи перед сохранением новых
                        ServiceUser::deleteAll(['service_id' => $model->id]);

                        // Сохраняем новых участников
                        foreach ((array)$model->userIds as $userId) {
                            $relation = new ServiceUser([
                                'service_id' => $model->id,
                                'user_id' => $userId
                            ]);
                            if (!$relation->save()) {
                                throw new \Exception('Ошибка сохранения связи с пользователем');
                            }
                        }

                        $transaction->commit();
                        return ['success' => true, 'reload' => true];
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    return ['success' => false, 'message' => $e->getMessage()];
                }
            }
        }

        // Рендеринг формы только для GET-запроса
        /*$users = User::find()->all();
        return $this->renderAjax('_form', [ // Обратите внимание на имя файла
            'model' => $model,
            'users' => $users
        ]);*/
    }

    public function actionDelete()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        if (!$id) {
            throw new BadRequestHttpException('ID услуги не указан');
        }

        $service = $this->findModel($id);
        $trip_id = $service->trip_id;

        $transaction = Yii::$app->db->beginTransaction();
        try {
            // Сначала удаляем связи с пользователями
            ServiceUser::deleteAll(['service_id' => $id]);

            // Затем удаляем саму услугу
            if ($service->delete()) {
                $transaction->commit();
                return [
                    'success' => true,
                    'message' => 'Услуга успешно удалена',
                    'trip_id' => $trip_id
                ];
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            return [
                'success' => false,
                'message' => 'Ошибка при удалении: ' . $e->getMessage()
            ];
        }
    }

    protected function findModel($id)
    {
        if (($model = Service::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Услуга не найдена');
    }
}
