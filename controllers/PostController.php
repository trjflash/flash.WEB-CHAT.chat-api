<?php


namespace app\controllers;


use app\components\flash\flashWhatsAppBot;
use app\models\AjaxLogin;
use app\modules\Adm\models\MenuEditorModel;
use app\modules\Adm\models\MenuTableToController;
use app\modules\Adm\models\RootEditorsModel;
use app\modules\Adm\models\ShopCategoriesModel;
use app\modules\Adm\models\ShopGoodsModel;
use app\modules\Adm\models\ShopGoodsPhotosModel;
use app\modules\Adm\models\TablesForLinksModel;
use app\modules\Adm\models\MenuEditorsTypesModel;
use flashAjaxHelpers;
use flashHelpers;
use yii\helpers\Url;
use Yii;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\UploadedFile;

class PostController extends Controller{

    public function actionRequest(){

        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            //flashHelpers::stopA($data);
            switch ($data['action']){
                case 'adminLogin':
                    $this->adminLogin();
                    break;
                case 'editRoot':
                    $material = RootEditorsModel::findOne(['id'=>$data['mat_id']]);

                    $haveActive = false;
                    $current = RootEditorsModel::find()->where(['page_type'=>$data['page_type'], 'active' => 1])->all();
                    if(!empty($current)){
                        $current[0]->active = 0;
                        $haveActive = true;
                        $current[0]->save();
                    }

                    if(empty($data['title']) || empty($data['page_type']) ){
                        $exit['error'] = true;
                        $exit['error_level'] = flashAjaxHelpers::getErrorLevel(3);
                        $exit['mess'] = flashAjaxHelpers::returnJson(45);
                        echo json_encode($exit);
                        exit();
                    }
                    $material->title = $data['title'];
                    $material->keywords = $data['keywords'];
                    $material->description = $data['description'];
                    $material->page_content = $data['page_content'];
                    $material->active = $data['activ'];
                    $material->need_info_line = $data['need_info_line'];
                    $material->need_comments = $data['need_commnets'];
                    $material->page_type = $data['page_type'];
                    $material->page_type_name = $data['page_type_name'];

                    try {
                        if($material->save() && $haveActive){
                            $exit['error'] = false;
                            $exit['error_level'] = flashAjaxHelpers::getErrorLevel(1);
                            $exit['mess'] = flashAjaxHelpers::returnJson(44);
                            echo json_encode($exit);
                            exit();
                        }
                        else{
                            $exit['error'] = false;
                            $exit['error_level'] = flashAjaxHelpers::getErrorLevel(0);
                            $exit['mess'] = flashAjaxHelpers::returnJson(43);
                            echo json_encode($exit);
                            exit();
                        }
                    }catch (\Exception $e){
                        $exit['error'] = true;
                        $exit['error_level'] = flashAjaxHelpers::getErrorLevel(3);
                        $exit['mess'] = flashAjaxHelpers::returnJson(42);
                        echo json_encode($exit);
                        exit();
                    }

                    break;
                case 'addRoot':
                    $haveActive = false;
                    $current = RootEditorsModel::find()->where(['page_type'=>$data['page_type'], 'active' => 1])->all();
                    if(!empty($current)){
                        $current[0]->active = 0;
                        $haveActive = true;
                        $current[0]->save();
                    }

                    if(empty($data['title']) || empty($data['page_type']) ){
                        $exit['error'] = true;
                        $exit['error_level'] = flashAjaxHelpers::getErrorLevel(2);
                        $exit['mess'] = flashAjaxHelpers::returnJson(45);
                        echo json_encode($exit);
                        exit();
                    }

                    $material = new RootEditorsModel();
                    $material->title = $data['title'];
                    $material->keywords = $data['keywords'];
                    $material->description = $data['description'];
                    $material->page_content = $data['page_content'];
                    $material->active = $data['activ'];
                    $material->need_info_line = $data['need_info_line'];
                    $material->need_comments = $data['need_commnets'];
                    $material->page_type = $data['page_type'];
                    $material->page_type_name = $data['page_type_name'];

                    try {
                        if($material->save() && $haveActive){
                            $exit['error'] = false;
                            $exit['error_level'] = flashAjaxHelpers::getErrorLevel(1);
                            $exit['mess'] = flashAjaxHelpers::returnJson(44);
                            echo json_encode($exit);
                            exit();
                        }
                        else{
                            $exit['error'] = false;
                            $exit['error_level'] = flashAjaxHelpers::getErrorLevel(0);
                            $exit['mess'] = flashAjaxHelpers::returnJson(43);
                            echo json_encode($exit);
                            exit();
                        }
                    }catch (\Exception $e){
                        $exit['error'] = true;
                        $exit['error_level'] = flashAjaxHelpers::getErrorLevel(3);
                        $exit['mess'] = flashAjaxHelpers::returnJson(42);
                        echo json_encode($exit);
                        exit();
                    }
                    break;
                case 'dellRoot':
                    $material = RootEditorsModel::findOne(['id'=>$data['mat_id']]);
                    if (!empty($material)){
                        try {
                            $material->delete();
                            $exit['error'] = false;
                            $exit['error_level'] = flashAjaxHelpers::getErrorLevel(0);
                            $exit['mess'] = flashAjaxHelpers::returnJson(46);
                            echo json_encode($exit);
                            exit();

                        }catch (Exception $e){
                            $exit['error'] = true;
                            $exit['error_level'] = flashAjaxHelpers::getErrorLevel(3);
                            $exit['mess'] = flashAjaxHelpers::returnJson(42);
                            echo json_encode($exit);
                            exit();
                        }
                    }
                    break;
                case "getFirstMenuLvl":
                    $content['error'] = false;
                    $content['data'] = json_encode(TablesForLinksModel::getTableTitles());
                    return json_encode($content);

                    break;
                case "getSecondMenuLvl":

                    $table = TablesForLinksModel::getTableName($data['material'])[0]['table_name'];
                    $titles = TablesForLinksModel::getMaterialTitle($table);

                    $content['error'] = false;
                    $content['data'] = json_encode($titles);
                    return json_encode($content);

                    break;
                case "addMenu":
                    $data = json_decode($data['menuContent']);
                    $this->makeMenu(array($data));

                    break;
                case "editMenu":

                    $this->editMenu(array($data['menuName']));

                    break;
                case "getCategoriesNames":
                    $this->getShopCategories();
                    break;
                case "addNewCat":
                    $this->addNewCategory($data);
                    break;
                case "getCatForEdit":

                    $this->getCategory($data);
                    break;
                case "removeCat":
                    $this->removeCategory($data);
                    break;
                case "addNewGood":
                    $data['photos'] = $_FILES;
                    $this->addEditGood($data);
                    break;
                case "getBotMessagesByCHatId":
                    $this->getWaBotMessagesById($data);
                    break;
                default:
                    break;

            }
        }
    }

    private function adminLogin(){

        $model = new AjaxLogin();
        $model->getData(Yii::$app->request->post());
        $auth = $model->login();

        //\flashHelpers::stopA($auth);
        if ($auth) {
            $exit['error'] = false;
            $exit['error_level'] = flashAjaxHelpers::getErrorLevel(0);
            $exit['mess'] = flashAjaxHelpers::returnJson(40);
            echo json_encode($exit);
        }
        else{
            $exit['error'] = true;
            $exit['error_level'] = flashAjaxHelpers::getErrorLevel(3);
            $exit['mess'] = flashAjaxHelpers::returnJson(3);
            echo json_encode($exit);
        }
    }

    private function makeMenu($menu, $menuName = null, $parentId = null){
        if($menuName){
            for ($i = 0; $i<count($menu); $i++) {
                $this->addMenu($menu[$i], $menuName, $parentId);
            }
        }
        else{
            $menuName = flashHelpers::translit($menu[0]->name);
            $newType = new MenuEditorsTypesModel();
            $newType->menu_type = $menuName;
            $newType->menu_type_name = $menu[0]->name;

            try {
                if($newType->save()){
                    for ($i = 0; $i<count($menu[0]->items); $i++){
                        $this->addMenu($menu[0]->items[$i],$menuName);

                    }
                    $exit['error'] = true;
                    $exit['error_level'] = flashAjaxHelpers::getErrorLevel(0);
                    $exit['mess'] = flashAjaxHelpers::returnJson(43);
                    echo json_encode($exit);
                    exit();
                }
            }
            catch (\Exception $e){
                $exit['error'] = true;
                $exit['error_level'] = flashAjaxHelpers::getErrorLevel(2);
                $exit['mess'] = flashAjaxHelpers::returnJson(47);
                echo json_encode($exit);
                exit();
            }
        }



    }

    private function addMenu($menuToAdd, $menuType, $parentId = 0){


        $controller = MenuTableToController::getControllerName(
            TablesForLinksModel::getTableName($menuToAdd->menuData->destinationType)[0]['table_name']);


        if($controller){
            $controller = $controller[0]['controller_name'];
            $materialId = RootEditorsModel::getPageIdByTitle($menuToAdd->menuData->destinationPoint);
        }
        else
            $controller = false;


        $menuData = new MenuEditorModel();

        $menuData->menu_item = $menuToAdd->menuData->itemTitle;
        if (!$controller){
            switch ($menuToAdd->menuData->destinationPoint){
                case "Главная":
                    $menuData->link = "/";
                    break;
                default:
                    $menuData->link = "#";
                    break;
            }
        }
        else
            $menuData->link = Url::to([$controller . '/view', 'id' => $materialId]);

        $menuData->menu_type = $menuType;
        if (isset($menuToAdd->subMenuData))
            $menuData->is_parent = 1;
        else
            $menuData->is_parent = 0;
        $menuData->parent_id = $parentId;


        try{
            //flashHelpers::testA($parent);
            if($menuData->save() && !isset($menuToAdd->subMenuData)){
                return true;
            }
            else{
                //flashHelpers::stopA($menuData->getPrimaryKey());

                $this->makeMenu($menuToAdd->subMenuData,$menuType, $menuData->getPrimaryKey());
            }
        }catch (\Exception $e){
            $exit['error'] = true;
            $exit['error_level'] = flashAjaxHelpers::getErrorLevel(3);
            $exit['mess'] = flashAjaxHelpers::returnJson(42);
            echo json_encode($exit);
            exit();
        }

    }

    private function editMenu($data){
        $menuType = $data[0];
        $menuDataModel = new MenuEditorModel();
        $menuTypeModel = new MenuEditorsTypesModel();

        $menuData['menuName'] = $menuTypeModel->find()->where(['menu_type' => $menuType])->select('menu_type_name')->asArray()->all()[0]['menu_type_name'];
        $menuData['menuContent'] = $menuDataModel->find()->where(['menu_type' => $menuType])->asArray()->all();


        flashHelpers::stopA($menuData);
    }

    private function getShopCategories(){
        $categories = ShopCategoriesModel::getAllCategories();
        $catMenu = '';

        for ($i = 0; $i<count($categories); $i++){
            $catMenu .= '<option name="'.$categories[$i]['id'].'" value="'.$categories[$i]['id'].'">'.$categories[$i]['category_name'].'</option>';
        }

        $exit['error'] = false;
        $exit['data'] = $catMenu;
        echo json_encode($exit);

    }

    private function addNewCategory($data){
        $category = $data['data'];
        //flashHelpers::stopA($category);
        if($category['categoryId'] == 0)
            self::makeNewCategory($category);
        else
            self::editCurrentCategory($category);

    }

    private function removeCategory($data){
        $category = ShopCategoriesModel::findOne(['id'=>$data['data']]);
        if (!empty($category)){
            try {
                $category->delete();
                $exit['error'] = false;
                $exit['error_level'] = flashAjaxHelpers::getErrorLevel(0);
                $exit['mess'] = flashAjaxHelpers::returnJson(53);
                echo json_encode($exit);
                exit();

            }catch (Exception $e){
                $exit['error'] = true;
                $exit['error_level'] = flashAjaxHelpers::getErrorLevel(3);
                $exit['mess'] = flashAjaxHelpers::returnJson(42);
                echo json_encode($exit);
                exit();
            }
        }
        flashHelpers::stopA($data);
    }

    private function editCurrentCategory($category){
        ///flashHelpers::testA("htlfrnjh");
        if(!empty($category['categoryName']) && strlen($category['categoryName']) >= 4) {

            if($category['categoryName'] == $category['categoryParent']){
                $exit['error'] = true;
                $exit['error_level'] = flashAjaxHelpers::getErrorLevel(2);
                $exit['mess'] = flashAjaxHelpers::returnJson(52);
                echo json_encode($exit);
                exit();
            }

            $cat = ShopCategoriesModel::findOne(['id'=>$category['categoryId']]);

            $cat->category_name = $category['categoryName'];
            $cat->is_active = $category['categoryActive'];

            if(!empty($category['categoryParent'])){
                $cat->is_parent = '1';
                $cat->parent_id = ShopCategoriesModel::getCategoryIdByName($category['categoryParent']);
            }
            else{
                $cat->is_parent = '0';
                $cat->parent_id = 0;

            }

            $cat->keywords = $category['categoryKeyWords'];
            $cat->description = $category['categoryDescriprion'];
            try{

                if($cat->save()){
                    $exit['error'] = false;
                    $exit['error_level'] = flashAjaxHelpers::getErrorLevel(0);
                    $exit['mess'] = flashAjaxHelpers::returnJson(53);
                    echo json_encode($exit);
                    exit();                }
                else{
                    $exit['error'] = true;
                    $exit['error_level'] = flashAjaxHelpers::getErrorLevel(3);
                    $exit['mess'] = flashAjaxHelpers::returnJson(49);
                    echo json_encode($exit);
                    exit();
                }
            }catch (\Exception $e){
                $exit['error'] = true;
                $exit['error_level'] = flashAjaxHelpers::getErrorLevel(3);
                $exit['mess'] = flashAjaxHelpers::returnJson(49);
                echo json_encode($exit);
                exit();
            }

        }
        else{
            $exit['error'] = true;
            $exit['error_level'] = flashAjaxHelpers::getErrorLevel(3);
            $exit['mess'] = flashAjaxHelpers::returnJson(48);
            echo json_encode($exit);
            exit();
        }

        flashHelpers::stopA($category);
    }

    private function makeNewCategory($category){

        if(!empty($category['categoryName']) && strlen($category['categoryName']) >= 4) {

            $isIsset = true;
            try{
                ShopCategoriesModel::getCategoryIdByName($category['categoryName']);

            }
            catch (\Exception $e){
                $isIsset = false;
            }
            //flashHelpers::stopA($isIsset);
            if($isIsset){
                $exit['error'] = true;
                $exit['error_level'] = flashAjaxHelpers::getErrorLevel(3);
                $exit['mess'] = flashAjaxHelpers::returnJson(51);
                echo json_encode($exit);
                exit();
            }

            $categoryModel = new ShopCategoriesModel();
            $categoryModel->category_name = $category['categoryName'];
            $categoryModel->is_active = $category['categoryActive'];

            if(!empty($category['categoryParent'])){
                $categoryModel->is_parent = '1';
                $categoryModel->parent_id = ShopCategoriesModel::getCategoryIdByName($category['categoryParent']);
            }

            $categoryModel->keywords = $category['categoryKeyWords'];
            $categoryModel->description = $category['categoryDescriprion'];

            try{

                if($categoryModel->save()){
                    $exit['error'] = false;
                    $exit['error_level'] = flashAjaxHelpers::getErrorLevel(0);
                    $exit['mess'] = flashAjaxHelpers::returnJson(50);
                    echo json_encode($exit);
                    exit();
                }
                else{
                    $exit['error'] = true;
                    $exit['error_level'] = flashAjaxHelpers::getErrorLevel(3);
                    $exit['mess'] = flashAjaxHelpers::returnJson(49);
                    echo json_encode($exit);
                    exit();
                }
            }catch (\Exception $e){
                $exit['error'] = true;
                $exit['error_level'] = flashAjaxHelpers::getErrorLevel(3);
                $exit['mess'] = flashAjaxHelpers::returnJson(49);
                echo json_encode($exit);
                exit();
            }

        }
        else{
            $exit['error'] = true;
            $exit['error_level'] = flashAjaxHelpers::getErrorLevel(3);
            $exit['mess'] = flashAjaxHelpers::returnJson(48);
            echo json_encode($exit);
            exit();
        }

    }

    private function getCategory($data){

        $categoryData = ShopCategoriesModel::getCategoryNameById($data['data']);
        if(!empty($categoryData)){
            $exit['error'] = false;
            $exit['data'] = $categoryData[0];
            echo json_encode($exit);
        }
        else{
            $exit['error'] = true;
            $exit['error_level'] = flashAjaxHelpers::getErrorLevel(3);
            $exit['mess'] = flashAjaxHelpers::returnJson(49);
            echo json_encode($exit);
            exit();
        }
    }

    private function addEditGood($data){
        if($data['currentGoodId'] == 0)
            self::makeNewGood($data);
        else
            self::editCurrentGood($data);

    }

    private function makeNewGood($good){

        if(!empty($good['goodName']) && strlen($good['goodName']) >= 4) {

            $isIsset = true;
            try{
                ShopGoodsModel::getGoodIdByName($good['goodName']);

            }
            catch (\Exception $e){
                $isIsset = false;
            }
            //flashHelpers::stopA($isIsset);
            if($isIsset){
                $exit['error'] = true;
                $exit['error_level'] = flashAjaxHelpers::getErrorLevel(3);
                $exit['mess'] = flashAjaxHelpers::returnJson(54);
                echo json_encode($exit);
                exit();
            }

            $goodModel = new ShopGoodsModel();
            $goodModel->category_id = $good['goodCategory'];
            $goodModel->name = $good['goodName'];
            $goodModel->price = $good['goodPrice'];
            $goodModel->self_price = $good['goodSelfPrice'];
            $goodModel->anons = $good['goodAnons'];
            $goodModel->description = $good['goodDescription'];
            $goodModel->top = $good['topGood'];
            $goodModel->new = $good['newGood'];
            $goodModel->active = $good['activeGood'];
            $goodModel->availability = $good['availability'];


            try{

                if($goodModel->save()){


                    $photos = array();
                    for ($i = 0; $i < count($good['photos']); $i++){

                        $ext = explode('.', $good['photos'][$i]['name']);
                        //Helpers::stopA($_FILES);
                        $file = flashHelpers::generateRandString(10).'.'.end($ext);

                        $res[] = $file;
                        try {
                            move_uploaded_file($good['photos'][$i]['tmp_name'], Yii::getAlias('@shopphotos/goods/') . $file);
                        }catch (\Exception $e){
                            //flashHelpers::stopA($e->getMessage());
                        }
                        //flashHelpers::stopA(Yii::getAlias('@shopphotos/goods/').$file);
                        $newPhoto = new ShopGoodsPhotosModel();

                        $newPhoto->file = $file;
                        $newPhoto->good_id = $goodModel->id;
                            $i == 0 ? $newPhoto->is_main = 1 : $newPhoto->is_main = 0;

                        $newPhoto->save();
                        $photos[] = $newPhoto->id;
                    }


                    $goodModel->photos = implode(',', $photos);
                    $goodModel->code = flashHelpers::generateRandString(10).$goodModel->id;
                    $goodModel->save();


                    $exit['error'] = false;
                    $exit['error_level'] = flashAjaxHelpers::getErrorLevel(0);
                    $exit['mess'] = flashAjaxHelpers::returnJson(55);
                    echo json_encode($exit);
                    exit();
                }
                else{
                    $exit['error'] = true;
                    $exit['error_level'] = flashAjaxHelpers::getErrorLevel(3);
                    $exit['mess'] = flashAjaxHelpers::returnJson(56);
                    echo json_encode($exit);
                    exit();
                }
            }catch (\Exception $e){
                $exit['error'] = true;
                $exit['error_level'] = flashAjaxHelpers::getErrorLevel(3);
                $exit['mess'] = flashAjaxHelpers::returnJson(56);
                echo json_encode($exit);
                exit();
            }

        }
        else{
            $exit['error'] = true;
            $exit['error_level'] = flashAjaxHelpers::getErrorLevel(3);
            $exit['mess'] = flashAjaxHelpers::returnJson(54);
            echo json_encode($exit);
            exit();
        }

    }

    private function editCurrentGood($good){

    }


    private function getWaBotMessagesById($data){
        $chatId = $data['chatId'];
        //flashHelpers::stopA($chatId);

        $bot = new flashWhatsAppBot();
        $messages = $bot->sendRequestGet('messagesHistory', ["chatId=$chatId"]);
        //flashHelpers::testA($messages);

        $messages->messages = (array_reverse($messages->messages));
//flashHelpers::stopA($messages);
        $exit['error'] = false;
        $exit['data'] = $messages;
        echo json_encode($exit);
        exit();
    }
    
}