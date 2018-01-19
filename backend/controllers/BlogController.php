<?php

namespace backend\controllers;

use backend\components\MyBehavior;
use backend\models\BlogCategory;
use Yii;
use backend\models\Blog;
use backend\models\BlogSearch;
use yii\db\Exception;
use yii\db\Query;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BlogController implements the CRUD actions for Blog model.
 */
class BlogController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            //附加行为
//            'myBehavior' => MyBehavior::className(),
            'as access' => [
                'class' => 'backend\components\AccessControl'
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Blog models.
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionIndex()
    {
//        if (!Yii::$app->user->can('/blog/index')) {
//            throw new ForbiddenHttpException('没权限访问');
//        }

        //操作行为类
//        $myBehavior = $this->getBehavior('myBehavior');
//        $isGuest = $myBehavior->isGuest();

//        $isGuest = $this->isGuest();

        $searchModel = new BlogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Blog model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Blog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \Exception
     */
    public function actionCreate()
    {
//        $model = new Blog();
//        $model->load(Yii::$app->request->post());
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }


        $model = new Blog();
        // 注意这里调用的是validate，非save,save我们放在了事务中处理了
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                // ($file = Upload::up($model, 'file')) && $model->file = $file;
                /**
                 * current model save
                 */
                $model->save(false);
                // 注意我们这里是获取刚刚插入blog表的id
                $blogId = $model->id;
                /**
                 * batch insert category
                 * 我们在Blog模型中设置过category字段的验证方式是required,因此下面foreach使用之前无需再做判断
                 */
                $data = [];
                foreach ($model->category as $k => $v) {
                    // 注意这里的属组形式[blog_id, category_id]，一定要跟下面batchInsert方法的第二个参数保持一致
                    $data[] = [$blogId, $v];
                }
                // 获取BlogCategory模型的所有属性和表名
                $blogCategory = new BlogCategory;
                $attributes = ['blog_id', 'category_id'];
                $tableName = $blogCategory::tableName();
                $db = BlogCategory::getDb();
                // 批量插入栏目到BlogCategory::tableName表
                $db->createCommand()->batchInsert(
                    $tableName,
                    $attributes,
                    $data
                )->execute();
                //提交
                $transaction->commit();
                return $this->redirect(['index']);
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Blog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws Exception
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                /**
                 *current model save
                 */
                $model->save(false);
                $blogId = $model->id;
                /**
                 * batch insert category
                 * 我们在Blog模型中设置过category字段的验证方式是required,因此下面foreach使用之前无需再做判断
                 */
                $data = [];
                foreach ($model->category as $kv => $v) {
                    $data[] = [$blogId, $v];
                }
                //获取BlogCategory模型的所有属性和表名
                $blogCategory = new BlogCategory();
                $attributes = ['blog_id', 'category_id'];
                $tableName = $blogCategory::tableName();
                $db = BlogCategory::getDb();
                // 先全部删除对应的栏目
                $sql = "DELETE FROM `{$tableName}` WHERE `blog_id` = :bid";
                $db->createCommand($sql, ['bid' => $id])->execute();

                // 再批量插入栏目到BlogCategory::tableName()表
                $db->createCommand()->batchInsert(
                    $tableName,
                    $attributes,
                    $data
                )->execute();
                //提交
                $transaction->commit();
                return $this->redirect(['index']);
            } catch (Exception $e) {
                //回滚
                $transaction->rollBack();
                throw $e;
            }
        } else {
            // 获取博客关联的栏目
            $model->category = BlogCategory::getRelationCategorys($id);
            return $this->render('update', [
                'model' => $model
            ]);
        }
//        $model->category = BlogCategory::getRelateCategorys($id);
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
    }

    /**
     * Deletes an existing Blog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Blog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Blog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Blog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function beforeAction($action)
    {
        parent::beforeAction($action);
        $currentRequestRoute = $action->getUniqueId();
        if (!Yii::$app->user->can('/' . $currentRequestRoute)) {
            throw new ForbiddenHttpException('没有权限访问.');
        }
        return true;
    }

    public function actionTest()
    {
//        $sql = "SELECT * FROM `blog` WHERE id = :id";
//        $result = Yii::$app->db->createCommand($sql)
//            ->bindValues([':id' => 1])
////            ->bindValue(':id', 4)
////            ->queryAll();
//        ->getRawSql();
        $query = new Query;
//        $result = $query->select(['username', 'email'])
//            ->from('user')
//            ->where(['username' => 'test1'])
//            ->limit(5)
//            ->all();
//        $sql = $query->createCommand()->getSql();
        $result = $query->select(['t.id', 't.title', 'b.category_id'])
            ->from(['t' => 'blog'])
            ->leftJoin(['b' => 'blog_category'], 't.id=b.blog_id')
            ->where(['t.id' => 1])
            ->all();
    }
}
