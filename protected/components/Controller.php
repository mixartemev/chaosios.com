<?php
class Controller extends CController{
	/**
	 * @var string по умолчанию layout 'column1'
	 * 'protected/views/layouts/column1.php'
	 */
	public $layout='column1';
	// @var array содержит menu items {@link CMenu::items}
	public $menu=array();
	// @var array крошки {@link CBreadcrumbs::links}
	public $breadcrumbs=array();
	public function dbg($a){
        echo '<pre>';
        print_r($a);
        echo '</pre>';
    }
}