<?php

namespace app\modules\user\models\forms;

use app\modules\user\models\User;
use Yii;
use yii\base\Model;

/**
 * Password reset form
 */
class PasswordChangeForm extends Model
{
    
    public $currentPassword;
    
    public $newPassword;
    
    public $newPasswordRepeat;
    
    /**
     * @var User
     */
    private $_user;
    
    /**
     * @param User $user
     * @param array $config
     */
    public function __construct(User $user, $config = [])
    {
        $this->_user = $user;
        parent::__construct($config);
    }
    
    public function rules()
    {
        return [
            [ [ 'currentPassword', 'newPassword', 'newPasswordRepeat' ], 'required' ],
            [ 'currentPassword', 'validatePassword' ],
            [ 'newPassword', 'string', 'min' => 6 ],
            [ 'newPasswordRepeat', 'compare', 'compareAttribute' => 'newPassword' ],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'newPassword' => Yii::t('user', '_USER_NEW_PASSWORD'),
            'newPasswordRepeat' => Yii::t('user', '_USER_REPEAT_PASSWORD'),
            'currentPassword' => Yii::t('user', '_USER_CURRENT_PASSWORD'),
        ];
    }
    
    /**
     * @param string $attribute
     * @param array $params
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (!$this->_user->validatePassword($this->$attribute)) {
                $this->addError($attribute, Yii::t('user', '_ERROR_WRONG_CURRENT_PASSWORD'));
            }
        }
    }
    
    /**
     * @return boolean
     */
    public function changePassword()
    {
        if ($this->validate()) {
            $user = $this->_user;
            $user->setPassword($this->newPassword);
            
            return $user->save();
        } else {
            return false;
        }
    }
}
