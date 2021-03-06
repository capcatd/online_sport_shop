<?php

namespace app\models;

/**
 * This is the model class for table "user".
 *
 * @property int    $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $password_hash
 * @property string $auth_key
 * @property string $email_confirm_token
 * @property string $password_reset_token
 * @property int    $status
 * @property int    $created_at
 * @property int    $updated_at
 */
class User extends \yii\db\ActiveRecord
{
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [ [ 'email', 'phone' ], 'required' ],
            [ [ 'status', 'created_at', 'updated_at' ], 'integer' ],
            [ [ 'name', 'email', 'password_hash', 'email_confirm_token', 'password_reset_token' ], 'string', 'max' => 255 ],
            [ [ 'auth_key' ], 'string', 'max' => 32 ],
            [ [ 'name', 'email' ], 'unique' ],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'email' => 'Email',
            'password_hash' => 'Password Hash',
            'auth_key' => 'Auth Key',
            'email_confirm_token' => 'Email Confirm Token',
            'password_reset_token' => 'Password Reset Token',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
