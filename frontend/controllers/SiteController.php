<?php

namespace frontend\controllers;

use common\models\LoginForm;
use frontend\models\ContactForm;
use frontend\models\Orders;
use frontend\models\PasswordResetRequestForm;
use frontend\models\Products;
use frontend\models\ResetPasswordForm;
use Yii;
use yii\base\InvalidParamException;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'state'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => TRUE,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'state'],
                        'allow' => TRUE,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : NULL,
            ],
        ];
    }

    /**
     * Displays homepage.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Products::find()->where(['confirmed' => 1]);
        $pagination = new Pagination([
            'totalCount' => $query->count(),
            'defaultPageSize' => 12,
        ]);
        $models = $query->offset($pagination->offset)->limit($pagination->limit)->orderBy('id DESC')->all();

        return $this->render('index', [
            'models' => $models,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Logs in a user.
     * @return mixed
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new \frontend\models\User();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                return $this->redirect(['site/login']);
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }


    /**
     * Resets password.
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionState($track = NULL)
    {
        if ($track != NULL) {
            list($id) = explode('-', $track);
            if (!$model = Orders::findOne(['id' => $id, 'confirmed' => 1])) {
                throw new \yii\web\HttpException(404, 'فاکتوری با این مشخصات پیدا نشد .');
            }
            if ($model->user_id != Yii::$app->user->id) {
                throw new \yii\web\HttpException(404, 'شما مجاز به مشاهده خرید سایر کاربران نیستید .');
            }

            return $this->render('order', ['model' => $model]);
        } else {
            $models = Orders::find()->where(['user_id' => Yii::$app->user->id, 'confirmed' => 1])->orderBy('id DESC')->all();

            return $this->render('state', ['models' => $models]);
        }

    }
//    public function actionTest () {
//        $model = new Products();
//        if (Yii::$app->request->post()) {
//            echo '<pre>';
//            echo (!empty(Yii::$app->security->validateData(Yii::$app->request->post('hidden'), 'ENOLVVwBJeZjdjfth_8S')) ? 'true' : 'false');
//            die;
//            echo '</pre>';f
//        }
//
//        return $this->render('test', compact('model'));
//    }

}
