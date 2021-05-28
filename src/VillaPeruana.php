<?php

namespace App;

class VillaPeruana
{
    public $name;

    public $quality;

    public $sellIn;

    public function __construct($name, $quality, $sellIn)
    {
        $this->name = $name;
        $this->quality = $quality;
        $this->sellIn = $sellIn;
    }

    public static function of($name, $quality, $sellIn) {
        return new static($name, $quality, $sellIn);
    }

    public function tick()
    {
        
        if($this->isEditableForProduct()){
            if($this->isEditableForMinMaxQuality()){
                $nQualitySubOrAdd = $this->subtractForDateSell();
                $subQuality = $this->subtractOrAddForProduct();
                $multSubQuality = $this->isProductCafe();

                list($nQualitySubOrAdd, $subQuality) = $this->isProductTicket($nQualitySubOrAdd, $subQuality);

                $this->subtractOrAddQuality($subQuality, $nQualitySubOrAdd, $multSubQuality);

                $this->checkMinMaxQuality();
            }
            
            $this->sellIn -= 1;
            
        }
        
    }

    function isEditableForProduct(){
        // it is Editable for Product
        return $this->name != 'Tumi de Oro Moche';
    }

    function isEditableForMinMaxQuality(){
        // it is Editable for Min or Max Quality
        return $this->quality > 0 && $this->quality < 50;
    }

    function subtractForDateSell(){
        // it double subtraction if date has passed
        return ($this->sellIn > 0)? 1 : 2;
    }

    function subtractOrAddForProduct(){
        // it subtraction or add for Product
        $subQuality = true;
        if($this->name == 'Pisco Peruano' || $this->name == 'Ticket VIP al concierto de Pick Floid'){
            $subQuality = false;
        }
        return $subQuality;
    }


    function isProductTicket($nQualitySubOrAdd, $subQuality){
        // it Product Ticket Add Quality less days sell, but sell is passed quality subtract to cero
        if($this->name == 'Ticket VIP al concierto de Pick Floid'){
                    
            if($this->sellIn <= 10){
                $nQualitySubOrAdd = 2;
            }

            if($this->sellIn <= 5){
                $nQualitySubOrAdd = 3;
            }

            if($this->sellIn < 1){
                $nQualitySubOrAdd = $this->quality;
                $subQuality = true;
            }
        }

        return [$nQualitySubOrAdd, $subQuality];
    }


    function isProductCafe(){
        // it double subtraction if date has passed
        $multSubQuality = 1;
        if($this->name == 'Café Altocusco'){
            $multSubQuality = 2;
        }
        return $multSubQuality;
    }


    function checkMinMaxQuality(){
        // it check Min or Max Quality
        $this->quality = ($this->quality < 0)? 0 : $this->quality;
        $this->quality = ($this->quality > 50)? 50 : $this->quality;
    }


    function subtractOrAddQuality($subQuality, $nQualitySubOrAdd, $multSubQuality){
        // it subtract or add quality
        if($subQuality){
            $this->quality =  $this->quality - ($nQualitySubOrAdd * $multSubQuality);
        }else {
            $this->quality =  $this->quality + $nQualitySubOrAdd;
        }
    }


}
