<?php

namespace app\models\tables;

use Yii;

/**
 * This is the model class for table "statuses".
 *
 * @property int $id
 * @property string $title
 * @property string $suffix
 */
class Statuses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'statuses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'suffix'], 'required'],
            [['title', 'suffix'], 'string', 'max' => 15],
            [['title'], 'unique'],
            [['suffix'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'suffix' => 'Suffix',
        ];
    }
}
