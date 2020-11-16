<?php
use yii\helpers\Html;

$markers = array(
    '{#link#}',
    '{#title#}'
);
$items = array(

);
$content = array(
    'menu' =>''
);
flashHelpers::stopA($menu);

if($menu['parent_id'] != 0) {
    $content['menu'] .= flashHelpers::replacer($markers, array($menu['link'], $menu['menu_item']), $this->tmpl->attached_rep_row);
}
else{
    //flashHelpers::stopA($menu);
    $content['menu'] .= flashHelpers::replacer($markers, array($menu['link'], $menu['menu_item']), $this->tmpl->rep_row);
}


if(isset($menu['childs'])){
    $content['menu'] .= $this->tmpl->attached_start;
    $this->getMenuHtml($menu['childs']);
    $content['menu'] .= $this->tmpl->attached_end;
}

echo implode('', $content);
