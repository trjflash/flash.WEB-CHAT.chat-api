<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
/**
 * Инициализатор RBAC выполняется в консоли php yii my-rbac/init
 */
class MyRbacController extends Controller {

    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll(); //На всякий случай удаляем старые данные из БД...

        // Создадим роли админа и редактора новостей
        $fullAdminRole = $auth->createRole('fullAdmin');
        //$fullAdminRole->description('Роль администратора системы');

        $instanceAdminRole = $auth->createRole('instanceAdmin');
        //$instanceAdminRole->description('Роль администратора чата');

        $instanceOperatorRole = $auth->createRole('instanceOperator');
        //$instanceOperatorRole->description('Роль оператор чата');


        // запишем их в БД
        $auth->add($fullAdminRole);
        $auth->add($instanceAdminRole);
        $auth->add($instanceOperatorRole);

        // Создаем разрешения. Например, просмотр админки viewAdminPage и редактирование новости updateNews
        $systemAdminPerm = $auth->createPermission('systemAdmin');
        $systemAdminPerm->description = 'Администратор системы';

        $chatAdminPerm = $auth->createPermission('chatAdmin');
        $chatAdminPerm->description = 'Администратор инстанса бота';

        $chatOperatorPerm = $auth->createPermission('chatOperator');
        $chatOperatorPerm->description = 'Оператор чат бота';


        // Запишем эти разрешения в БД
        $auth->add($systemAdminPerm);
        $auth->add($chatAdminPerm);
        $auth->add($chatOperatorPerm);

        // Теперь добавим наследования. Для роли editor мы добавим разрешение updateNews,
        // а для админа добавим наследование от роли editor и еще добавим собственное разрешение viewAdminPage

        // Роли «Редактор новостей» присваиваем разрешение «Редактирование новости»
        $auth->addChild($fullAdminRole, $systemAdminPerm);
        $auth->addChild($fullAdminRole, $instanceAdminRole);
        $auth->addChild($fullAdminRole, $instanceOperatorRole);

        $auth->addChild($systemAdminPerm, $chatAdminPerm);
        $auth->addChild($chatAdminPerm, $chatOperatorPerm);


        $auth->addChild($instanceAdminRole, $chatAdminPerm);
        $auth->addChild($instanceAdminRole, $instanceOperatorRole);

        $auth->addChild($instanceOperatorRole, $chatOperatorPerm);



        // Назначаем роль admin пользователю с ID 1
        $auth->assign($fullAdminRole, 1);

        $auth->assign($instanceOperatorRole, 5);
        $auth->assign($instanceOperatorRole, 6);
        $auth->assign($instanceOperatorRole, 7);
        $auth->assign($instanceAdminRole, 2);
        $auth->assign($instanceAdminRole, 3);
        $auth->assign($instanceAdminRole, 4);
    }

}