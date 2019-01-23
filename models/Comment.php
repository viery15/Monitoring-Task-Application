<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task_monitoring.comment".
 *
 * @property int $id
 * @property string $user_comment
 * @property string $task_id
 * @property string $comments
 * @property string $attachments
 * @property string $timestamp
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_monitoring.comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_comment', 'task_id', 'comments'], 'required'],
            [['user_comment', 'comments', 'attachments'], 'string'],
            [['task_id'], 'number'],
            [['timestamp'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_comment' => 'User Comment',
            'task_id' => 'Task ID',
            'comments' => 'Comments',
            'attachments' => 'Attachments',
            'timestamp' => 'Timestamp',
        ];
    }
}
