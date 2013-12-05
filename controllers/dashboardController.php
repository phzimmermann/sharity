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

		return $params;
	}
}

?>