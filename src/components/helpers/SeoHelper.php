<?php


namespace app\components\helpers;


use Yii;

class SeoHelper
{
    
    /**
     * Register OpenGraph meta-tags (facebook, telegram)
     *
     * @param $tags
     */
    public static function putOpenGraphTags($tags)
    {
        foreach ($tags as $prop => $content) {
            Yii::$app->view->registerMetaTag([
                                                 'property' => $prop,
                                                 'content' => $content,
                                             ], $prop);
        }
    }
    
    /**
     * Register meta-tags, usually title and description
     *
     * @param array $tags
     */
    public static function putDefaultTags($tags = [])
    {
        if (!empty($tags) and is_array($tags)) {
            
            foreach ($tags as $name => $content) {
                Yii::$app->view->registerMetaTag([
                                                     'name' => $name,
                                                     'content' => $content,
                                                 ], $name);
            }
        } else {
            Yii::$app->view->registerMetaTag([
                                                 'name' => 'title',
                                                 'content' => 'Купить спортивные товары Arena, Saucony, Asics, плавки, купальники, модную одежду недорого | магазин Киев',
                                             ], 'title');
            Yii::$app->view->registerMetaTag([
                                                 'name' => 'description',
                                                 'content' => 'Ищете качественные и оригинальные товары от Arena, Saucony, Asics, Speedo, Funky Trunks, Funkita? Тогда вам к нам. У нас вы найдете плавки, купальники, спортивный инвентарь, одежду, кроссовки. Приятные цены, акции каждую неделю. Заказывай быстрее!',
                                             ], 'description');
        }
    }
}