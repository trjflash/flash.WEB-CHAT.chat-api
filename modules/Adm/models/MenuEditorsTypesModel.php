<?php
namespace app\modules\Adm\models;

use yii\db\ActiveRecord;

class MenuEditorsTypesModel extends ActiveRecord{

    public static function tableName(){
        return 'flash_cms_table_menus_types';
    }

    public static function getAllMenus(){

        return self::find()->asArray()->all();
    }

}