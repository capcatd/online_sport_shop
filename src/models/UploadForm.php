<?php

namespace app\models;

use app\modules\admin\models\Import;
use Yii;
use yii\base\Model;
use yii\db\Exception;
use yii\helpers\FileHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class UploadForm
    extends Model
{
    
    public $images;
    
    public $image;
    
    public $excel;
    
    private $_type;
    
    private $_subject_id;
    
    public function __construct($type = null, $subject_id = null)
    {
        $this->setType($type);
        $this->setSubject($subject_id);
        
        //        return $this;
    }
    
    public function rules()
    {
        return [
            [ [ 'images' ], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, webp', 'maxFiles' => 8 ],
            [ [ 'image' ], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, webp' ],
            [ [ 'excel' ], 'file', 'skipOnEmpty' => true, ],
        ];
    }
    
    public function setType($type)
    {
        if ($this->_type === null or array_key_exists($type, Image::getTypes())) {
            $this->_type = $type;
        }
    }
    
    public function setSubject($subject)
    {
        if ($this->_subject_id === null) {
            $this->_subject_id = (int) $subject;
        }
    }
    
    /**
     * Сохраняет файл на сервере и добавляет его в базу для дальнейшего доступа
     */
    public function uploadImages()
    {
        // validation input data
        if (!empty($this->_type) and !empty($this->_subject_id)) {
            if (is_array($this->images) and !empty($this->images)) {
                foreach ($this->images as $this->image) {
                    try {
                        $this->uploadImage();
                    } catch (\Exception $e) {
                        Yii::$app->errorHandler->logException($e);
                    }
                }
            }
        } else {
            throw new Exception('Не удалось сохранить картинки');
        }
    }
    
    public function uploadImage()
    {
        
        if ($this->validate()) {
            if (!empty($this->image)) {
                
                $mdl = new Image();
                // generate filename
                $mdl->url = Yii::$app->security->generateRandomString(16) . '_' . time() . '.' . $this->image->extension;
                $mdl->type = $this->_type;
                $mdl->subject_id = $this->_subject_id;
                
                if ($mdl->save() and $this->image instanceof UploadedFile) {
                    // save file and model
                    
                    switch ($mdl->type) {
                        case Image::TYPE_ITEM:
                            foreach (Image::getSizes() as $size => $folder) {
                                // create path to save image
                                $path = Yii::getAlias('@webroot') . $mdl->getPath($size);
                                
                                // check if path exists
                                if (!file_exists($path)) {
                                    // if not -> create
                                    FileHelper::createDirectory($path, 0777);
                                }
                                if (!$this->image->saveAs($path . $mdl->url, false)) {
                                    throw new NotFoundHttpException('Изображения не были сохранены');
                                }
                                
                                if ($size == Image::SIZE_ORIGINAL) {
                                    Image::resize($path . $mdl->url, 1024, 1024, true);
                                } elseif ($size == Image::SIZE_MEDIUM) {
                                    Image::resize($path . $mdl->url, 512, 512, true);
                                } elseif ($size == Image::SIZE_THUMBNAIL) {
                                    Image::resize($path . $mdl->url, 192, 192);
                                }
                            }
                            break;
                        case Image::TYPE_CATEGORY:
                            $path = Yii::getAlias('@webroot') . $mdl->getPath(Image::SIZE_MEDIUM);
                            
                            // check if path exists
                            if (!file_exists($path)) {
                                // if not -> create
                                FileHelper::createDirectory($path, 0777);
                            }
                            
                            if (!$this->image->saveAs($path . $mdl->url, false)) {
                                throw new NotFoundHttpException('Изображения не были сохранены');
                            }
                            
                            Image::resize($path . $mdl->url, 512, 512);
                            
                            break;
                        case Image::TYPE_BANNER:
                            $path = Yii::getAlias('@webroot') . $mdl->getPath(Image::SIZE_ORIGINAL);
                            
                            // check if path exists
                            if (!file_exists($path)) {
                                // if not -> create
                                FileHelper::createDirectory($path, 0777);
                            }
                            
                            if (!$this->image->saveAs($path . $mdl->url, false)) {
                                throw new NotFoundHttpException('Изображение не были сохранены');
                            }
                            
                            break;
                        default:
                            break;
                    }
                }
                
                unset($mdl);
            }
        } elseif (!empty($this->image)) {
            throw new Exception("Картинка \"{$this->image->baseName}.{$this->image->extension}\" не прошла валидацию");
        }
    }
    
    public function uploadExcel($time = null)
    {
        // validation doesn't work, because i made check extension with in_array()
        if ($this->validate() and !empty($this->excel) and $this->excel instanceof UploadedFile and in_array($this->excel->extension,
                                                                                                             [
                                                                                                                 'xls',
                                                                                                                 'xlsx',
                                                                                                             ])) {
            if (empty($time)) {
                $time = time();
            }
            
            $path = Yii::getAlias('@webroot') . '/files/stock/';
            
            if (!file_exists($path)) {
                FileHelper::createDirectory($path, 0777);
            }
            
            
            $filename = 'stock-' . $time . '.' . $this->excel->extension;
            
            if (!$this->excel->saveAs($path . $filename, false)) {
                return false;
            }
            
            // found time when created previous file
            $lastTime = Import::find()
                              ->where([
                                                     'type' => Import::TYPE_UPLOAD_EXCEL,
                                                 ])
                              ->filterWhere([
                                                           'like', 'result', 's:4:"code";i:' . Import::RESULT_CODE_OK,
                                                       ])
                              ->orderBy([
                                                       'created_at' => SORT_DESC,
                                                   ])
                              ->one();
    
            if (!empty($lastTime) and $lastTime instanceof Import) {
        
                $filename = 'stock-' . $lastTime->created_at . '.';
        
                if (file_exists($path . $filename . 'xls')) {
                    unlink($path . $filename . 'xls');
                }
        
                if (file_exists($path . $filename . 'xlsx')) {
                    unlink($path . $filename . 'xlsx');
                }
        
                unset($lastTime);
            }
            unset($filename);
            unset($time);
            
            return true;
            
        } else {
            return null;
        }
        
    }
}