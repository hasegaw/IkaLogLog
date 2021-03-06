<?php
namespace app\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $screen_name;
    public $password;
    private $user = false;

    public function rules()
    {
        $rules = [
            [['screen_name', 'password'], 'required'],
            [['screen_name'], 'string', 'max' => 15],
            [['screen_name'], 'match',
                'pattern' => '/^[a-zA-Z0-9_]{1,15}$/',
                'message' => 'ログイン名は英数とアンダーバーの15文字以内で入力してください。',
            ],
            [['password'], 'validatePassword'],
        ];
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'screen_name'       => 'ログイン名',
            'password'          => 'パスワード',
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if ($this->hasErrors()) {
            return;
        }
        $user = $this->getUser();
        if (!$user || !$user->validatePassword($this->password)) {
            $this->addError($attribute, 'ログイン名またはパスワードが違います。');
        }
    }

    public function login()
    {
        if (!$this->validate()) {
            return false;
        }
        $user = $this->getUser();
        if ($user->rehashPasswordIfNeeded($this->password)) {
            $user->save();
        }
        return Yii::$app->user->login($user, 0);
    }

    public function getUser()
    {
        if ($this->user === false) {
            $this->user = User::findOne(['[[screen_name]]' => $this->screen_name]);
        }
        return $this->user;
    }
}
