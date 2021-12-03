<?php

namespace app\controllers;

use Yii;
use app\models\LoopLearn;
use app\models\LoopNote;
use app\models\LoopCategory;
use app\models\LearnSearch;
use app\models\UploadForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

use yii\db\ActiveQuery;

use yii\web\UploadedFile;

/**
 * LearnController implements the CRUD actions for LoopLearn model.
 */
class LearnController extends Controller
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all LoopLearn models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LearnSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LoopLearn model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new LoopLearn model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LoopLearn();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing LoopLearn model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing LoopLearn model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->xmlFile = UploadedFile::getInstance($model, 'xmlFile');
            if ($model->upload()) {
                $file_path = 'uploads/' . $model->xmlFile->baseName . '.' . $model->xmlFile->extension;
                $xml = simplexml_load_file($file_path, "SimpleXMLElement", LIBXML_NOCDATA);
                $json = json_encode($xml);
                $array_xml = json_decode($json, TRUE);

                foreach ($array_xml['link'] as $value) {
                    $category = LoopCategory::find()->where(['title' => $value['category']])->one();
                    $isLearn = LoopLearn::find()->where(['link' => $value['link']])->one();
                    if (empty($isLearn)) {
                        $learn = new LoopLearn();
                        $learn->title = $value['title'];
                        $learn->category_id = $category->id;
                        $learn->link = $value['link'];
                        $learn->save();
                    }
                }

                return $this->redirect(['index',]);;
            }
        }
        return $this->render('upload', ['model' => $model]);
    }
    /**
     * Обработчик Post запроса из списка.
     */
    public function actionLearn()
    {
        $action = Yii::$app->request->post('action');
        $selection = (array)Yii::$app->request->post('selection'); //typecasting

        foreach ($selection as $id) {
            $model = LoopLearn::findOne((int)$id); //make a typecasting
            $category = LoopCategory::findOne((int)$model->category_id);
            if ($category != null) {
                $category->count = $category->count + 1;
                $category->last_update = new Expression('NOW()');
                $category->save(false);
            }
            $model->count = $model->count + 1;
            $model->last_update = new Expression('NOW()');
            $model->save(false);
        }

        return $this->redirect(['learn/index']);
    }

    /**
     * Обработчик Post запроса из одиночной View.
     */
    public function actionLearnRandomRepeat()
    {
        $id = Yii::$app->request->post('learn'); //typecasting
        $model = LoopLearn::findOne((int)$id); //make a typecasting
        $category = LoopCategory::findOne((int)$model->category_id);

        if ($category != null) {
            $category->count = $category->count + 1;
            $category->last_update = new Expression('NOW()');
            $category->save(false);
        }

        $model->count = $model->count + 1;
        $model->last_update = new Expression('NOW()');
        $model->save(false);

        return $this->redirect(['learn/random-repeat-category']);
    }

    public function actionRandomRepeatCategory()
    {
        $category = LoopCategory::find()->orderBy('parent_id ASC, id ASC')->where(['<>', 'status', '0'])->asArray()->all();
        return $this->render('random-repeat-category', [
            'category' => $category,
        ]);
    }

    public function actionListNoteCategory()
    {
        $category = LoopCategory::find()->orderBy('parent_id ASC, id ASC')->where(['<>', 'status', '0'])->asArray()->all();
        return $this->render('list-note-category', [
            'category' => $category,
        ]);
    }

    public function actionListNoteOld()
    {
        $time_from = strtotime('-20 day', time());
        $delta_from = date('Y-m-d H:i:s', $time_from);

        $query = LoopNote::find()->orderBy(['rand()' => SORT_DESC, new \yii\db\Expression('last_update IS NULL ASC')])
            ->where(['is', 'last_update', new \yii\db\Expression('null')])
            ->orWhere(['<=', 'last_update', $delta_from]);

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'last_update' => SORT_ASC,
                ]
            ],
        ]);

        return $this->render('list_old_note', [
            'dataProvider' => $provider,
        ]);
    }

    public function actionListNoteDetail($id_category)
    {
        $category = $this->findModelCategory($id_category);
        $learns = $category->getLearns($category->id);

        $list_id_notes = [];

        foreach ($learns->all() as $learn) {
            if ($learn != null) {
                $isCount = $learn->getNotesCount($learn->id);
                if ($isCount != 0) {
                    $list_note = $learn->getNotes($learn->id);
                    foreach ($list_note->all() as $value) {
                        $list_id_notes[] = $value->id;
                    }
                }
            }
        }

        $query = LoopNote::find()->where(['in', 'id', $list_id_notes]);
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'last_update' => SORT_ASC,
                ]
            ],
        ]);

        return $this->render('list_note', [
            'model' => $learn,
            'dataProvider' => $provider,
            'category' => $category,
        ]);
    }

    public function actionListNoteOne($id_category)
    {
        $category = $this->findModelCategory($id_category);
        $learns = $category->getLearns($category->id);

        $list_id_notes = [];

        foreach ($learns->all() as $learn) {
            if ($learn != null) {
                $isCount = $learn->getNotesCount($learn->id);
                if ($isCount != 0) {
                    $list_note = $learn->getNotes($learn->id);
                    $list_id_notes[] = $list_note->orderBy('last_update ASC')->one();
                }
            }
        }

        $query = LoopNote::find()->where(['in', 'id', $list_id_notes]);
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'last_update' => SORT_ASC,
                ]
            ],
        ]);

        return $this->render('list_note_one', [
            'model' => $learn,
            'dataProvider' => $provider,
            'category' => $category,
        ]);
    }

    public function actionListThemeOne($id_category)
    {
        $category = $this->findModelCategory($id_category);
        $learns = $category->getLearns($category->id);

        $list_id_notes = [];

        foreach ($learns->orderBy('last_update ASC')->all() as $learn) {
            if ($learn != null) {
                $isCount = $learn->getNotesCount($learn->id);
                if ($isCount != 0) {
                    $list_note = $learn->getNotes($learn->id);
                    foreach ($list_note->orderBy('last_update ASC')->all() as $value) {
                        $list_id_notes[] = $value->id;
                    }
                    break;
                }
            }
        }

        $query = LoopNote::find()->where(['in', 'id', $list_id_notes]);
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'last_update' => SORT_ASC,
                ]
            ],
        ]);

        return $this->render('list_theme_one', [
            'model' => $learn,
            'dataProvider' => $provider,
            'category' => $category,
        ]);
    }

    public function actionRandomRepeat($id_category)
    {
        $time_from = strtotime('-10 day', time());
        $delta_from = date('Y-m-d H:i:s', $time_from);

        $category = $this->findModelCategory($id_category);
        $query = $category->getLearns($category->id);

        $model = $query->orderBy(['rand()' => SORT_DESC, new \yii\db\Expression('last_update IS NULL ASC')])
            ->where(['is', 'last_update', new \yii\db\Expression('null')])
            ->orWhere(['<=', 'last_update', $delta_from])->one();


        $queryNotes = $model->getNotes($model->id);
        $provider = new ActiveDataProvider([
            'query' => $queryNotes,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort' => [
                'defaultOrder' => [
                    'last_update' => SORT_ASC,
                ]
            ],
        ]);

        return $this->render('random-repeat', [
            'model' => $model,
            'dataProvider' => $provider,
        ]);
    }

    public function actionAddNote($id_learn)
    {
        $modelLearn = LoopLearn::findOne($id_learn);

        $model = new LoopNote();
        $model->link = $modelLearn->link;
        $model->learn_id = $modelLearn->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $modelLearn->count_note = $modelLearn->count_note + 1;

            return $this->redirect(['add-note', 'id_learn' => $modelLearn->id]);
        }

        return $this->render('add-note', [
            'model' => $model,
            'learn' => $modelLearn,
        ]);
    }

    public function actionListNote($id_learn)
    {
        $learn = LoopLearn::findOne($id_learn);
        $category = $this->findModelCategory($learn->category_id);
        $query = $learn->getNotes($learn->id);
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort' => [
                'defaultOrder' => [
                    'last_update' => SORT_ASC,
                ]
            ],
        ]);

        return $this->render('list_note', [
            'category' => $category,
            'model' => $learn,
            'dataProvider' => $provider,
        ]);
    }

    public function actionNoteDone()
    {
        $action = Yii::$app->request->post('action');
        $selection = (array)Yii::$app->request->post('selection'); //typecasting

        if ($action === 'Done') {
            foreach ($selection as $id) {
                $model = LoopNote::findOne((int)$id); //make a typecasting      
                $model->last_update = new Expression('NOW()');
                $model->count = $model->count + 1;
                $model->save(false);
                $modelLearn = LoopLearn::findOne((int)$model->learn_id);
                $modelLearn->last_update = new Expression('NOW()');
                $modelLearn->save(false);
            }
        }

        if ($action === 'Delete') {
            foreach ($selection as $id) {
                $model = LoopNote::findOne((int)$id);
                $model->delete();
            }
        }

        return $this->redirect(['list-note-category',]);
    }

    /**
     * Finds the LoopLearn model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LoopLearn the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LoopLearn::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelCategory($id_category)
    {
        if (($model = LoopCategory::findOne($id_category)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if (!Yii::$app->user->isGuest) {
            return true;
        } else {
            Yii::$app->getResponse()->redirect(Yii::$app->getHomeUrl());
            //для перестраховки вернем false
            return false;
        }
    }
}
