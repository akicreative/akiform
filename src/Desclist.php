<?php

namespace AkiCreative\AkiForms;

/**
 * FormService class
 *
 * @author akicreative
 */
class Desclist
{

	var $openclass = '';
	var $type = 'desclist';
	var $style = '';
	var $hideempty = false;
	var $dtclass = 'col-12 col-md-4';
	var $ddclass = 'col-12 col-md-8';
	var $verticaldtclass = 'text-black-50';
	var $verticalddclass = 'col-12 col-md-8';
	var $trueicon = '<i class="fa fa-check text-success fa-lg fa-fw"></i>';
	var $falseicon = '<i class="fa fa-close fa-lg fa-fw invisible"></i>';
	var $hr = '<hr class="my-2">';

	public function open($class = ''){

		if($this->type == 'listgroup'){

			echo '<div class="list-group ' . $class . '">';

		}else{


			echo '<dl class="row ' . $class . ' mb-0">';

		}

		$this->openclass = $class;

	}

	public function close(){

		if($this->type == 'listgroup'){

			echo '</div>';

		}else{

			echo '</dl>';

		}

	}

	public function set($var = '', $value = ''){

		switch($var){

			case "style":

				$this->style = $value;

				switch($value){

					case "vertical":
					case "verticalbottom":
						$this->dtclass = 'text-muted';
						break;

				}

				break;

			case "hideempty":

				$this->hideempty = $value;

				break;

		}

	}

	public function line($dt = '', $dd = '', $dtclass = 'fw-bolder', $ddclass = '', $divider = false){

		if($this->type == 'listgroup'){

			if($dd == '' && !$this->hidempty || $dd == 'desclistheader' && $this->hideempty){

				echo '<div class="list-group-item ' . $dtclass . '">' . $dt . '</div>';

			}elseif($this->style == 'vertical' || $this->style == 'verticalbottom'){

				if($this->hideempty && $dd == '' && !is_array($dd)){

					return;
				}

				echo '<div class="list-group-item">';

				if(is_array($dd)){

					if($dt != ''){

						echo '<div class="' . $this->ddclass . ' ' . $ddclass . ' fw-bolder">' . $dt . '</div>';

						for($i = 0; $i < count($dd); $i++){

							if($this->hideempty && $dd[$i][1] != ''){

								$label = '<div class="' . $this->dtclass . ' ' . $dtclass . '"><small>' . $dd[$i][0] . '</small></div>';

								$value = '<div class="' . $this->ddclass . ' ' . $ddclass . '">' . $dd[$i][1] . '</div>';

								if($this->style == 'vertical'){

									echo $label . $value;
								}else{

									echo $value . $label;
								}

							}

						}
					}

				}else{

					$label = '<div class="' . $this->dtclass . ' ' . $dtclass . '"><small>' . $dt . '</small></div>';

					$value = '<div class="' . $this->ddclass . ' ' . $ddclass . '">' . $dd . '</div>';

					if($this->style == 'vertical'){

						echo $label . $value;
					}else{

						echo $value . $label;
					}

				}

				echo '</div>';

			}else{

				if($this->hideempty && $dd == ''){

					return;
				}

				echo '<div class="list-group-item">';

				echo '<div class="row">';

				echo '<div class="' . $this->dtclass . ' ' . $dtclass . '">' . $dt . '</div>';

				echo '<div class="' . $this->ddclass . ' ' . $ddclass . '">' . $dd . '</div>';

				echo '</div>';

				echo '</div>';

			}

		}else{

			if($this->hideempty && $dd == ''){

				return;
			}

			echo '<dt class="' . $this->dtclass . ' ' . $dtclass . '">' . $dt . '</dt>';

        	echo '<dd class="' . $this->ddclass . ' '. $ddclass . '">' . $dd . '</dd>'; 

        	if($divider){

	    		$this->divider();

	    	}

    	}

    	

	}

	public function divider($hr = ''){

		$this->close();

		if($hr != ''){

			echo $hr;
		}else{

			echo $this->hr;
		}

		$this->open($this->openclass);

	}

	public function bool($value, $dd = '', $dtclass = 'col-12', $ddclass = ''){

		if($value){

			$icon = $this->trueicon;
		}else{

			$icon = $this->falseicon;
		}

		if($this->type == 'listgroup'){

			echo '<div class="list-group-item"><div class="row"><div class="' . $dtclass . '">' . $icon . '</div><div class="' . $ddclass . '">' . $dd . '</div></div></div>';

		}else{

			if($ddclass == ''){

				echo '<dt class="' . $dtclass . '">' . $icon . ' ' . $dd . '</dt>'; 

			}else{

				echo '<dt class="' . $dtclass . '">' . $icon . '</dt>'; 
				echo '<dd class="' . $ddclass . '">' . $dd . '</dd>'; 
			}

    	}

	}


}

?>