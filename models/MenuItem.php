<?php

namespace app\models;
use yii\db\ActiveRecord;

class MenuItem extends ActiveRecord{

    public static function tableName(){
        return 'flash_cms_table_menus';
    }
    public function getMenuItems(){
        return $this->hasOne(Menu::class() , ['id' => 'parent_id']);
    }

}