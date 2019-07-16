<?php

namespace app\modules\main\controllers;

use app\components\helpers\ValueHelper;
use app\components\models\Status;
use app\models\Category;
use app\models\Image;
use app\models\Item;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `main` module
 */
class ProductsController
    extends Controller
{
    
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    
    /**
     * Processing all requests like category/{slug}
     *
     * @param bool $slug
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionCategory($slug = false)
    {
        $slug = (int) preg_replace("[\D+]", "", $slug);
        
        // if empty after regexp check
        if (empty($slug)) {
            // get all nodes lvl=1
            
            $current = Category::findOne([ 'lvl' => 0, 'root' => 1 ]);
    
            $query = $current->children(1)->with('image')->andWhere([ 'active' => Status::STATUS_ACTIVE ]);
    
            $pages = new Pagination([
                                        'totalCount' => $query->count(),
                                        'pageSize' => 18,
                                        'defaultPageSize' => 18,
                                        'forcePageParam' => false,
                                    ]
            );
    
            $children = $query->offset($pages->offset)->limit($pages->limit)->all();
            
            return $this->render('category', [
                'children' => $children,
                'parents' => [],
                'current' => $current,
                'pages' => $pages,
            ]);
        } elseif ($current = Category::findOne([ 'id' => ValueHelper::decryptValue($slug), 'active' => Status::STATUS_ACTIVE, ])) {
            $activeParents = $current->parents()->andWhere([ 'active' => Status::STATUS_ACTIVE ])->all();
            
            if (count($activeParents) == $current['lvl']) {
                $query = $current->children(1)->andWhere([ 'active' => Status::STATUS_ACTIVE ]);
    
                $pages = new Pagination([
                                            'totalCount' => $query->count(),
                                            'pageSize' => 18,
                                            'defaultPageSize' => 18,
                                            'forcePageParam' => false,
                                        ]
                );
    
                $children = $query->offset($pages->offset)->limit($pages->limit)->all();
                
                if (!empty($children)) {
                    return $this->render('category', [
                        'children' => $children,
                        'parents' => $activeParents,
                        'current' => $current,
                        'pages' => $pages,
                    ]);
                } else {
                    return $this->redirect([ 'catalog', 'slug' => ValueHelper::encryptValue($current['id']) ]);
                }
            }
            
        }
        
        throw new NotFoundHttpException('Страница не найдена');
    }
    
    public function actionCatalog($slug = false)
    {
        $slug = (int) preg_replace("[\D+]", "", $slug);
        
        if (empty($slug)) {
    
            $query = Item::find()
                         ->select([ 'item.*', 'MIN(sizes.price) as min_price' ])
                         ->from(Item::tableName() . ' item')
                         ->joinWith([ 'allColors colors' => function ($query)
                         {
                             $query->joinWith([ 'allSizes sizes', 'mainImage' ]);
                         }, 'description' ])
                         ->with([ 'promotion' => function ($query)
                         {
                             $query->andWhere([ 'status' => Status::STATUS_ACTIVE ]);
                         } ])
                         ->where([
                                     'item.status' => Status::STATUS_ACTIVE,
                                     'colors.status' => Status::STATUS_ACTIVE,
                                     'sizes.status' => Status::STATUS_ACTIVE,
                                 ])
                         ->groupBy([ 'id' ])
                         ->orderBy([ 'rate' => SORT_DESC ]);
    
            $pages = new Pagination([
                                        'totalCount' => $query->count(),
                                        'pageSize' => 18,
                                        'defaultPageSize' => 18,
                                        'forcePageParam' => false,
                                    ]
            );
    
            $items = $query->offset($pages->offset)->limit($pages->limit)->asArray()->all();
            
            // all items, order by rate descending
            
            return $this->render('catalog', [
                'parents' => [],
                'current' => [ 'name' => 'Каталог' ],
                'items' => $items,
                'pages' => $pages,
            ]);
        } elseif ($current = Category::findOne([ 'id' => ValueHelper::decryptValue($slug), 'active' => Status::STATUS_ACTIVE ])) {
            if ($current['rgt'] != $current['lft'] + 1) {
                return $this->redirect([ 'category', 'slug' => ValueHelper::encryptValue($current['id']) ]);
            } else {
                $activeParents = $current->parents()->andWhere([ 'active' => Status::STATUS_ACTIVE ])->all();
                
                if (count($activeParents) == $current['lvl']) {
                    
                    $query = Item::find()
                                 ->select([ 'item.*', 'MIN(sizes.price) as min_price' ])
                                 ->from(Item::tableName() . ' item')
                                 ->joinWith([ 'allColors colors' => function ($query)
                                 {
                                     $query->joinWith([ 'allSizes sizes', 'mainImage' ]);
                                 }, 'description' ])
                                 ->with([ 'promotion' => function ($query)
                                 {
                                     $query->andWhere([ 'status' => Status::STATUS_ACTIVE ]);
                                 } ])
                                 ->where([
                                     'item.category_id' => $current['id'],
                                     'item.status' => Status::STATUS_ACTIVE,
                                     'colors.status' => Status::STATUS_ACTIVE,
                                     'sizes.status' => Status::STATUS_ACTIVE,
                                 ])
                                 ->groupBy([ 'id' ])
                                 ->orderBy([ 'rate' => SORT_DESC ]);
                    
                    $pages = new Pagination([
                            'totalCount' => $query->count(),
                            'pageSize' => 18,
                            'defaultPageSize' => 18,
                            'forcePageParam' => false,
                        ]
                    );
                    
                    $items = $query->offset($pages->offset)->limit($pages->limit)->asArray()->all();
                    
                    return $this->render('catalog', [
                        'items' => $items,
                        'parents' => $activeParents,
                        'current' => $current,
                        'pages' => $pages,
                    ]);
                }
            }
        }
        
        throw new NotFoundHttpException('Страница не найдена');
    }
    
    public function actionProduct($slug)
    {
        $slug = (int) preg_replace("[\D+]", "", $slug);
        
        if (!empty($slug)) {
            // let's find item
            // check if exists that category and him parents
            $item = Item::find()
                        ->from(Item::tableName() . ' item')
                        ->joinWith([ 'allColors colors' => function ($query)
                        {
                            $query->joinWith([ 'allSizes sizes', 'allImages images' ]);
                        }, 'description' ])
                        ->with([ 'promotion' => function ($query)
                        {
                            $query->andWhere([ 'status' => Status::STATUS_ACTIVE ]);
                        } ])
                        ->where([
                            'images.type' => Image::TYPE_ITEM,
                            'item.id' => ValueHelper::decryptValue($slug),
                            'item.status' => Status::STATUS_ACTIVE,
                            'colors.status' => Status::STATUS_ACTIVE,
                            'sizes.status' => Status::STATUS_ACTIVE,
                        ])
                        ->asArray()
                        ->one();
    
            if (!empty($item)) {
                
                $current = Category::findOne([ 'id' => $item['category_id'], 'active' => Status::STATUS_ACTIVE ]);
                
                $parents = ArrayHelper::toArray(array_merge($current->parents()->all(), [ $current ]));
                
                unset($current);
    
                // check if exists this item in any promotions
                
                return $this->render('product', [
                    'item' => $item,
                    'parents' => $parents,
                ]);
            }
            
        }
        
        throw new NotFoundHttpException('Страница не найдена');
    }
}
