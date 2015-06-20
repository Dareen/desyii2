<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\filters\AccessControl;

use yii\elasticsearch\ActiveQuery;

use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;

use yii\data\ActiveDataProvider;
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
            $query = $model->find();
            $mustTerms = array();

            // user
            if (array_key_exists('user_id', $_GET)) {
                $mustTerms[] = ["term" => [ "user_id" => $_GET['user_id']]];
            }
            if (array_key_exists('status', $_GET)) {
                $mustTerms[] = ["term" => [ "status" => $_GET['status']]];
            }

            // bool must
            if (!empty($mustTerms)) {
                $query->filter(
                    ["bool" => ["must" => [$mustTerms]]]
                );
            }

            // title
            if (array_key_exists('title', $_GET)) {
                $query->query(
                    [
                        "match" => [
                            "title" => $_GET['title']
                        ]
                    ]
                );
            }

            // price
            $priceRange = array();
            if (array_key_exists('price_lte', $_GET)) {
                $priceRange[] = ["lte" => $_GET['price_lte']];
            }
            if (array_key_exists('price_gte', $_GET)) {
                $priceRange[] = ["gte" => $_GET['price_gte']];
            }
            if (!empty($priceRange)) {
                $query->filter(
                    [
                        "range" => [
                            "price" => $priceRange
                        ]
                    ]
                );
            }

            // age rane of listing in minutes (for testing and demoing purposes)
            $ageRange = array();
            if (array_key_exists('age_lte', $_GET)) {
                $upperStamp = time() - $_GET['age_lte']*60;
                $upperDate = date(DATE_ATOM, $upperStamp);

                $ageRange[] = ["lte" => $upperDate];
            }
            if (array_key_exists('age_gte', $_GET)) {
                $lowerStamp = time() - $_GET['age_gte']*60;
                $lowerDate = date(DATE_ATOM, $lowerStamp);

                $ageRange[] = ["gte" => $lowerDate];
            }
            if (!empty($ageRange)) {
                $query->filter(
                    [
                        "range" => [
                            "created_at" => $ageRange
                        ]
                    ]
                );
            }

            $provider = new ActiveDataProvider([
                'query' => $query,
            ]);
            if ($provider->getCount() <= 0)
            {
                throw new NotFoundHttpException('No posts are found with ' .
                    'the provided parameters, please update the search and try again.');
            }
            else
            {
                return $provider;
            }
        }
        else
        {
            throw new BadRequestHttpException('Please provide at least one '.
                'search terms: status, user_id, title, price_gte, price_lte, '.
                'age_gte, age_lte');
        }
    }
}
