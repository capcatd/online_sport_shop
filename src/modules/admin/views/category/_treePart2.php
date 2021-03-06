<?php

/** @var object $node */

use app\models\Image;
use yii\helpers\Url;

?>

<?= $form->field($node, 'description') ?>

<?=
\kartik\file\FileInput::widget([
                                   'name' => 'UploadForm',
                                   'options' => [
                                       'accept' => 'image/*',
                                   ],
                                   'pluginOptions' => [
                                       'deleteUrl' => Url::toRoute([ '/admin/image/delete-image' ]),
                                       'uploadUrl' => Url::to([ '/admin/image/upload' ]),
                                       'uploadExtraData' => [
                                           'type' => Image::TYPE_CATEGORY,
                                           'id' => $node->id,
                                       ],
                                       'maxCount' => 1,
                                       'minCount' => 0,
                                       'overwriteInitial' => false,
                                       'initialPreview' => Image::getUrlsBySubject(Image::TYPE_CATEGORY, $node->id,
                                                                                   Image::SIZE_MEDIUM),
                                       'initialPreviewAsData' => true,
                                       'initialPreviewConfig' => Image::getInitialPreviewConfigBySubject(Image::TYPE_CATEGORY,
                                                                                                         $node->id),
                                   ],
                                   'pluginEvents' => [
                                       'filesorted' => new \yii\web\JsExpression('function(event, params){
                    $.post("' . Url::toRoute([ "/admin/image/sort-image", "id" => $node->id ]) . '", {sort: params});
                    }'),
                                   ],


                               ])
?>
