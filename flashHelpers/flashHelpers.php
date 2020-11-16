<?php


abstract class flashHelpers{

    private static $errors = array(
        "<div id='center'><div id='latest_news'><p style='float: left;' class='error'>Критическая ошибка при определении контроллера страницы</p></div></div>", // 0
        "<div id='center'><div id='latest_news'><p style='float: left;'>Нет контента для запрашиваемой страницы</p></div></div>", // piccolo
        "<div id='center'><div id='latest_news'><p style='float: left;'>Данного типа страницы не существует</p></div></div>", // 2
        "<div id='center'><div id='latest_news'><p style='float: left;'>Не удалось получить запрашиваемый список, скорее всего он просто пуст</p></div></div>", // 3
        "<div id='center'><div id='latest_news'><p style='float: left;'>Нет такого материала, или параметры не верны</p></div></div>", // 4
        "<div id='center'><div id='latest_news'><p style='float: left;'>Произошла ошибка. Материал не соответствует шаблону.</p></div></div>", // 5
        "<div id='center'><div id='latest_news'><p style='float: left;'>Не удалось получить шаблон для данного типа контента.</p></div></div>" // 6

    );

    public static function getErrCode($code_id){
        return self::$errors[$code_id];
    }

    private static $modal_errors = array(
        "Не удалось получить шаблон для данного типа контента.", // 0
        "Не верный формат имени сервера, попробуйте выбрать другой из списка.", // piccolo
        "Пожалуйста авторизируйтесь.", // 2
        "Ошибка при проверке авторизации, перезайдите. Выполняю автовыход.", // 3
        "Данные товара не верны, попробуйте еще раз.", // 4
        "Данного товара не существует, попробуйте еще раз.", // 5
        "Не удалось получить баланс, попробуйте еще раз.", // 6
        "Не удалось получить баланс, перезайдите. Выполняю автовыход.", // 7
        "Недостаточно средств для покупки, пожалуйста пополните ваш баланс.", // 8
        "Не удалось получить скидку, попробуйте еще раз.", // 9
        "Не удалось получить скидку, попробуйте еще раз. Выполняю автовыход.", // 10
        "Не корректный процент скидки.", // 11
        "Не корректный процент скидки. Выполняю автовыход.", // 12
        "Не удалось списать баланс.", // 13
        "Не удалось списать баланс. Выполняю автовыход.", // 14
        "Поздравляем с успешной покупкой!", // 15
        "Проверьте сумму или перелогиньтесь!", // 16
        "Прием платежей временно отключён. Попробуйте позднее" // 17
    );

    public static function getModalErrCode($code_id){
        return self::$modal_errors[$code_id];
    }

    //Стоп тест массива
    public static function stopA($arr){
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
        exit();
    }

    //Стоп тест переменной
    public static function stopV($var){
        echo $var;
        exit();
    }

    //Тест массива без остановки
    public static function testA($arr){
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
    }

    //Тест переменной без остановки
    public static function testV($var){
        echo $var;
    }

    //Очистка переменных
    public static function clear($var){
        return self::replacer(array('/','\\','<','>','UNION','FROM','WHERE','SELECT','ORDER','JOIN','LEFTJOIN','RIGHTJOIN','union','from','where','select','order','join','leftjoin','rightjoin'),array(''),stripslashes(strip_tags(trim($var))));
    }

    public static function replacer($replace_from, $replace_to, $replace_here){
        return str_replace($replace_from, $replace_to, $replace_here);
    }

    public static function getJSON($file_path, $alias = false,$need_array = false){
		
        if ($alias) {
            if ($need_array)
                return json_decode(file_get_contents(Yii::getAlias($file_path)), true);
            else
                return json_decode(file_get_contents(Yii::getAlias($file_path)));
        }
        else{
            if ($need_array)
                return json_decode(file_get_contents($file_path), true);
            else
                return json_decode(file_get_contents($file_path));
        }
    }

    public static  function getTree($data){
        $tree = [];
        foreach ($data as $id => &$node) {
            if (!$node['parent_id'])
                $tree[$id] = &$node;
            else
                $data[$node['parent_id']]['childs'][$node['id']] = &$node;
        }
        return $tree;
    }

    public static function translit($s) {
        $s = (string) $s; // преобразуем в строковое значение
        $s = strip_tags($s); // убираем HTML-теги
        $s = str_replace(array("\n", "\r"), " ", $s); // убираем перевод каретки
        $s = preg_replace("/\s+/", ' ', $s); // удаляем повторяющие пробелы
        $s = trim($s); // убираем пробелы в начале и конце строки
        $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
        $s = strtr($s, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
        $s = preg_replace("/[^0-9a-z-_ ]/i", "", $s); // очищаем строку от недопустимых символов
        $s = str_replace(" ", "-", $s); // заменяем пробелы знаком минус
        return $s; // возвращаем результат
    }
    public static function generateRandString($length = 6,$difficulty = 1){
        switch ($difficulty){
            case 1:
            default:
                $chars = 'QWERTYUIOPLKJHGFDSAZXCVBNMqwertyuioplkjhgfdsazxcvbnm';
                break;

            case 2:
                $chars = 'QWERTYUIOPLKJHGFDSAZXCVBNMqwertyuioplkjhgfdsazxcvbnm123456789';
                break;
            case 3:
                $chars = 'QWERTYUIOPLKJHGFDSAZXCVBNMqwertyuioplkjhgfdsazxcvbnm123456789!@#$%^&*()_+=-[]}{';
                break;
        }
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }
}