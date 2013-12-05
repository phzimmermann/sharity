<?php

class DashboardController extends Controller {

	/**
	 * @var Lending[]
	 */
	private $lendings = null;

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

	}

	/**
	 * DashboardController::render()
	 *
	 * @return
	 */
	public function render()
	{
		$params = array();

		return $params;
	}
}

?>