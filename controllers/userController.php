<?php

class UserController extends Controller{

	/**
	 * @var
	 */
	private $user = null;

	/**
	 * @var Medium[]
	 */
	private $products = null;

	/**
	 * UserController::run()
	 *
	 * @param array $params
	 * @return
	 */
	public function run($params = array())
	{
		$this->user = new User($params['id']);
		$this->products = Medium::findByUser($this->user);

		$this->setTitle($this->user->getName());
	}

	/**
	 * UserController::render()
	 *
	 * @return
	 */
	public function render()
	{
		$params = array();

		$params['imgurl'] = $this->user->get_gravatar(170);
		$params['name'] = $this->user->getName();
		$params['info'] = $this->user->getInfo();
		$params['products'] = '';
		foreach(PartialProduct::wrap($this->products) as $partial){
			$params['products'] .= $partial;
		}

		return $params;
	}
}

?>