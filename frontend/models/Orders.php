<?php

namespace frontend\models;

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
 * @property Cities $city
 * @property User $user
 */
class Orders extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'city_id', 'amount', 'ts', 'paid', 'postcode', 'phone', 'confirmed'], 'integer'],
            [['name', 'family', 'city_id', 'address', 'postcode', 'phone'], 'required'],
            [['comment', 'confirmed','paid', 'au'], 'safe'],
            [['address', 'comment'], 'string'],
            [['name', 'family', 'phone', 'email', 'au'], 'string', 'max' => 255],
            [['postcode'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ردیف'),
            'user_id' => Yii::t('app', 'کاربر'),
            'name' => Yii::t('app', 'نام'),
            'family' => Yii::t('app', 'نام خانوادگی'),
            'city_id' => Yii::t('app', 'شهر'),
            'address' => Yii::t('app', 'نشانی'),
            'postcode' => Yii::t('app', 'کد پستی'),
            'phone' => Yii::t('app', 'تلفن'),
            'email' => Yii::t('app', 'ایمیل'),
            'comment' => Yii::t('app', 'توضیحات'),
            'amount' => Yii::t('app', 'مبلغ'),
            'ts' => Yii::t('app', 'زمان خرید'),
            'au' => Yii::t('app', 'کد بانک'),
            'paid' => Yii::t('app', 'پرداخت شده'),
            'confirmed' => Yii::t('app', 'فعال'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderproducts() {
        return $this->hasMany(Orderproducts::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts() {
        return $this->hasMany(Products::className(), ['id' => 'product_id'])->viaTable('orderproducts', ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity() {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery2
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function getCityOptions(){
        $item[''][''] = 'شهر خود را انتخاب کنید.';
        foreach (States::find()->where(['confirmed' => 1])->orderBy('name')->all() as $state){
            foreach (Cities::find()->where(['confirmed' => 1, 'state_id' => $state->id])->orderBy('name')->all() as $city){
                $item[$state->name][$city->id]= $city->name;
            }
        }
        return $item;
    }

}
