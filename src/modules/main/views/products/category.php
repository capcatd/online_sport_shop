<?php

use app\components\helpers\ValueHelper;
use app\components\widgets\Paginator;
use app\models\Image;
use yii\helpers\Html;

/** @var array $current */
/** @var array $parents */
/** @var array $children */
/** @var \yii\data\Pagination $pages */

$this->title = $current['name'];

if (!empty($parents)) {
    foreach ($parents as $parent) {
        $this->params['breadcrumbs'][] = [ 'url' => \yii\helpers\Url::to([ '/main/products/category', 'slug' => $parent['lvl'] != 0 ? ValueHelper::encryptValue($parent['id']) : false ]), 'label' => $parent['name'] ];
    }
}

$this->params['breadcrumbs'][] = $this->title;
?>


<div class="blog-area pt-100 pb-100">
    <div class="container">
        <div class="row">
            <?php foreach ($children as $child): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="blog-wrap mb-40 text-center scroll-zoom">
                        <div class="blog-img mb-25">
                            <?= Html::a(Html::img(Image::getLink($child['image']['id'], Image::SIZE_MEDIUM),
                                                  [ 'alt' => $child['name'] ]),
                                        [ '/main/products/category', 'slug' => ValueHelper::encryptValue($child['id']) ]) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <!--        pagination-->
        <?=
        Paginator::widget([
                              'pagination' => $pages,
                          ])
        ?>
    </div>
</div>