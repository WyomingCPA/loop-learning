<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "loop_note".
 *
 * @property int $id
 * @property int $learn_id
 * @property string $title
 * @property string $link
 * @property int $count
 * @property string $last_update
 */
class LoopNote extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'loop_note';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['learn_id', 'title'], 'required'],
            [['learn_id', 'count'], 'integer'],
            [['last_update'], 'safe'],
            [['link'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'learn_id' => 'Learn ID',
            'title' => 'Note',
            'link' => 'Link',
            'count' => 'Count',
            'last_update' => 'Last Update',
        ];
    }

    public function getLearn()
    {
        return $this->hasMany(LoopLearn::className(), ['id' => 'learn_id'])->one();
    }
}
