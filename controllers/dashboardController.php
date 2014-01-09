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

	/** @var User **/
	private $user = null;

	/** @var Form **/
	private $address_form = null;

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
		$this->user = $session->getUser();

		$this->lendings = Lending::getByLender($this->user);
		$this->asks = Lending::getByOwner($this->user);
		$this->products = Medium::findByUser($this->user);

		$this->address_form = $this->getAddressForm();
		$this->address_form->populate(
				array(
					'address' => $this->user->getAddress()
				)
			);

		$this->address_form->setSubmited($params['submitIndicator']);

		if($this->address_form->isSubmited()){
			$this->user->setAddress($params['address']);
			$this->user->save();
		}
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

		$params['address'] = $this->user->getAddress();
		$params['address_form'] = $this->address_form->render();

		/*
		$params['products'] = '';
		foreach(PartialProduct::wrap($this->products) as $partial){
			$params['products'] .= $partial;
		}
		*/
		$productList = new ListRenderer(PartialProduct::wrap($this->products));
		$params['products'] = $productList;

		return $params;
	}

	private function getAddressForm(){
		$form = new Form();
		$form->setId('address_form');

		$elAddress = new FormElementTextarea('address', 'Addresse');
		$form->addElement($elAddress);

		return $form;
	}
}

?>