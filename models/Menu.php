<?php

namespace app\models;
use yii\db\ActiveRecord;

class Menu extends ActiveRecord{

    public static function tableName(){
        return 'flash_cms_table_menus';
    }
    public function getMenus(){
        return $this->hasMany(MenuItem::class() , ['parent_id' => 'id']);
    }

}