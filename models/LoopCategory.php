<?php

namespace app\models;

use Yii;


use app\traits\StatusTrait;


/**
 * This is the model class for table "loop_category".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $title
 * @property string $slug
 * @property int $status
 */
class LoopCategory extends \yii\db\ActiveRecord
{
    use StatusTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'loop_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'status', 'count'], 'integer'],
            [['title', 'slug',], 'required'],
            [['title'], 'string', 'max' => 255],
            [['slug'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'title' => 'Title',
            'slug' => 'Slug',
            'status' => 'Status',
        ];
    }

    static public function get($parentId = 0, $array = array(), $level = 0, $add = 2, $repeat = '　')
    {
        $strRepeat = '';
        // add some spaces or symbols for non top level categories
        if ($level > 1) {
            for ($j = 0; $j < $level; $j++) {
                $strRepeat .= $repeat;
            }
        }

        // i feel this is useless
        if ($level > 0) {
            $strRepeat .= '';
        }

        $newArray = array();
        $tempArray = array();

        //performance is not very good here
        foreach (( array )$array as $v) {
            if ($v['parent_id'] == $parentId) {
                $newArray [] = array(
                    'id' => $v['id'],
                    'title' => $v['title'],
                    'parent_id' => $v['parent_id'],
                );

                $tempArray = self::get($v['id'], $array, ($level + $add), $add, $repeat);
                if ($tempArray) {
                    $newArray = array_merge($newArray, $tempArray);
                }
            }
        }
        return $newArray;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearns()
    {
        return $this->hasMany(LoopLearn::className(), ['category_id' => 'id']);
    }

    public function getCountNote()
    {
        
    }
    
}
