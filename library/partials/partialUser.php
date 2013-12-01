<?php
class PartialUser extends Partial{

	private $user;

	public function __construct(User $user){
		$this->user = $user;
		parent::__construct('user');
	}

	public function render(){
		return $this->renderSubtemplate('user', array(
								'userid' => $this->user->getId(),
								'username' => $this->user->getName(),
								'imgurl' => $this->user->get_gravatar()
							));
	}

	public static function wrap(User $user){
		return new self($user);
	}
}
?>