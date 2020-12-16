<?php

namespace AkiCreative\AkiForms;

/**
 * FormService class
 *
 * @author akicreative
 */
class Desclist
{

	var $dtclass = '';
	var $ddclass = '';

	public function open($class = ''){

		echo '<dl class="row ' . $class . '">';

	}

	public function close(){

		echo '</dl>';

	}

	public function line($dt, $dd, $dtclass = '', $ddclass = ''){

		echo '<dt class="' . $this->dtclass . ' ' . $dtclass . '">' . $dt . '</dt>';

        echo '<dd class="' . $this->ddclass . ' '. $ddclass . '">' . $dd . '</dd>'; 

	}


}

?>