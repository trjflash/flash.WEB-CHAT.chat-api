<?php


namespace app\modules\Adm\models;

use yii\db\ActiveRecord;

class ShopCategoriesModel extends ActiveRecord{

    public static function tableName(){
        return 'flash_cms_table_shop_categories';
    }

    public static function getAllCategories(){
        return self::find()->asArray()->all();
    }
    public static function getCategoryIdByName($categoryName){
        return self::find()->where(['category_name' => $categoryName])->select('id')->asArray()->all()[0]['id'];
    }
    public static function getCategoryNameById($id){
        return self::find()->where(['id' => $id])->asArray()->all();
    }
}