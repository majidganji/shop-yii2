<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property integer $price
 * @property integer $quantity
 * @property integer $confirmed
 *
 * @property Orderproducts[] $orderproducts
 * @property Orders[] $orders
 * @property Categories $category
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'name', 'price', 'quantity', 'confirmed'], 'required'],
            [['category_id', 'price', 'quantity', 'confirmed'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ردیف'),
            'category_id' => Yii::t('app', 'دسته بندی'),
            'name' => Yii::t('app', 'نام'),
            'price' => Yii::t('app', 'قیمت واحد'),
            'quantity' => Yii::t('app', 'تعداد'),
            'confirmed' => Yii::t('app', 'فعال'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderproducts()
    {
        return $this->hasMany(Orderproducts::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['id' => 'order_id'])->viaTable('orderproducts', ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }
}
