<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "orderproducts".
 *
 * @property integer $order_id
 * @property integer $product_id
 * @property integer $quantity
 * @property integer $confirmed
 *
 * @property Orders $order
 * @property Products $product
 */
class Orderproducts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orderproducts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id', 'quantity', 'confirmed'], 'required'],
            [['order_id', 'product_id', 'quantity', 'confirmed'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => Yii::t('app', 'سفارش'),
            'product_id' => Yii::t('app', 'محصول'),
            'quantity' => Yii::t('app', 'تعداد'),
            'confirmed' => Yii::t('app', 'فعال'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::className(), ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }
}
