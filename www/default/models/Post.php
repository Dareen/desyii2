<?php

namespace app\models;

use \yii\elasticsearch\ActiveRecord;

class Post extends ActiveRecord
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
            'status',
            # post/listing details
            # basic
            'title',
            'price',
            'description',
        ];
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
            [['description'], 'string', 'min' => 5],
            [['id'], 'integer'],
            [['title'], 'string', 'max' => 250],
            [['status'], 'integer', 'min' => 0, 'max' => 10],
        ];
    }

    /**
     * Defines a scope that modifies the `$query` to return only active(status = 1) posts
     */
    public static function active($query)
    {
        $query->andWhere(['status' => 1]);
    }
}
