<?php


namespace app\modules\Adm\models;


use yii\db\ActiveRecord;

class ShopGoodsModel extends ActiveRecord{

    public static function tableName(){
        return 'flash_cms_table_shop_goods';
    }

    public static function getAllGoods(){
        return self::find()->asArray()->all();
    }
    public static function getGoodIdByName($goodName){
        return self::find()->where(['name' => $goodName])->select('id')->asArray()->all()[0]['id'];
    }
    public static function getGoodNameById($id){
        return self::find()->where(['id' => $id])->asArray()->all();
    }

}