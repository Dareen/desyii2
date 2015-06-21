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
            [['id'], 'string'],
            [['title', 'price'], 'required'],
            ['description', 'string', 'min' => 5],
            [['user_id', 'updated_by'], 'integer'],
            [['price'], 'number'],
            [['title', 'slug'], 'string', 'max' => 250],
            [['created_at', 'updated_at'], 'date', 'format' => 'php:'.DATE_ATOM],
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
                    return $this->getUser()->email;
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'mobile',
                ],
                'value' => function ($event) {
                    if ($this->getUser()->hasAttribute('mobile'))
                        return $this->getUser()->mobile;
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
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'status',
                ],
                'value' => 1,
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
     * Get user model
     *
     * @param  string      $title
     * @return User model
     */
    public function getUser()
    {
        return User::find()->where(['id' => $this->user_id])->one();
    }
}
