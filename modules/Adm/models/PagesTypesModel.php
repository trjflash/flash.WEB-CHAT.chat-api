<?php
namespace app\modules\Adm\models;


use yii\db\ActiveRecord;

class PagesTypesModel extends ActiveRecord{
    public static function tableName(){
        return 'flash_cms_table_pages_types';
    }

    public static function getRootPagesTypes(){
        return self::find()->asArray()->all();
    }

}