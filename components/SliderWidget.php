<?php
namespace app\components;

use flashHelpers;
use yii\base\Widget;
use Yii;


class SliderWidget extends Widget{
    public $tpl;
    private $tmpl;
    private $slides;

    public function init(){
        parent::init();

        if($this->tpl === null)
            $this->tpl = 'main_page_slider';

        $this->tmpl = flashHelpers::getJSON("@feature/$this->tpl.ptmpl",true);
        $this->slides = flashHelpers::getJSON("@webfeature/slider/$this->tpl/slides.json", true, true);

    }

    public function run(){
        $out = '';
        $out .= $this->tmpl->start;
        for ($i = 0; $i<count( $this->slides); $i++){
            $out .= flashHelpers::replacer(array('{#img#}','{#text#}'),array($this->slides[$i]['path'].$this->slides[$i]['name'],$this->slides[$i]['description']),$this->tmpl->rep_row);
        }
        $out .= $this->tmpl->end;
        return $out;
    }
}