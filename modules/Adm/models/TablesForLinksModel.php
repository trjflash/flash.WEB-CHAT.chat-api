<?php
namespace app\modules\Adm\models;


use yii\db\ActiveRecord;

class TablesForLinksModel extends ActiveRecord{
    public static function tableName(){
        return 'flash_cms_table_tables_for_links';
    }

    public static function getTableTitles(){
        return self::find()->select('table_title')->asArray()->all();
    }
    public static function getTableName($tableTitle){
        return self::find()->where(['table_title' => $tableTitle])->select('table_name')->asArray()->all();
    }
    public static function getMaterialTitle($tableName){
        return self::find()->from($tableName)->select('title')->asArray()->all();
    }

}