<?php

namespace app\modules\admin\controllers;

use app\models\Image;
use app\models\UploadForm;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * ItemController implements the CRUD actions for Item model.
 */
class ImageController
    extends Controller
{
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => [ 'POST' ],
                ],
            ],
        ];
    }
    
    
    /**
     * Sort images in fileInput widget
     *
     * @param $id
     *
     * @return bool
     * @throws MethodNotAllowedHttpException
     */
    public function actionSortImage($id)
    {
        if (Yii::$app->request->isPost and Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post('sort');
            
            if ($post['oldIndex'] > $post['newIndex']) {
                $param = [ 'and', [ '>=', 'sort', $post['newIndex'] ], [ '<', 'sort', $post['oldIndex'] ] ];
                $counter = 1;
            } else {
                $param = [ 'and', [ '<=', 'sort', $post['newIndex'] ], [ '>', 'sort', $post['oldIndex'] ] ];
                $counter = -1;
            }
            
            // inc/dec values before newIndex and oldIndex
            Image::updateAllCounters([ 'sort' => $counter ], [
                'and', [ 'type' => Image::TYPE_ITEM, 'subject_id' => $id ], $param,
            ]);
            
            // set new index to the sorted image
            Image::updateAll([ 'sort' => $post['newIndex'] ], [
                'id' => $post['stack'][$post['newIndex']]['key'],
            ]);
            
            return true;
            
        } else {
            throw new MethodNotAllowedHttpException('Only POST method allowed');
        }
    }
    
    /**
     * Delete image locally and then remove from db
     *
     * @return bool
     * @throws MethodNotAllowedHttpException
     * @throws \Throwable
     */
    public function actionDeleteImage()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        if (Yii::$app->request->isPost
            and Yii::$app->request->isAjax
        ) {
            $id = Yii::$app->request->post('key');
            
            if (!empty($id)) {
                
                $transaction = Yii::$app->db->beginTransaction();
                
                try {
                    $model = Image::find()->where([ 'id' => $id ])->one();
    
                    foreach (Image::getSizes() as $size => $folder) {
        
                        $path = Yii::getAlias('@webroot') . Image::getLink($model->id, $size);
        
                        // delete file, if exists
                        if (file_exists($path)) {
                            unlink($path);
                        }
        
                    }
                    
                    $model->delete();
                    
                    Image::updateAllCounters([ 'sort' => -1 ], [
                        'and', [ 'type' => Image::TYPE_ITEM, 'subject_id' => $model->subject_id, ], [ '>', 'sort', $model->sort ],
                    ]);
                    
                    $transaction->commit();
                    
                    Yii::$app->db->close();
                    
                    return true;
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    
                    return false;
                }
            }
            
        } else {
            throw new MethodNotAllowedHttpException('Only POST method allowed');
        }
    }
    
    public function actionUpload()
    {
        if (Yii::$app->request->isPost and Yii::$app->request->isAjax) {
            
            Yii::$app->response->format = Response::FORMAT_JSON;
    
            try {
                $model = new UploadForm(Yii::$app->request->post('type'), Yii::$app->request->post('id'));
        
                $model->image = UploadedFile::getInstanceByName('UploadForm');
        
                $model->uploadImage();
                
                return true;
            } catch (\Exception $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('error', 'Ошибка при загрузке изображения');
            }
            
        }
        
        throw new MethodNotAllowedHttpException('Only POST method allowed');
    }
}
