<?php

namespace app\models;

/**
 * This is the model class for table "auth_assignment".
 *
 * @property string $item_name
 * @property string $user_id
 * @property int $created_at
 *
 * @property AuthItem $itemName
 */
class AuthAssignment extends \yii\db\ActiveRecord
{
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_assignment';
    }
    
    public static function deleteRolesById($user_id)
    {
        if (is_int($user_id)) {
            return self::deleteAll([
                                       'user_id' => $user_id,
                                   ]);
        }
        
        return null;
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [ [ 'item_name', 'user_id' ], 'required' ],
            [ [ 'created_at' ], 'integer' ],
            [ [ 'item_name', 'user_id' ], 'string', 'max' => 64 ],
            [ [ 'item_name', 'user_id' ], 'unique', 'targetAttribute' => [ 'item_name', 'user_id' ] ],
            [ [ 'item_name' ], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => [ 'item_name' => 'name' ] ],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'item_name' => 'Item Name',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemName()
    {
        return $this->hasOne(AuthItem::className(), [ 'name' => 'item_name' ]);
    }
}
