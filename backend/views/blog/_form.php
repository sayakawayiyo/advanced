<?php

use backend\models\Category;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Blog */
/* @var $form yii\widgets\ActiveForm */
?>

<!--<div class="blog-form">

    <?php /*$form = ActiveForm::begin(); */?>

    <?/*= $form->field($model, 'id')->textInput() */?>

    <?/*= $form->field($model, 'title')->textInput(['maxlength' => true]) */?>

    <?/*= $form->field($model, 'content')->textarea(['rows' => 6]) */?>

    <?/*= $form->field($model, 'views')->textInput() */?>

    <?/*= $form->field($model, 'is_delete')->textInput() */?>

    <?/*= $form->field($model, 'created_at')->textInput() */?>

    <?/*= $form->field($model, 'updated_at')->textInput() */?>

    <div class="form-group">
        <?/*= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) */?>
    </div>

    <?php /*ActiveForm::end(); */?>

</div>-->

<?php $form =  ActiveForm::begin();
echo $form->field($model, 'title')->textInput(['maxlength' => true]);
echo $form->field($model, 'content')->textarea(['maxlength' => true, 'rows' => 10]);
echo $form->field($model, 'is_delete')->dropDownList(\backend\models\Blog::dropDownList('is_delete'));
echo $form->field($model, 'category')->label('栏目')->checkboxList(Category::dropDownList());
echo $form->field($model, 'file')->widget('manks\FileInput', [
    'clientOptions' => [
        'pick' => [
            'multiple' => false
        ],
    ]
]);
echo $form->field($model, 'file2')->widget('manks\FileInput', [
    'clientOptions' => [
        'pick' => [
            'multiple' => true
        ],
//        'server' => Url::to('blog/upload'),
//        'accept' => [
//            'extensions' => 'png'
//        ]
    ]
]);
?>

<div class="form_group">
    <?php echo Html::submitButton($model->isNewRecord ? '添加' : '更新',
        ['class' => $model->isNewRecord ? 'tbn btn-success' : 'btn btn-primary'])?>
</div>
<?php ActiveForm::end() ?>

