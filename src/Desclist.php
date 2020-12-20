<?php

namespace AkiCreative\AkiForms;

/**
 * FormService class
 *
 * @author akicreative
 */
class Desclist
{

	var $type = 'desclist';
	var $dtclass = 'col-12 col-md-4';
	var $ddclass = 'col-12 col-md-8';
	var $trueicon = '<i class="fa fa-check text-success fa-lg"></a>';
	var $falseicon = '';

	public function open($class = ''){

		if($this->type == 'listgroup'){

			echo '<div class="list-group ' . $class . '">';

		}else{


			echo '<dl class="row ' . $class . '">';

		}

	}

	public function close(){

		if($this->type == 'listgroup'){

			echo '</div>';

		}else{

			echo '</dl>';

		}

	}

	public function line($dt, $dd = '', $dtclass = '', $ddclass = ''){

		if($this->type == 'listgroup'){

			echo '<div class="list-group-item ' . $dtclass . '">' . $dt . '</div>';

		}else{

			echo '<dt class="' . $this->dtclass . ' ' . $dtclass . '">' . $dt . '</dt>';

        	echo '<dd class="' . $this->ddclass . ' '. $ddclass . '">' . $dd . '</dd>'; 

    	}

	}

	public function bool($value, $dd = '', $dtclass = 'col-1', $ddclass = 'col-11'){

		if($value){

			$icon = $this->trueicon;
		}else{

			$icon = $this->falseicon;
		}

		if($this->type == 'listgroup'){

			echo '<div class="list-group-item"><div class="row"><div class="' . $dtclass . '">' . $icon . '</div><div class="' . $ddclass . '">' . $dd . '</div></div></div>';

		}else{

			echo '<dt class="' . $dtclass . '">' . $icon . '</dt>';

        	echo '<dd class="' . $ddclass . '">' . $dd . '</dd>'; 

    	}

	}


}

?>