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
	var $dtclass = '';
	var $ddclass = '';

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


}

?>