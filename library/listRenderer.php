<?php

class ListRenderer {
 	private $items;


	function __construct($items){
		$this->items = $items;
	}

	function __toString(){
		$out = '';
		for($i = 0; $i < count($this->items); $i ++){

			if($i % 4 == 0){
				$out .= '<div class="clearfix"></div>';
			}

			$item = $this->items[$i];
			$out .= $item;


		}

		return $out;
	}
}

?>