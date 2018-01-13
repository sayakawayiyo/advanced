<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['id' => 'category'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'header' => '操作',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('栏目信息', $url, [
                            'title' => '栏目信息',
                            'class' => 'btn btn-default btn-update',
                            'data-toggle' => 'modal',
                            'data-target' => '#operate-modal',
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('删除', $url, [
                            'title' => '删除',
                            'class' => 'btn btn-default',
                            'data' => [
                                'confirm' => '确定要删除吗?',
                                'method' => 'post'
                            ]
                        ]);
                    },
                ]
            ],
        ],
    ]); ?>
</div>
<?php
Modal::begin([
    'id' => 'operate-modal',
    'header' => '<h4 class="modal-title"></h4>',
]);
Modal::end();

echo Html::a('创建栏目', ['create'], [
    'class' => 'btn btn-success',
    'id' => 'create',
    'data-toggle' => 'modal',
    'data-target' => '#operate-modal',
]);

//创建
$requestCreateUrl = Url::toRoute('create');
$js = <<<JS
    $('#create').on('click',function(){
        $('.modal-title').html('创建栏目');
        $.get('{$requestCreateUrl}',
            function(data) {
              $('.modal-body').html(data);
            }
        )
    });
JS;
$this->registerJs($js);

//更新
$requestUpdateUrl = Url::toRoute('update');
$js = <<<js
    $('.btn-update').on('click', function() {
      $('modal-title').html('栏目信息');
      $.get('{$requestUpdateUrl}', {id:$(this).closest('tr').data('key')}, function(data) {
        $('.modal-body').html(data);
      });
    });
js;
$this->registerJs($js);
?>



