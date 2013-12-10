<?php

class DashboardController extends Controller {

	/**
	 * @var Lending[]
	 */
	private $lendings = null;

	/**
	 * @var Lending[]
	 */
	private $asks = null;

	/**
	 * @var Medium[]
	 */
	private $products = null;

	/**
	 * DashboardController::run()
	 *
	 * @param array $params
	 * @return
	 */
	public function run($params = array())
	{
		$this->setTitle('Dashboard');

		$session = Session::getInstance();

		$this->lendings = Lending::getByLender($session->getUser());
		$this->asks = Lending::getByOwner($session->getUser());
		$this->products = Medium::findByUser($session->getUser());
	}

	/**
	 * DashboardController::render()
	 *
	 * @return
	 */
	public function render()
	{
		$params = array();

		$params['lendings'] = '';
		foreach(PartialLending::wrap($this->lendings) as $partial){
			$params['lendings'] .= $partial;
		}

		$params['asks'] = '';
		foreach(PartialLending::wrap($this->asks, 'ask') as $partial){
			$params['asks'] .= $partial;
		}

		$params['products'] = '';
		foreach(PartialProduct::wrap($this->products) as $partial){
			$params['products'] .= $partial;
		}

		return $params;
	}
}

?>