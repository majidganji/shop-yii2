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
class User extends \yii\db\ActiveRecord
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
            [['name', 'family', 'username', 'city_id', 'address', 'postcode', 'phone', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['city_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['address'], 'string'],
            [['name', 'family', 'username', 'phone', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['postcode'], 'string', 'max' => 10],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['status'], 'in', 'range' => [0, 10]],
            [['password_reset_token'], 'unique']
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
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', 'ایمیل'),
            'status' => Yii::t('app', 'فعال'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
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
        $item[''][''] = 'شهر خود را انتخاب کنید.';
        foreach (States::find()->where(['confirmed' => 1])->orderBy('name')->all() as $state){
            foreach (Cities::find()->where(['confirmed' => 1, 'state_id' => $state->id])->orderBy('name')->all() as $city){
                $item[$state->name][$city->id]= $city->name;
            }
        }
        return $item;
    }
}
