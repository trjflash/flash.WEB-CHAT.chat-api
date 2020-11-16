<?php


namespace app\modules\Adm\models;


use yii\db\ActiveRecord;

class ShopDeliveryModel extends ActiveRecord{

    public static function tableName(){
        return 'flash_cms_table_shop_delivery_type';
    }

    public static function getAllDeliveries(){
        return self::find()->asArray()->all();
    }
}