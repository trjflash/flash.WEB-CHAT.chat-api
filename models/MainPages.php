<?php

namespace app\models;
use yii\db\ActiveRecord;

class MainPages extends ActiveRecord{

    public static function tableName(){
        return 'flash_cms_table_pages';
    }

    public static function getPageContent($type){
        return self::find()->where(['page_type' => "$type", 'active' => "1"])->asArray()->all();
    }

}