<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $family
 * @property integer $city_id
 * @property string $address
 * @property string $postcode
 * @property string $phone
 * @property string $email
 * @property string $comment
 * @property integer $amount
 * @property integer $ts
 * @property string $au
 * @property integer $paid
 * @property integer $confirmed
 *
 * @property Orderproducts[] $orderproducts
 * @property Products[] $products
 * @property User $user
 * @property Cities $city
 */
class Orderssearch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'family', 'postcode', 'id', 'au'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ردیف'),
            'name' => Yii::t('app', 'نام'),
            'family' => Yii::t('app', 'نام خانوادگی'),
            'postcode' => Yii::t('app', 'کد پستی'),
            'au' => Yii::t('app', 'کد بانک'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderproducts()
    {
        return $this->hasMany(Orderproducts::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['id' => 'product_id'])->viaTable('orderproducts', ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }
}
