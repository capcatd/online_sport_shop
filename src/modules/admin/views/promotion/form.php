<?php

use app\components\models\Status;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Promotion */
/* @var $types array */
/* @var $items array */
/* @var $current array */

$this->title = 'Создание акции';
$this->params['breadcrumbs'][] = [ 'label' => 'Акции', 'url' => [ 'index' ] ];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        <?php echo Yii::$app->session->getFlash('success'); ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-error alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        <?php echo Yii::$app->session->getFlash('error'); ?>
    </div>
<?php endif; ?>

<?php $form = ActiveForm::begin([
    'id' => 'promotion-create',
]) ?>
<div class="box box-shadowed box-outline-success <?= !empty(Yii::$app->params['background']) ? Yii::$app->params['background'] : '' ?>">
    <div class="box-header with-border">
        <div class="right-float">
            <?= Html::submitButton(Html::tag('i', '&nbsp;', [ 'class' => 'fas fa-save' ]) . ' Сохранить',
                [ 'class' => 'btn btn-sm btn-success' ]) ?>
        </div>
    </div>
    <div class="box-body form-element">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#main" role="tab"><span
                            class="hidden-sm-up"><i class="ion-home"></i></span> <span
                            class="hidden-xs-down">Основные</span></a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#category" role="tab"><span
                            class="hidden-sm-up"><i class="ion-person"></i></span> <span
                            class="hidden-xs-down">Категории</span></a>
            </li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#item" role="tab"><span
                            class="hidden-sm-up"><i class="ion-email"></i></span> <span
                            class="hidden-xs-down">Товары</span></a>
            </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content tabcontent-border">
            <div class="tab-pane active" id="main" role="tabpanel">
                <div class="pad">
                    <div class="row">
                        <div class="col-lg-2 col-4">
                            <?= $form->field($model, 'type')->widget(\kartik\select2\Select2::className(), [
                                'data' => $types,
                                'options' => [
                                    'placeholder' => 'Выберите тип ...',
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                ],
                            ]) ?>
                        </div>
                        <div class="col-lg-2 col-3">
                            <?= $form->field($model, 'sale') ?>
                        </div>
                        <div class="col-lg-2 col-4">
                            <?= $form->field($model, 'status')
                                     ->widget(\kartik\switchinput\SwitchInput::className(), [
                                         'type' => \kartik\switchinput\SwitchInput::CHECKBOX,
                                         'pluginOptions' => [
                                             'onColor' => 'primary',
                                             'onText' => Status::getStatusesArray()[Status::STATUS_ACTIVE],
                                             'offText' => Status::getStatusesArray()[Status::STATUS_DISABLE],
                                         ],
                                     ]) ?>
                        </div>
                        <div class="col-lg-3 col-6">
                            <?= $form->field($model, 'publish_from')
                                     ->widget(
                                         DateTimePicker::classname(), [
                                                                        'removeButton' => false,
                                                                        'readonly' => true,
                                                                        'options' => [
                                                                            'value' => $model->publish_from ? date("d.m.Y H:i",
                                                                                                                   $model->publish_from) : date("d.m.Y H:i",
                                                                                                                                                time()),
                                                                            'placeholder' => 'Дата начала',
                                                                        ],
                                                                        'pluginOptions' => [
                                                                            'autoclose' => true,
                                                                            'todayBtn' => true,
                                                                            'format' => 'dd.mm.yyyy h:i',
                                                                            //                                                    'weekStart' => 1,
                                                                            //'startDate' => $startDate,//дата начала
                                                                        ],
                                                                    ]
                                     ); ?>

                        </div>
                        <div class="col-lg-3 col-6">
                            <?= $form->field($model, 'publish_to')
                                     ->widget(
                                         DateTimePicker::classname(), [
                                                                        'removeButton' => false,
                                                                        'readonly' => true,
                                                                        'options' => [
                                                                            'value' => $model->publish_to ? date("d.m.Y H:i",
                                                                                                                 $model->publish_to) : date("d.m.Y H:i",
                                                                                                                                            time()),
                                                                            'placeholder' => 'Дата окончания',
                                                                        ],
                                                                        'pluginOptions' => [
                                                                            'autoclose' => true,
                                                                            'todayBtn' => true,
                                                                            'format' => 'dd.mm.yyyy h:i',
                                                                            //                                                    'weekStart' => 1,
                                                                            //'startDate' => $startDate,//дата начала
                                                                        ],
                                                                    ]
                                     ); ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="category" role="tabpanel">
                <div class="pad">
                    <div class="row">
                        <div class="col">
                        
                            <?php
                        
                            echo \kartik\tree\TreeViewInput::widget([
                                                                        'name' => 'Category',
                                                                        'value' => 'true', // preselected values
                                                                        'query' => \app\models\Category::find()
                                                                                                       ->addOrderBy('root, lft'),
                                                                        'headingOptions' => [ 'label' => 'Категории' ],
                                                                        'rootOptions' => [ 'label' => '<i class="fas fa-tree text-success"></i>' ],
                                                                        'fontAwesome' => false,
                                                                        'asDropdown' => false,
                                                                        'multiple' => true,
                                                                        'options' => [ 'disabled' => false ],
                                                                    ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="item" role="tabpanel">
                <div class="pad">
                    <div class="row">
                        <div class="col-12">
                            <?= Select2::widget([
                                'name' => 'PromotionItem',
                                'data' => $items,
                                'value' => !empty($current) ? $current : [],
                                                    'options' => [
                                                        'multiple' => true,
                                                        'placeholder' => 'Выберите нужные размеры',
                                                    ],
                                'pluginOptions' => [
                                                        'allowClear' => true,
                                                    ],
                                                ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?php ActiveForm::end() ?>




