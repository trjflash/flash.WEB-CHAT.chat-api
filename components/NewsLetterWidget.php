<?php
namespace app\components;

use flashHelpers;
use yii\base\Widget;


class NewsLetterWidget extends Widget{
    public $tpl;
    private $tmpl;

    public function init(){
        parent::init();
        $this->tpl = 'newsletter';
        $this->tmpl = flashHelpers::getJSON("@feature/$this->tpl.ptmpl", true);

    }

    public function run(){
        $out = '';
        $out .= $this->tmpl->newsletter;

        return $out;
    }
}