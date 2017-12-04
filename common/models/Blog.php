<?php

namespace common\models;



/**
 * This is the model class for table "blog".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $create_time
 */
class Blog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['create_time'], 'safe'],
            [['title'], 'string', 'max' => 100],
            ['title', 'required', 'message' => '请填写标题']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'create_time' => 'Create Time',
        ];
    }
}
