<?php


namespace app\modules\Adm\models;


use yii\db\ActiveRecord;

class MenuTableToController extends ActiveRecord{

    public static function tableName(){
        return 'flash_cms_table_tables_controllers';
    }

    public static function getControllerName($tableName){
        if($tableName == "flash_cms_table_base_pages")
            return false;
        else
            return self::find()->where(['table_name' => $tableName])->select('controller_name')->asArray()->all();
    }

}