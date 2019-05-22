<?php

namespace app\models\tables;

use Yii;
use app\models\tables\Users;
use yii\behaviors\TimestampBehavior;
use yii\imagine\Image;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $creator_id
 * @property int $responsible_id
 * @property string $deadline
 * @property int $status_id
 * @property string $img_fullpath
 * @property string $img_thumbpath
 *
 * @property Users $creator
 * @property Users $responsible
 */
class Tasks extends \yii\db\ActiveRecord
{

    public $imageFile;
    const ROOT_RELATIVE_IMG_PATH = "img/task/";

    public function behaviors() {
        parent::behaviors();

        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    self::EVENT_BEFORE_UPDATE => ['updated_at']
                ],
                'value' => date('Y-m-d H:i:s'),
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'creator_id'], 'required'],
            [['creator_id', 'responsible_id', 'status_id'], 'integer'],
            [['deadline'], 'safe'],
            [['name', 'description', 'img_fullpath'], 'string', 'max' => 255],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['creator_id' => 'id']],
            [['responsible_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['responsible_id' => 'id']],
            [['imageFile'], 'file', 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'task_id'),
            'name' => Yii::t('app', 'task_name'),
            'description' => Yii::t('app', 'task_description'),
            'creator_id' => Yii::t('app', 'task_creator_id'),
            'responsible_id' => Yii::t('app', 'task_responsible_id'),
            'deadline' => Yii::t('app', 'task_deadline'),
            'status_id' => Yii::t('app', 'task_status_id'),
            'img_fullpath' => Yii::t('app', 'task_img_fullpath'),
            'img_thumbpath' => Yii::t('app', 'task_imt_thumbpath')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(Users::className(), ['id' => 'creator_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsible()
    {
        return $this->hasOne(Users::className(), ['id' => 'responsible_id']);
    }

    public function getRootRelativePath()
    {
        return "img/task/";
    }

    public function getFullPath()
    {
        $filename = $this->imageFile->name;
        return Yii::getAlias("@webroot/{$this->getRootRelativePath()}{$filename}");
    }

    public function getThumbPath()
    {
        $filename = $this->imageFile->name;
        return Yii::getAlias("@webroot/{$this->getRootRelativePath()}thumbs/{$filename}");
    }


    public function upload()
    {
        $this->imageFile->saveAs($this->getFullPath());
        return Image::thumbnail($this->getFullPath(), 200, 200)
                ->save($this->getThumbPath());
    }
}
