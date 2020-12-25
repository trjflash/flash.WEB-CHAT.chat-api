<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
/**
 * Инициализатор RBAC выполняется в консоли php yii my-rbac/init
 */
class MyRbacController extends Controller {

    public function actionInit() {
        $auth = Yii::$app->authManager;

        $auth->removeAll(); //На всякий случай удаляем старые данные из БД...

        // Создадим роли админа и редактора новостей
        $fullAdmin = $auth->createRole('fullAdmin');
        $almatyAdmin = $auth->createRole('almatyAdmin');
        $almatyOperator = $auth->createRole('almatyOperator');
        $astanaAdmin = $auth->createRole('astanaAdmin');
        $astanaOperator = $auth->createRole('astanaOperator');
        $ukAdmin = $auth->createRole('ukAdmin');
        $ukOperator = $auth->createRole('ukOperator');

        // запишем их в БД
        $auth->add($fullAdmin);
        $auth->add($almatyAdmin);
        $auth->add($almatyOperator);
        $auth->add($astanaAdmin);
        $auth->add($astanaOperator);
        $auth->add($ukAdmin);
        $auth->add($ukOperator);

        // Создаем разрешения. Например, просмотр админки viewAdminPage и редактирование новости updateNews
        $systemAdmin = $auth->createPermission('systemAdmin');
        $systemAdmin->description = 'Администратор системы';

        $instanceAdmin = $auth->createPermission('instanceAdmin');
        $instanceAdmin->description = 'Администратор инстанса бота';

        $chatOperator = $auth->createPermission('chatOperator');
        $chatOperator->description = 'Оператор чат бота';

        // Запишем эти разрешения в БД
        $auth->add($systemAdmin);
        $auth->add($instanceAdmin);
        $auth->add($chatOperator);

        // Теперь добавим наследования. Для роли editor мы добавим разрешение updateNews,
        // а для админа добавим наследование от роли editor и еще добавим собственное разрешение viewAdminPage

        // Роли «Редактор новостей» присваиваем разрешение «Редактирование новости»
        $auth->addChild($fullAdmin,$systemAdmin);

        $auth->addChild($systemAdmin,$chatOperator);
        $auth->addChild($systemAdmin,$instanceAdmin);

        $auth->addChild($almatyOperator,$chatOperator);
        $auth->addChild($astanaOperator,$chatOperator);
        $auth->addChild($ukOperator,$chatOperator);

        $auth->addChild($almatyAdmin,$instanceAdmin);
        $auth->addChild($astanaAdmin,$instanceAdmin);
        $auth->addChild($ukAdmin,$instanceAdmin);

        $auth->addChild($almatyAdmin,$chatOperator);
        $auth->addChild($astanaAdmin,$chatOperator);
        $auth->addChild($ukAdmin,$chatOperator);


        // Назначаем роль admin пользователю с ID 1
        $auth->assign($fullAdmin, 1);

        $auth->assign($almatyAdmin, 3);
        $auth->assign($astanaAdmin, 2);
        $auth->assign($ukAdmin, 4);
        $auth->assign($almatyOperator, 6);
        $auth->assign($astanaOperator, 5);
        $auth->assign($ukOperator, 7);
    }
}