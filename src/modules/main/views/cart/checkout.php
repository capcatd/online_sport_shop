<?php


/** @var string $totalCost */

/** @var string $delivery */
/** @var array $items */
/** @var \app\modules\user\models\forms\LoginForm $loginForm */

$this->title = 'Оформление заказа';

$this->params['breadcrumbs'][] = $this->title;

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>


<div class="checkout-main-area pt-70 pb-70">
    <div class="container">
        <?php if (Yii::$app->user->isGuest and !empty($loginForm)): ?>
            <div class="customer-zone mb-20">
                <p class="cart-page-title">Постоянный клиент? <a class="checkout-click1" href="#">Нажмите, чтобы
                        войти</a>
                </p>
                <div class="checkout-login-info">
                    <p>
                        Если вы покупали у нас раньше, то пожалуйста войдите с помощью формы внизу. Если вы новый
                        покупатель, пожалуйста перейдите к форме "Оформления заказа"
                    </p>
                    <?php $form = ActiveForm::begin([
                                                        'id' => 'login-form',
                                                    ]) ?>
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="sin-checkout-login">
                                <?= $form->field($loginForm, 'email')->textInput([
                                                                                     'placeholder' => $loginForm->getAttributeLabel('email'),
                                                                                 ])->label(false) ?>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="sin-checkout-login">
                                <?= $form->field($loginForm, 'password')->passwordInput([
                                                                                            'placeholder' => $loginForm->getAttributeLabel('password'),
                                                                                        ])->label(false) ?>
                            </div>
                        </div>
                    </div>
                    <div class="button-remember-wrap">
                        <?= Html::submitButton('Войти') ?>
                        <div class="checkout-login-toggle-btn">
                            <?= $form->field($loginForm, 'rememberMe')
                                     ->checkbox()
                                     ->label('Запомнить меня') ?>
                        </div>
                    </div>
                    <div class="lost-password">
                        <?= Html::a('Забыли пароль?', [ '/user/default/forgot-password' ]) ?>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="checkout-wrap pt-30">
            <div class="row">
                <div class="col-lg-7">
                    <div class="billing-info-wrap mr-50">
                        <h3>Оформление</h3>
                        <!--                        Проверка на авторизацию пользователя-->
                        <?php if (Yii::$app->user->isGuest and !empty($signupForm)): ?>
                            <div class="row">
                                <?php $form = ActiveForm::begin([
                                                                    'id' => 'signup-form',
                                                                ]);
                                ?>
                                <?= $form->field($signupForm, 'email')
                                         ->label(false) ?>
                                <?= $form->field($signupForm, 'password')
                                         ->label(false) ?>
                                <?= $form->field($signupForm, 'phone')
                                         ->label(false) ?>
                                <div class="billing-info">
                                    <?= $form->field($signupForm, 'name')
                                             ->label(false) ?>
                                </div>
                                <?php ActiveForm::end() ?></div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="billing-info mb-20">
                                        <label>First Name <abbr class="required" title="required">*</abbr></label>
                                        <input type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="billing-info mb-20">
                                        <label>Last Name <abbr class="required" title="required">*</abbr></label>
                                        <input type="text">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="billing-info mb-20">
                                        <label>Company Name <abbr class="required" title="required">*</abbr></label>
                                        <input type="text">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="billing-select mb-20">
                                        <label>Country <abbr class="required" title="required">*</abbr></label>
                                        <select>
                                            <option>Select a country</option>
                                            <option>Azerbaijan</option>
                                            <option>Bahamas</option>
                                            <option>Bahrain</option>
                                            <option>Bangladesh</option>
                                            <option>Barbados</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="billing-info mb-20">
                                        <label>Street Address <abbr class="required" title="required">*</abbr></label>
                                        <input class="billing-address" placeholder="House number and street name"
                                               type="text">
                                        <input placeholder="Apartment, suite, unit etc." type="text">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="billing-info mb-20">
                                        <label>Town / City <abbr class="required" title="required">*</abbr></label>
                                        <input type="text">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="billing-info mb-20">
                                        <label>State / County <abbr class="required" title="required">*</abbr></label>
                                        <input type="text">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="billing-info mb-20">
                                        <label>Postcode / ZIP <abbr class="required" title="required">*</abbr></label>
                                        <input type="text">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="billing-info mb-20">
                                        <label>Phone <abbr class="required" title="required">*</abbr></label>
                                        <input type="text">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="billing-info mb-20">
                                        <label>Email Address <abbr class="required" title="required">*</abbr></label>
                                        <input type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="checkout-account mb-25">
                                <input class="checkout-toggle2" type="checkbox">
                                <span>Create an account?</span>
                            </div>
                            <div class="checkout-account-toggle open-toggle2 mb-30">
                                <label>Email Address</label>
                                <input placeholder="Password" type="password">
                            </div>
                            <div class="checkout-account mt-25">
                                <input class="checkout-toggle" type="checkbox">
                                <span>Ship to a different address?</span>
                            </div>
                            <div class="different-address open-toggle mt-30">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="billing-info mb-20">
                                            <label>First Name</label>
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="billing-info mb-20">
                                            <label>Last Name</label>
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="billing-info mb-20">
                                            <label>Company Name</label>
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="billing-select mb-20">
                                            <label>Country</label>
                                            <select>
                                                <option>Select a country</option>
                                                <option>Azerbaijan</option>
                                                <option>Bahamas</option>
                                                <option>Bahrain</option>
                                                <option>Bangladesh</option>
                                                <option>Barbados</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="billing-info mb-20">
                                            <label>Street Address</label>
                                            <input class="billing-address" placeholder="House number and street name"
                                                   type="text">
                                            <input placeholder="Apartment, suite, unit etc." type="text">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="billing-info mb-20">
                                            <label>Town / City</label>
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="billing-info mb-20">
                                            <label>State / County</label>
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="billing-info mb-20">
                                            <label>Postcode / ZIP</label>
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="billing-info mb-20">
                                            <label>Phone</label>
                                            <input type="text">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="billing-info mb-20">
                                            <label>Email Address</label>
                                            <input type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="additional-info-wrap">
                                <label>Order notes</label>
                                <textarea placeholder="Notes about your order, e.g. special notes for delivery. "
                                          name="message"></textarea>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="your-order-area">
                        <h3>Ваш заказ</h3>
                        <div class="your-order-wrap gray-bg-4">
                            <div class="your-order-info-wrap">
                                <div class="your-order-info">
                                    <ul>
                                        <li>Товар <span>Цена</span></li>
                                    </ul>
                                </div>
                                <div class="your-order-middle">
                                    <ul>
                                        <?php foreach ($items as $item): ?>
                                            <li><?= $item['name'] . ' X ' . $item['quantity'] ?>
                                                <span> <?= $item['cost'] ?> </span></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <div class="your-order-info order-subtotal">
                                    <ul>
                                        <li>Сумма <span><?= $totalCost ?> </span></li>
                                    </ul>
                                </div>
                                <div class="your-order-info order-shipping">
                                    <ul>
                                        <li>Доставка <p> <?= $delivery ?></p></li>
                                    </ul>
                                </div>
                                <div class="your-order-info order-total">
                                    <ul>
                                        <li>Итого <span><?= $totalCost ?> </span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="payment-method">
                                <div class="pay-top sin-payment">
                                    <input id="payment_method_1" class="input-radio" type="radio" value="cheque"
                                           checked="checked" name="payment_method">
                                    <label for="payment_method_1"> Direct Bank Transfer </label>
                                    <div class="payment-box payment_method_bacs">
                                        <p>Make your payment directly into our bank account. Please use your Order ID as
                                            the payment reference. Your order will not be shipped until the funds have
                                            cleared in our account.</p>
                                    </div>
                                </div>
                                <div class="pay-top sin-payment">
                                    <input id="payment-method-2" class="input-radio" type="radio" value="cheque"
                                           name="payment_method">
                                    <label for="payment-method-2">Check payments</label>
                                    <div class="payment-box payment_method_bacs">
                                        <p>Make your payment directly into our bank account. Please use your Order ID as
                                            the payment reference. Your order will not be shipped until the funds have
                                            cleared in our account.</p>
                                    </div>
                                </div>
                                <div class="pay-top sin-payment">
                                    <input id="payment-method-3" class="input-radio" type="radio" value="cheque"
                                           name="payment_method">
                                    <label for="payment-method-3">Cash on delivery </label>
                                    <div class="payment-box payment_method_bacs">
                                        <p>Make your payment directly into our bank account. Please use your Order ID as
                                            the payment reference. Your order will not be shipped until the funds have
                                            cleared in our account.</p>
                                    </div>
                                </div>
                                <div class="pay-top sin-payment sin-payment-3">
                                    <input id="payment-method-4" class="input-radio" type="radio" value="cheque"
                                           name="payment_method">
                                    <label for="payment-method-4">PayPal <img alt=""
                                                                              src="assets/img/icon-img/payment.png"><a
                                                href="#">What is PayPal?</a></label>
                                    <div class="payment-box payment_method_bacs">
                                        <p>Make your payment directly into our bank account. Please use your Order ID as
                                            the payment reference. Your order will not be shipped until the funds have
                                            cleared in our account.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="Place-order mt-40">
                            <a href="#">Place Order</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>