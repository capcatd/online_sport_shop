<?php

namespace app\modules\user\models\forms;

use app\modules\user\models\User;
use Yii;
use yii\base\Model;
use yii\db\ActiveQuery;

class ProfileUpdateForm extends Model
{
    
    public $email;
    
    /**
     * @var User
     */
    private $_user;
    
    public function __construct(User $user, $config = [])
    {
        $this->_user = $user;
        parent::__construct($config);
    }
    
    public function init()
    {
        $this->email = $this->_user->email;
        parent::init();
    }
    
    public function rules()
    {
        return [
            [ 'email', 'required' ],
            [ 'email', 'email' ],
            [
                'email',
                'unique',
                'targetClass' => User::className(),
                'message' => Yii::t('user', '_ERROR_EMAIL_EXISTS'),
                'filter' => function(ActiveQuery $query) {
                    $query->andWhere([ '<>', 'id', $this->_user->id ]);
                },
            ],
            [ 'email', 'string', 'max' => 255 ],
        ];
    }
    
    public function update()
    {
        if ($this->validate()) {
            $user = $this->_user;
            $user->email = $this->email;
            
            return $user->save();
        } else {
            return false;
        }
    }
}
