<?php

use app\components\helpers\ValueHelper;
use app\models\Image;
use app\models\ItemColorSize;
use yii\helpers\Url;

/** @var array $result */
?>

<button class="icon-cart-active">
                                    <span class="icon-cart">
                                        <i class="sli sli-bag"></i>
                                        <span class="count-style"><?= $result['totalCount'] ?></span>
</span>
    <span class="cart-price">
                                        <?= $result['totalCost'] ?>
                                    </span>
</button>
<div class="shopping-cart-content">
    <div class="shopping-cart-top">
        <h4>Корзина</h4>
        <a class="cart-close"><i class="sli sli-close"></i></a>
    </div>
    <ul class="cart-items">
        <?php foreach ($result['items'] as $item): ?>
            <li data-cart-id="<?= ValueHelper::encryptValue($item['size']['id']) ?>"
                class="single-shopping-cart">
                <div class="shopping-cart-img">
                    <a href="<?= Url::to([ '/main/products/product', 'slug' => ValueHelper::encryptValue($item['item']['id']) ]) ?>"><img
                                alt="<?= $item['image']['url'] ?>"
                                src="<?= Image::getLink($item['image']['id'],
                                                        Image::SIZE_THUMBNAIL) ?>"></a>
                    <div class="item-close">
                        <a href="#"><i class="sli sli-close"></i></a>
                    </div>
                </div>
                <div class="shopping-cart-title">
                    <h4>
                        <a href="<?= Url::to([ '/main/products/product', 'slug' => ValueHelper::encryptValue($item['item']['id']) ]) ?>"> <?= $item['item']['firm'] . ' ' . $item['item']['model'] . ' ' . ( $item['size']['size'] != ItemColorSize::WITHOUT_SIZE ? $item['size']['size'] : '' ) ?></a>
                    </h4>
                    <span><?= $item['quantity'] . ' x ' . $item['price'] ?></span>
                    <?php if (!empty($item['promotion']) and $item['price'] != $item['priceWithoutPromotion']): ?>
                        <span class="promo-price"> <?= $item['priceWithoutPromotion'] ?></span>
                    <?php endif; ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="shopping-cart-bottom">
        <div class="shopping-cart-total">
            <h4>Всего :
                <?php if ($result['totalCost'] != $result['totalCostWithoutPromotion']): ?>
                    <span class="shop-total promo-price"
                          style="color: #000000;"><?= $result['totalCostWithoutPromotion'] ?></span>
                <?php endif; ?>
                <span class="shop-total"><?= $result['totalCost'] ?></span>
            </h4>
        </div>
        <div class="shopping-cart-btn btn-hover text-center">
            <a class="default-btn" href="<?= Url::to([ '/main/checkout/index' ]) ?>">Оформить заказ</a>
            <a class="default-btn"
               href="<?= Url::to([ '/main/cart/index' ]) ?>">Корзина</a>
        </div>
    </div>
</div>