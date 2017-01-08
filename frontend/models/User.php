<?php

namespace frontend\models;

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
class User extends \yii\db\ActiveRecord {

    public $password;
    public $password_repeat;
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'family', 'username', 'city_id', 'address', 'postcode', 'phone', 'auth_key', 'password', 'password_repeat', 'email', 'created_at', 'updated_at'], 'required'],
            [['city_id', 'status', 'created_at', 'updated_at', 'postcode', 'phone'], 'integer'],
            [['address'], 'string'],
            [['username', 'email', 'phone'], 'unique'],
            [['name', 'family', 'username', 'phone', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['postcode'], 'string', 'max' => 10],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_hash', 'password'], 'safe'],
            ['password_repeat', 'compare', 'compareAttribute'=>'password'],
            [['password_reset_token'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ردیف',
            'name' => 'نام',
            'family' => 'نام خانوادگی',
            'username' => 'نام کاربری',
            'city_id' => 'شهر',
            'address' => 'آدرس',
            'postcode' => 'کد پستی',
            'phone' => Yii::t('app', 'تلفن'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            
            'password' => Yii::t('app', 'رمز عبور'),
            'password_repeat' => Yii::t('app', 'تکرار رمز عبور'),
            
            'password_hash' => Yii::t('app', 'رمز عبور'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', 'ایمیل'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function beforeValidate() {
        $this->generateAuthKey();
        $this->setPassword($this->password);
        $this->created_at = time();
        $this->updated_at = time();
        return parent::beforeValidate();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders() {
        return $this->hasMany(Orders::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity() {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
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
