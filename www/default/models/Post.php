<?php

namespace app\models;

use yii\elasticsearch\ActiveRecord;
use yii\base\NotSupportedException;
use yii\web\Linkable;
use yii\web\Link;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\AttributeBehavior;

class Post extends ActiveRecord implements Linkable
{
    // TODO: Consider PostQuery?

    /**
     * @return array the list of attributes for this record
     */
    public function attributes()
    {
        // path mapping for '_id' is setup to field 'id'
        return [
            // meta
            'id',
            'user_id',
            'created_at',
            'updated_at',
            'updated_by',
            'slug',
            'status',
            # post/listing details
            # basic
            'title',
            'price',
            'description',
            # user contact info
            'mobile',
            // TODO: to be used for communication, the server should handle
            // sending the email to the owner to avoid exposing their email
            'email',
        ];
    }

    public function fields()
    {
        $fields = parent::fields();

        // remove fields that contain sensitive information
        unset(
            $fields['user_id'],
            $fields['created_by'],
            $fields['updated_by'],
            $fields['email']
        );
        return $fields;
    }

    public static function primaryKey()
    {
        return ['id'];
    }

    /**
     * Define rules for validation
     */
    public function rules()
    {
        return [
            [['title', 'price'], 'required'],
            ['description', 'string', 'min' => 5],
            [['user_id', 'updated_by', 'id'], 'integer'],
            [['price'], 'number'],
            [['title', 'slug'], 'string', 'max' => 250],
            [['created_at', 'updated_at'], 'date'],
            [['mobile'], 'safe'],
            [['email'], 'email'],
            [['status'], 'in', 'range' => [0, 1]],
        ];
    }
    public function behaviors()
    {
        $behaviors = ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => TimestampBehavior::className(),
                'value' => function() { return date(DATE_ATOM); },
            ],
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'email',
                ],
                'value' => function ($event) {
                    return 'fake email';
                    // TODO:
                    // var_dump($this->getUser());
                    // exit;
                    // return $this->getUser()->email;
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'mobile',
                ],
                'value' => function ($event) {
                    return 'fake mobile';
                    // TODO:
                    // return $this->getUser()->username;
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'id',
                ],
                'value' => function ($event) {
                    return md5(time()+rand(0, 10000));
                },
            ],
        ]);

        return $behaviors;
    }

    public function getLinks()
    {
        return [

            # TODO: fix this to be restful /posts/<id>

            Link::REL_SELF => Url::to(['index', 'id' => $this->id], true),
        ];
    }


    /**
     * Defines a scope that modifies the `$query` to return only active(status = 1) posts
     */
    public static function active($query)
    {
        $query->andWhere(['status' => 1]);
    }

    /**
     * Finds post by userId
     *
     * @param  int      $userId
     * @return ??
     */
    public static function findByUserId($userId)
    {
        $result = Post::find()->where(['user_id' => $userId])->all();
    }

    /**
     * Finds posts by title
     *
     * @param  string      $title
     * @return ??
     */
    public static function findByTitle($title)
    {
        // posts which title contains $title
        $result = Post::find()->query(["match" => ["title" => $title]])->all();
    }

    /**
     * Get user model
     *
     * @param  string      $title
     * @return User model
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
