<?php

namespace app\components\helpers;

use Yii;
use yii\helpers\ArrayHelper;

class Permission
{
    
    /**
     * Проверяет доступ текущего пользователя к правилу
     *
     * @param $rule string|array
     *
     * @return bool
     */
    public static function can($rule)
    {
        $auth = Yii::$app->authManager;
        $user_id = Yii::$app->user->identity->id;
        
        if (array_key_exists('admin', $auth->getRolesByUser($user_id))) {
            return true;
        }
    
        if (is_string($rule)) {
            if (self::permissionExist($rule)) {
                return Yii::$app->user->can($rule);
            }
        }
    
        if (is_array($rule) and !empty($rule)) {
            foreach ($rule as $one) {
                if (!Yii::$app->user->can($one)) {
                    continue;
                }
            
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Проверяет наличие правила в списке существующих
     *
     * @param $rule
     *
     * @return bool
     */
    public static function permissionExist($rule)
    {
        if (ArrayHelper::keyExists($rule, self::getAllPermissions())) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Возврашает все разрешения
     *
     * @return array
     */
    public static function getAllPermissions()
    {
        // todo-cache: add caching
        return ArrayHelper::getColumn(Yii::$app->authManager->getPermissions(), 'name');
    }
    
    /**
     * Возвращает результат добавления нового правила
     *
     * @param $module string
     * @param $controller string
     * @param $action string
     *
     * @return bool
     * @throws \Exception возникает при некорректных данных
     */
    public static function addNewPermission($module, $controller, $action)
    {
        $rule = $module . '_' . $controller . '_' . $action;
        
        if (!self::permissionExist($rule)) {
            $auth = Yii::$app->authManager;
            
            $rule = $auth->createPermission($rule);
            $rule->description = $module . '_' . $controller;
            if ($auth->add($rule))
                return true;
        }
        
        return false;
    }
    
    public static function getAllRoles()
    {
        //todo-cache: add cache
        return ArrayHelper::map(ArrayHelper::toArray(Yii::$app->authManager->getRoles()), 'name', 'name');
    }
}