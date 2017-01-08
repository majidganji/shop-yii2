<?php

namespace backend\models;

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
class Products extends \yii\db\ActiveRecord {

    public $pic;
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'products';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['category_id', 'name', 'price', 'quantity', 'confirmed'], 'required'],
            [['pic'], 'required', 'on' => 'create'],
            [['category_id', 'price', 'quantity', 'confirmed'], 'integer'],
            [['pic'], 'file', 'extensions' => 'png, jpg'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ردیف'),
            'category_id' => Yii::t('app', 'دسته بندی'),
            'name' => Yii::t('app', 'نام'),
            'price' => Yii::t('app', 'قیمت واحد'),
            'quantity' => Yii::t('app', 'تعداد'),
            'confirmed' => Yii::t('app', 'فعال'),
            'pic' => 'تصویر',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderproducts() {
        return $this->hasMany(Orderproducts::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders() {
        return $this->hasMany(Orders::className(), ['id' => 'order_id'])->viaTable('orderproducts', ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory() {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }
    
    public function getCategoryOptions(){
        $item[''] = 'دسته بندی مورد نظر را انتخاب کنید';
        foreach (Categories::find()->orderBy('name')->all() as $category){
            $item[$category->id] = $category->name;
        }
        return $item;
    }
    
    public function beforeValidate() {
        $this->pic = \yii\web\UploadedFile::getInstance($this, 'pic');
        return parent::beforeValidate();
    }

}
