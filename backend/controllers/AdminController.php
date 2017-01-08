<?php
namespace backend\controllers;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class AdminController extends Controller {
    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'controllers' => ['site'],
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
//                        'controllers' => ['site', 'categories', 'orders', 'users', 'products'],
//                        'actions' => ['logout', 'index'],
                        'allow' => true,
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
}
