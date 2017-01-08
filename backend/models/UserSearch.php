<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $family
 * @property string $username
 * @property integer $city_id
 * @property string $address
 * @property string $postcode
 * @property string $phone
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Orders[] $orders
 * @property Cities $city
 */
class UserSearch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'family', 'username', 'city_id', 'address', 'postcode', 'phone', 'email', 'id','status', ], 'safe'],
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
            'username' => Yii::t('app', 'نام کاربری'),
            'city_id' => Yii::t('app', 'شهر'),
            'address' => Yii::t('app', 'آدرس'),
            'postcode' => Yii::t('app', 'کد پستی'),
            'phone' => Yii::t('app', 'تلفن'),
            'email' => Yii::t('app', 'ایمیل'),
            'status' => Yii::t('app', 'فعال'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }
    
    public function getCityOptions(){
        $item[''][''] = 'شهر را انتخاب کنید.';
        foreach (States::find()->where(['confirmed' => 1])->orderBy('name')->all() as $state){
            foreach (Cities::find()->where(['confirmed' => 1, 'state_id' => $state->id])->orderBy('name')->all() as $city){
                $item[$state->name][$city->id]= $city->name;
            }
        }
        return $item;
    }
}
