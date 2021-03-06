<?php
namespace app\modules\users\models\SRL;
use Yii;
use app\modules\users\models\VML\LoginVML;
use app\modules\users\models\DAL\User;
class AuthSRL {
    public static function newLoginViewModel() {
        $data     = new LoginVML();
        return $data;
    }
    public static function login($data) {
        if (!$data->validate()) {
            return false;
        }
        $module = Yii::$app->getModule('users');
        $model = UsersSRL::findUser(['mobile' => $data->mobile, 'status_id' => $module->params['status.Active']]);
        if (!$model) {
            $data->addError('mobile', Yii::t('users', 'Incorrect Mobile.'));
            return false;
        }
        if (!Yii::$app->security->validatePassword($data->password, $model->password_hash)) {
            $data->addError('password', Yii::t('users', 'Incorrect Password.'));
            return false;
        }
        $user = User::findIdentity($model->id);
        return Yii::$app->user->login($user, $data->rememberMe ? $module->params['rememberMeExpire'] : 0);
    }
}