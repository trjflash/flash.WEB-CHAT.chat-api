<?php


namespace app\modules\Adm\controllers;

use app\modules\Adm\models\MenuEditorsTypesModel;
use app\modules\Adm\models\PagesTypesModel;
use app\modules\Adm\models\RootEditorsModel;
use app\modules\Adm\models\ShopCategoriesModel;
use app\modules\Adm\models\ShopDeliveryModel;
use app\modules\Adm\models\ShopGoodsModel;

class EditorsController extends AdminAppController{

    public function actionMenu(){
        $menuTypes = MenuEditorsTypesModel::getAllMenus();
        //\flashHelpers::stopA($menuTypes);

        return $this->render('menuList.twig', compact(['menuTypes']));
    }
    public function actionRoot(){
        $rootMaterialsList = RootEditorsModel::getRootPagesList();
        $pagesTypes = PagesTypesModel::getRootPagesTypes();
        return $this->render('rootList.twig', compact(['rootMaterialsList','pagesTypes']));
    }
    public function actionShop(){
        $categoriesList = ShopCategoriesModel::getAllCategories();
        $goodsList = ShopGoodsModel::getAllGoods();
        $deliveryList = ShopDeliveryModel::getAllDeliveries();

        //\flashHelpers::stopA($categoriesList);

        return $this->render('shopMain.twig', compact(['categoriesList','goodsList','deliveryList']));
    }

}