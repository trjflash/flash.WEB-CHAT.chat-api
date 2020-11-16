<?php


namespace app\components;

use flashHelpers;
use yii\base\Widget;
use Yii;

class FooterContactWidget extends  Widget{

    public $tpl;
    private $tmpl;

    public function init(){
        parent::init();
        $this->tpl = 'footer_contact';
        $this->tmpl = flashHelpers::getJSON("@feature/$this->tpl.ptmpl", true);

    }

    public function run(){
        $out = '';
        $out .= flashHelpers::replacer(array('{#WEB#}'),array(Yii::getAlias('@web')),$this->tmpl->footer_contact);

        return $out;
    }
}