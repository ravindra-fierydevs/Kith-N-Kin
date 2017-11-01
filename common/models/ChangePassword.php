<?php
namespace common\models;

use Yii;
use yii\base\Model;

class ChangePassword extends Model
{
    public $old_password;
    public $new_password;
    public $confirm_password;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['old_password','new_password','confirm_password'], 'safe'],
            [['old_password','new_password','confirm_password'], 'required'],
            ['confirm_password', 'compare', 'compareAttribute'=>'new_password', 'message'=>"Passwords don't match"],
            ['old_password', 'validatePassword'],
        ];
    }

    public function findPassword($attribute, $params)
    {
        if(!$this->validatePass($this->old_password)){
            $this->addError($attribute,'Old password is incorrect');
            return false;
        }
        return true;
    }

    public function validatePass($password)
    {
        $user = User::findOne(Yii::$app->user->identity->id);
        return Yii::$app->security->validatePassword($password, $user->password_hash);
    }

    public function validateAppPass($password, $id)
    {
        $user = User::findOne($id);
        return Yii::$app->security->validatePassword($password, $user->password_hash);
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user->validatePassword($this->password)) {
                $this->addError($attribute,'Old password is incorrect');
            }
        }
    }

    protected function getUser()
    {
        if ($this->_user === null) {
            $user = User::findOne(Yii::$app->user->identity->id);
        }

        return $this->_user;
    }

}
