<?php

abstract class Controller {

	private $action;
	private $tpl = null;
	private $renderTemplate = true;
	private $title;
	private $view;

	public function __construct($action){
		$this->tpl = Tpl::getInstance();
		$this->action = $action;
		$this->view = $action;
	}

	public abstract function run($params = array());

	/**
	 * @return string
	 */
	public abstract function render();

	protected function redirect($path){
		header('location:'.Configuration::ROOT_FOLDER.'/'.$path);
	}

	public function setRenderTemplate($flag){
		$this->renderTemplate = $flag;
	}

	public function getRenderTemplate(){
		return $this->renderTemplate;
	}

	public function getAction(){
		return $this->action;
	}

	protected function renderSubtemplate($name, $params = array()){
		return $this->tpl->render($this->action.'/'.$name, $params);
	}

	protected function renderPartialTemplate($name, $params = array()){
		return $this->tpl->render('partials/independant/'.$name, $params);
	}

	public function setTitle($title){
		$this->title = $title;
	}

	public function getTitle(){
		return $this->title;
	}

	public function getView(){
		return $this->view;
	}

	public function setView($view){
		$this->view = $view;
	}

}

?>