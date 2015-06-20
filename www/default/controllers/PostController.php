<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;

class PostController extends ActiveController
{
    public $modelClass = 'app\models\Post';

    public function actionSearch()
    {
        if (!empty($_GET))
        {
            $model = new $this->modelClass;

            // check that all the search GET params are valid attributes of the model
            foreach ($_GET as $key => $value)
            {
                if (!$model->hasAttribute($key))
                {
                    throw new NotFoundHttpException('Invalid attribute:' . $key);
                }
            }

            $provider = new ActiveDataProvider([
                // TODO: elasicize this
                'query' => $model->find()->where($_GET),
                // TODO: pagination
                'pagination' => false
            ]);

            if ($provider->getCount() <= 0)
            {
                throw new NotFoundHttpException('No posts are found with ' .
                    'the provided parameters, please update and search again.');
            }
            else
            {
                return $provider;
            }
        }
        else
        {
            throw new BadRequestHttpException('Please provide search terms.');
        }
    }
}
