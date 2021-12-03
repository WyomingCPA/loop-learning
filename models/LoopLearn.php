<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "loop_learn".
 *
 * @property int $id
 * @property int $category_id
 * @property string $title
 * @property string $link
 * @property int $count
 * @property string $last_update
 */
class LoopLearn extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'loop_learn';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'title'], 'required'],
            [['category_id', 'count', 'count_note'], 'integer'],
            [['last_update'], 'safe'],
            [['title', 'link'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'title' => 'Title',
            'link' => 'Link',
            'count' => 'Count',
            'count_note' => 'Count Note',
            'last_update' => 'Last Update',
        ];
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getNotes()
    {
        return $this->hasMany(LoopNote::className(), ['learn_id' => 'id']);
    }
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getNotesCount()
    {
        return $this->hasMany(LoopNote::className(), ['learn_id' => 'id'])->count();
    }
}
