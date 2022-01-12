<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

use app\models\LoopLearn;
use app\models\LoopCategory;

/**
 * LearnSearch represents the model behind the search form of `app\models\LoopLearn`.
 */
class LearnSearch extends LoopLearn
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'count'], 'integer'],
            [['title', 'link', 'last_update'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        //Поулчаем все акивные категорий
        $list_category = LoopCategory::find()->where(['status' => 1])->select(['id'])->asArray()->all();

        $list_id = [];
        foreach ($list_category as $item)
        {
            $list_id[] = $item['id'];
        }
        $query = LoopLearn::find()->where(['id'=>$list_id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'count' => $this->count,
            'last_update' => $this->last_update,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
                ->andFilterWhere(['like', 'link', $this->link]);

        return $dataProvider;
    }

    public function categoriesList(): array
    {
        return ArrayHelper::map(LoopCategory::find()->where(['status' => 1])->orderBy('title')->asArray()->all(), 'id', 'title');
    }

    public static function getCategoryName($id_category)
    {
        return LoopCategory::findOne(['id' => (int)$id_category, 'status' => 1]);
    }
}
