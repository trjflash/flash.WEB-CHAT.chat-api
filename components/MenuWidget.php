<?php
namespace app\components;

use flashHelpers;
use yii\base\Widget;
use \app\models\Menu;

class MenuWidget extends  Widget{

    public $tpl;
    private $data;
    private $tree;
    private $menuHtml;
    private $tmpl;

    public function init(){
        parent::init();

        if($this->tpl === null)
            $this->tpl = 'front_menu';
		
		//flashHelpers::stopA(Yii::getAlias("@feature/$this->tpl.ptmpl"));
        $this->tmpl = flashHelpers::getJSON("@feature/$this->tpl.ptmpl",true);

    }

    public function run(){
        $this->data = Menu::find()->indexBy('id')->asArray()->all();
        $this->tree = \flashHelpers::getTree($this->data);
        $this->menuHtml = $this->tmpl->start .  $this->getMenuHtml($this->tree) . $this->tmpl->end;
        //\flashHelpers::stopA($this->menuHtml);
        return $this->menuHtml;
    }

    protected function getMenuHtml($tree)
    {
        $str = '';
        foreach ($tree as $item) {

            $str .= $this->menuToTemplate($item);
        }
        return $str;

    }

    protected function menuToTemplate($menu)
    {
        $markers = array(
            '{#link#}',
            '{#title#}',
            '{#repRow#}'
        );
        $items = array(
        );
        $content = array(
            'menu' =>''
        );

        if($menu['is_parent'] == 1) {
            $content['menu'] .= flashHelpers::replacer(
                $markers,
                array(
                    $menu['link'],
                    $menu['menu_item'],
                    $this->getMenuHtml($menu['childs'])
                ),
                $this->tmpl->attached_start);
            $content['menu'] .= $this->tmpl->attached_end;
        }
        elseif($menu['is_parent'] == 0 && $menu['parent_id'] > 0){
            $content['menu'] .= flashHelpers::replacer($markers, array($menu['link'], $menu['menu_item']), $this->tmpl->attached_rep_row);
        }else{
            $content['menu'] .= flashHelpers::replacer($markers, array($menu['link'], $menu['menu_item']), $this->tmpl->rep_row);
        }
        return implode('', $content);
    }
}