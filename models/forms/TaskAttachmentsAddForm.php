<?php
namespace app\models\forms;

use Yii;
use yii\web\UploadedFile;

class TaskAttachmentsAddForm extends \yii\base\Model
{
    public $taskId;
    /** @var yii\web\UploadedFile */
    public $attachment;

    private $filename;
    private $filepath;

    private $originalDir = '@app/web/img/task/';
    private $copiesDir = '@app/web/img/task/thumbs/';

    public function rules()
    {
        return[
            [['taskId', 'attachment'], 'required'],
            [['taskId'], 'integer'],
            [['attachment'], 'file', 'extensions' => ['jpg', 'png']]
        ];
    }
    
    public function save()
    {
        if($this->validate()){
            $this->saveUploadedFile();
            $this->createMinCopy();
            return $this->saveData();
        }
        return false;
    }

    public function saveUploadedFile()
    {
        $randomString = Yii::$app->security->generateRandomString();
        $this->filename = $randomString.'.'. $this->attachment->getExtension();
        $this->filepath = Yii::getAlias("{$this->originalDir}/{$this->filename}");
        $this->attachment->saveAs($this->filepath);
    }

    public function createMinCopy()
    {
        \yii\imagine\Image::thumbnail($this->filepath, 100, 100)
            ->save(Yii::getAlias("{$this->copiesDir}/{$this->filename}"));
    }

    public function saveData()
    {
        $model = new \app\models\tables\Attachments([
            'task_id' => $this->taskId,
            'path' => $this->filename
        ]);

        return $model->save();
    }
}