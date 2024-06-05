<?php

namespace Quetab\QuetabPanel\Facade;

use Illuminate\Support\Facades\Facade;

class QuetabPanelFacade extends Facade
{
    protected static function getFacadeAccessor(){
         return 'QuetabPanel'; 
    }
}