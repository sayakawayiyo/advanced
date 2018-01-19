<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "blog".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $views
 * @property integer $is_delete
 * @property string $created_at
 * @property string $updated_at
 * @property string $file
 * @property string $file2
 */
class Blog extends \yii\db\ActiveRecord
{
    public $category;

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'onBeforeInsert']);
        $this->on(self::EVENT_AFTER_INSERT, [$this, 'onAfterInsert']);
        $this->on(self::EVENT_BEFORE_UPDATE, [$this, 'onBeforeUpdate']);
    }


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
//            [['id', 'content', 'created_at', 'updated_at', 'category'], 'required'],
            [['title', 'content', 'category'], 'required'],
            [['id', 'views', 'is_delete'], 'integer'],
            [['content'], 'string'],
//            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['file', 'file2'], 'safe'],
            [['file'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'content' => '内容',
            'views' => '点击量',
            'is_delete' => '是否删除 1未删除 2已删除',
            'created_at' => '添加时间',
            'updated_at' => '更新时间',
        ];
    }
    
    public static function dropDownList($field)
    {
        $query = static::find();
        $enums = $query->all();
        return $enums ? ArrayHelper::map($enums, 'id', $field) : [];
    }

    public function onBeforeInsert()
    {
        is_array($this->file2) && $this->file2 && $this->file2 = implode(',', $this->file2);
        yii::info('This is beforeInsert event.');
    }

    public function onAfterInsert()
    {
        yii::info('This is afterInsert event.');
    }

    public function onBeforeUpdate()
    {
        is_array($this->file2) && $this->file2 && $this->file2 = implode(',', $this->file2);
    }
}
