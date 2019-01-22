<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task_monitoring.task".
 *
 * @property int $id
 * @property string $user_from
 * @property string $user_to
 * @property string $remark
 * @property string $status
 * @property string $description
 * @property string $date_from
 * @property string $date_to
 * @property string $update_at
 * @property string $create_at
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_monitoring.task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_from', 'user_to', 'remark', 'status', 'description', 'date_from', 'date_to'], 'required'],
            [['user_from', 'user_to', 'remark', 'status', 'description'], 'string'],
            // ['user_to', 'compare', 'compareValue' => 'nik', 'operator' => '==',  'targetClass' => '\app\models\User', 'message' => 'NIK is doesnt exist'],
            // ['user_to', 'filter', 'filter' => 'trim'],
            // ['user_to', 'compare', 'compareValue' => 'nik', 'operator' => '==', 'message' => "NIK is doesn't exists"],
            [['date_from', 'date_to', 'update_at', 'create_at'], 'safe'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_from' => 'User From',
            'user_to' => 'User To',
            'remark' => 'Remark',
            'status' => 'Status',
            'description' => 'Description',
            'date_from' => 'Date From',
            'date_to' => 'Date To',
            'update_at' => 'Update At',
            'create_at' => 'Create At',
        ];
    }
}
