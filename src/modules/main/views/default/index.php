<?php

/** @var array $banners */

use app\components\helpers\ValueHelper;
use app\models\Image;
use app\models\Promotion;
use yii\helpers\Html;

/** @var array $popular */

?>

<?php if (!empty($banners) and is_array($banners)): ?>
<div class="slider-area section-padding-1">
    <div class="slider-active-2 owl-carousel nav-style-2 dot-style-1">
        <?php foreach ($banners as $banner): ?>
            <div class="single-slider slider-height-2 bg-aliceblue">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-12 col-sm-6">
                            <div class="slider-content pt-180 slider-animated-1">
                                <h1 class="animated"><?= $banner['title'] ?></h1>
                                <p class="animated"><?= $banner['description'] ?></p>
                                <div class="slider-btn btn-hover">
                                    <a class="animated" target="_blank"
                                       href="<?= $banner['link'] ?>"><?= $banner['link_title'] ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-12 col-sm-6">
                            <div class="slider-single-img-2 slider-animated-1">
                                <?= \yii\helpers\Html::img(\app\models\Image::getLink($banner['image']['id']), [
                                    'class' => 'animated',
                                    'alt' => $banner['image']['url'],
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<div class="banner-area pt-100 pb-65">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="single-banner mb-30 scroll-zoom">
                    <a href="product-details.html"><img class="animated" src="/images/main/banner/banner-6.png"
                                                        alt=""></a>
                    <div class="banner-content-2 banner-position-5">
                        <h4>Women</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="single-banner mb-30 scroll-zoom">
                    <a href="product-details.html"><img class="animated" src="/images/main/banner/banner-7.png"
                                                        alt=""></a>
                    <div class="banner-content-2 banner-position-5">
                        <h4>Men</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="single-banner mb-30 scroll-zoom">
                    <a href="product-details.html"><img class="animated" src="/images/main/banner/banner-8.png"
                                                        alt=""></a>
                    <div class="banner-content-2 banner-position-5">
                        <h4>accessories</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="single-banner mb-30 scroll-zoom">
                    <a href="product-details.html"><img class="animated" src="/images/main/banner/banner-9.png"
                                                        alt=""></a>
                    <div class="banner-content banner-position-6">
                        <h3>Black Friday</h3>
                        <h2>Wall Lighting <br>Black.</h2>
                        <a href="product-details.html">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="single-banner mb-30 text-center scroll-zoom">
                    <a href="product-details.html"><img class="animated" src="/images/main/banner/banner-10.png"
                                                        alt=""></a>
                    <div class="banner-content-3 banner-position-7">
                        <h2>Wall Lighting Black.</h2>
                        <a href="product-details.html">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="product-area pb-70">
    <div class="container">
        <div class="section-title text-center pb-45">
            <h2>Топы продаж</h2>
            <p> Эти товары раскупают быстрее всего, успей заказать и ты</p>
        </div>
        <div class="arrivals-wrap scroll-zoom">
            <div class="ht-products product-slider-active-2 owl-carousel">
                <?php foreach ($popular as $item): ?>
                    <div class="ht-product ht-product-action-on-hover ht-product-category-right-bottom mb-30">
                        <div class="ht-product-inner">
                            <div class="ht-product-image-wrap">
                                <span class="ht-product-label ht-product-label-left">HOT</span>
                                <?php if (!empty($item['promotion'])): ?>
                                    <span class="ht-product-label ht-product-label-right">Sale</span>
                                <?php endif; ?>
                                
                                <?=
                                Html::a(Html::img(Image::getLink($item['allColors'][0]['mainImage']['id'],
                                    Image::SIZE_512x512), [
                                    'alt' => $item['allColors'][0]['mainImage']['url'],
                                ]),
                                    [ '/main/products/product', 'slug' => ValueHelper::encryptValue($item['id']) ],
                                    [
                                        'class' => 'ht-product-image',
                                    ])
                                ?>
                                <div class="ht-product-action">
                                    <ul>
                                        <!--                                        <li><a href="#" data-toggle="modal" data-target="#exampleModal"><i-->
                                        <!--                                                        class="sli sli-magnifier"></i><span-->
                                        <!--                                                        class="ht-product-action-tooltip">Quick View</span></a></li>-->
                                        <!--                                        <li><a href="#"><i class="sli sli-heart"></i><span-->
                                        <!--                                                        class="ht-product-action-tooltip">Add to Wishlist</span></a>-->
                                        <!--                                        </li>-->
                                        <!--                                        <li><a href="#"><i class="sli sli-refresh"></i><span-->
                                        <!--                                                        class="ht-product-action-tooltip">Add to Compare</span></a></li>-->
                                        <li><a href="#"><i class="sli sli-bag"></i><span
                                                        class="ht-product-action-tooltip">Добавить в корзину</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="ht-product-content">
                                <div class="ht-product-content-inner">
                                    <h4 class="ht-product-title"><a
                                                href="#"><?= $item['firm'] . ' ' . $item['model'] ?></a></h4>
                                    <div class="ht-product-price">
                                        <span class="new"><?php
    
                                            if ($item['promotion']['type'] == Promotion::TYPE_PERCENT) {
                                                echo ValueHelper::formatPrice($item['min_price'] * ( 100 - $item['promotion']['sale'] ) / 100);
                                            } elseif ($item['promotion']['type'] == Promotion::TYPE_VALUE) {
                                                echo ValueHelper::formatPrice($item['min_price'] - $item['promotion']['sale']);
                                            } else {
                                                echo ValueHelper::formatPrice($item['min_price']);
                                            }
                                            ?></span>
                                        <?php if (!empty($item['promotion'])): ?>
                                            <span class="old"> <?= ValueHelper::formatPrice($item['min_price']); ?> </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="ht-product-ratting-wrap">
                                        <span class="ht-product-ratting">
                                            <span class="ht-product-user-ratting" style="width: <?= $item['rate'] ?>%;">
                                                <i class="sli sli-star"></i>
                                                <i class="sli sli-star"></i>
                                                <i class="sli sli-star"></i>
                                                <i class="sli sli-star"></i>
                                                <i class="sli sli-star"></i>
                                            </span>
                                        <i class="sli sli-star"></i>
                                        <i class="sli sli-star"></i>
                                        <i class="sli sli-star"></i>
                                        <i class="sli sli-star"></i>
                                        <i class="sli sli-star"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="ht-product-action">
                                    <ul>
                                        <!--                                        <li><a href="#"><i class="sli sli-magnifier"></i><span-->
                                        <!--                                                        class="ht-product-action-tooltip">Quick View</span></a></li>-->
                                        <!--                                        <li><a href="#"><i class="sli sli-heart"></i><span-->
                                        <!--                                                        class="ht-product-action-tooltip">Add to Wishlist</span></a>-->
                                        <!--                                        </li>-->
                                        <!--                                        <li><a href="#"><i class="sli sli-refresh"></i><span-->
                                        <!--                                                        class="ht-product-action-tooltip">Add to Compare</span></a></li>-->
                                        <li><a href="#"><i class="sli sli-bag"></i><span
                                                        class="ht-product-action-tooltip">Добавить в корзину</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<div class="banner-area pt-80 pb-80 section-margin-1 bg-aliceblue">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 col-md-7 col-sm-7">
                <div class="banner-img-2 pr-10 scroll-zoom">
                    <a href="product-details.html"><img src="/images/main/banner/banner-11.png" alt=""></a>
                </div>
            </div>
            <div class="col-lg-4 col-md-5 col-sm-5">
                <div class="banner-bg-content pl-100 scroll-zoom">
                    <h3>35% off <br>Black Monday</h3>
                    <h2>Lighting For <br> Home.</h2>
                    <a href="product-details.html">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="instagram-area section-margin-1 py-5">
    <div class="container">
        <div class="section-title text-center pb-45">
            <h2>Наш Instagram</h2>
            <p>Здесь вы сможете найти актуальные новости и в числе первых узнать о приближающихся акциях</p>
        </div>
    </div>
    <div class="instagram-feed-thumb">
        <div id="instafeed" class="instagram-carousel owl-carousel" data-userid="16644581087"
             data-accesstoken="16644581087.1d75619.d539c6ab72024730a90f6fb7c488c826">
        </div>
    </div>
</div>