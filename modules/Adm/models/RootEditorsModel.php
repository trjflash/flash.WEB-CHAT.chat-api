<?php
namespace app\modules\Adm\models;

use yii\db\ActiveRecord;

class RootEditorsModel extends ActiveRecord{

    public static function tableName(){
        return 'flash_cms_table_pages';
    }

    public static function getRootPagesList(){

        return self::find()->asArray()->all();
    }
    public static function getPageIdByTitle($tile)
    {
        return self::find()->where(['title' => $tile])->select('id')->asArray()->all()[0]['id'];
    }

}