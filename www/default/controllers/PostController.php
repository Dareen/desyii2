<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\filters\AccessControl;

use yii\elasticsearch\ActiveQuery;

// use yii\web\ForbiddenHttpException;

// use yii\data\ActiveDataProvider;
use app\models\Post;


class PostController extends OAuth2RestController
{
    public $modelClass = 'app\models\Post';


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // index and view are allowed anonymously
        $behaviors['authenticator']['except'] = ['index', 'view', 'search'];
        return $behaviors;
    }

    /**
     * Checks the privilege of the current user.
     *
     * This method should be overridden to check whether the current user has the privilege
     * to run the specified action against the specified data model.
     * If the user does not have access, a [[ForbiddenHttpException]] should be thrown.
     *
     * @param string $action the ID of the action to be executed
     * @param \yii\base\Model $model the model to be accessed. If null, it means no specific model is being accessed.
     * @param array $params additional parameters
     * @throws ForbiddenHttpException if the user does not have access
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        // check if the user can access $action and $model
        if ($action=='update' || $action=='delete') {
            // TODO: RBAC, admins can update everything
            // no need to check if the user is a guest, this is taken care of
            // in authenticator behavior
            if ($model->user_id != \Yii::$app->user->id)
            {
                throw new ForbiddenHttpException();
            }
        }
    }

    // TODO: rewrite this, support page, sort, order, limit ... etc.
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
