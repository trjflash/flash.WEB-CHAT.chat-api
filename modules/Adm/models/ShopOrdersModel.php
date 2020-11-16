<?php


namespace app\modules\Adm\models;


use yii\db\ActiveRecord;

class ShopOrdersModel extends ActiveRecord{

    public static function tableName(){
        return 'flash_cms_table_orders';
    }

}