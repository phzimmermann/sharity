<?php

class Dispatcher {

	static private $instance = null;
	private $action = null;

	/**
	 * @return Dispatcher
	 */
	static public function getInstance(){
		if (null === self::$instance) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	private function _getParams(){
		if($_GET['action'] == ''){
			$this->action = 'index';
			return array();
		}
		$pos = split('/', $_GET['action']);
		$this->action = array_shift($pos);
		$params = $_POST;
		while(count($pos) > 1){
			$key = array_shift($pos);
			$value = array_shift($pos);
			$params[$key] = $value;
		}

		return $params;
	}

	public function run(){
		$params = $this->_getParams();
		$controllerName = ucfirst($this->action).'Controller';
		$controller = new $controllerName($this->action);
		$controller->run($params);
		$templateParams = $controller->render();

		if($controller->getRenderTemplate()){
			$content = $this->addTemplate($templateParams, $controller);
			print($content);
			return;
		}

		print($templateParams['content']);
	}

	private function addTemplate($templateParams, $controller){
		$tpl = Tpl::getInstance();
		$templateName = $controller->getView();

		$header = new PartialHeader();
		$footer = new PartialFooter();

		$actionContent = $tpl->render($templateName, $templateParams);

		return $tpl->render('site', array(
										'content'	=> $actionContent,
										'header' 	=> $header->render(),
										'footer'	=> $footer->render(),
										'sitetitle' => $controller->getTitle()));
	}

	public function getAction(){
		return $this->action;
	}

}