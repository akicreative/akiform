<?php

namespace akicreative\akiforms;

/**
 * FormService class
 *
 * @author akicreative
 */
class Form
{

	var $errors = [];
	var $tabindex = 1;
	var $echo = true;
	var $csrf = true;
	var $horizontal = false;
	var $horizontalleft = 'col-md-3';
	var $horizontalright = 'col-md-9';
	var $size = 'form-control-sm';
	var $defaults = [];

	private function parse($args, $arguments)
	{

		$arguments = array_merge($args, $arguments);

		$attrs = [];

		foreach($arguments as $key => $value){

			if(!array_key_exists($key, $args)){

				switch($key){

					case "files":

						if($value){

							$key = 'enctype';
							$value = 'multipart/form-data';
					
						}

						break;

					default: 

						$value = '';
						break;

				}

			}

			if($value != ''){

				$attrs[] = $key . '="' . $value . '"';
			
			}

		}

		return implode(' ', $attrs);

	}

	public function __construct($errors, $arguments = []){

		foreach($arguments as $key => $value){

			$this->$key = $value;
		}

		$this->errors = $errors;

	}

	public function open($arguments = [], $fill = false){

		$args = [

			'action' => '',
			'id' => 'entryform',
			'method' => 'POST'

		];

		echo '<form ' . $this->parse($args, $arguments) . '>';

		echo csrf_field();

		if($fill){

			$array  = $fill->toArray();

			foreach($array as $key => $value){

				if(old($key)){

					$array[$key] = old($key);
				}
			}
		
			$this->defaults = $array;

		}

		echo "\n";

	}

	public function close(){

		echo '</form>' . "\n";

	}

	public function build($type, $label, $name, $cfgs = []){

		$cfg = [

			'fieldonly' => false,
			'blockhelp' => '',
			'echo' => $this->echo,
			'size' => $this->size,
			'class' => '',
			'horizontal' => $this->horizontal,
			'horizontalleft' => $this->horizontalleft,
			'horizontalright' => $this->horizontalright,
			'labelclass' => '',
			'required' => false,
			'default' => '',
			'selectoptions' => [],
			'selectblankfirst' => false,
			'selectshortcut' => '',
			'checkboxvalues' => [], // [[name, label, value]]
			'testmode' => false,
			'dateparams' => []

		];

		$attrs = [

			'id' => strtolower($name),
			'tabindex' => $this->tabindex,
			'placeholder' => ''

		];	

		$this->tabindex++;

		if(array_key_exists($name, $this->defaults)){

			$cfg['default'] = $this->defaults[$name];
		}

		
		$fieldattributes = ['name="' . $name . '"'];

		foreach($cfgs as $key => $value){

			if(array_key_exists($key, $attrs)){

				$attrs[$key] = $value;

			}

			if(array_key_exists($key, $cfg)){

				$cfg[$key] = $value;

			}

			if($key == 'attrs' && is_array($value)){

				foreach($value as $akey => $avalue){

					$fieldattributes[] = $akey . '="' . $avalue . '"';

				}

			}

		}

		if(old($name)){

			$cfg['default'] = old($name);
		}

		foreach($attrs as $key => $value){

			$fieldattributes[] = $key . '="' . $value . '"';
		}

		if(!$cfg['fieldonly']){

			$horizontal = '';
			$horizontalleft = '';
			$horizontalright = '';

			if($cfg['horizontal']){

				$horizontal = 'row';
				$horizontalleft = $cfg['horizontalleft'] . ' col-form-label';
				$horizontalright = $cfg['horizontalright'];
			}

			echo '<div class="form-group ' . $horizontal . '">';

			echo '<label for="' .  $attrs['id'] . '" class="' . $horizontalleft . ' ' . $cfg['labelclass'] . '">' . $label . '</label>';

			if($cfg['horizontal']){

				echo '<div class="' . $horizontalright . '">';
			}

		}

		$required = '';

		if($cfg['required']){

			$required = 'required';
		}

		$errorfeedback = '';

		if($this->errors->has($name)){

			$cfg['class'] .= ' is-invalid';

			if(!$cfg['fieldonly']){

				$errorfeedback = '<div class="invalid-feedback">
		          ' . $this->errors->first($name) . '
		        </div>';

	    	}
		}

		switch($type){

			case 'text':
			case 'email':

				
				echo '<input type="' . $type . '" class="form-control ' . $this->size . ' ' . $cfg['class'] . '" ' . implode(' ', $fieldattributes) . ' aria-describedby="' .  $attrs['id'] . 'Help" ' . $required . ' value="' . $cfg['default'] . '">';
    
				echo $errorfeedback;

				break;

			case 'textarea':

				echo '<textarea class="form-control ' . $this->size . ' ' . $cfg['class'] . '" ' . implode(' ', $fieldattributes) . ' aria-describedby="' .  $attrs['id'] . 'Help" ' . $required . '>' . $cfg['default'] . '</textarea>';
    
				echo $errorfeedback;

				break;

			case 'select':

				switch($cfg['selectshortcut']){

					case "yesno":
						$cfg['selectoptions'] = [1 => 'Yes', 0 => 'No'];
						break;

					case "noyes":
						$cfg['selectoptions'] = [0 => 'No', 0 => 'Yes'];
						break;

				}

				echo '<select class="form-control ' . $this->size . ' ' . $cfg['class'] . '" ' . implode(' ', $fieldattributes) . ' aria-describedby="' .  $attrs['id'] . 'Help" ' . $required . '>';

				

				if($cfg['selectblankfirst'] != ''){

					echo '<option value="">' . $cfg['selectblankfirst'] . '</option>';

				}

				foreach($cfg['selectoptions'] as $key => $option){

					$selected = '';

					if($key == $cfg['default']){

						$selected = 'selected';
					}

					echo '<option value="' . $key . '" ' . $selected . '>' . $option . '</option>';

				}

				echo '</select>';
    
				echo $errorfeedback;

				break;

			case 'dateselect':

				echo dateselect($name, $cfg['dateparams'] + ['default' => $cfg['default']]);

				break;

			case 'checkbox':
			case 'checkbox-inline':

				

				$array = $cfg['checkboxvalues'];

				foreach($array as $a){

					if($type == 'checkbox-inline'){

						echo '<div class="form-check form-check-inline">';

					}else{

						echo '<div class="form-check">';
					}

					$value = 1;

					if(array_key_exists(2, $a)){

						$value = $a[2];
					}

					echo '<input class="form-check-input" type="checkbox" name="' . $name . '" id="' . $name . $a[0] . '" value="' . $value . '">
  					<label class="form-check-label" for="' . $name . $a[0] . '">' . $a[1] . '</label>';

  					echo '</div>';

  				}

  				

				break;


		}

		if(!$cfg['fieldonly']){

			if($cfg['blockhelp'] != ''){

				echo '<small id="' . $attrs['id'] . 'Help" class="form-text text-muted">' . $cfg['blockhelp'] . '</small>';

			}

			if($cfg['horizontal']){

				echo '</div>';
			}

			echo '</div>';
		}

		if($cfg['testmode']){

			echo "<pre>";
			print_r($cfg);
			echo "</pre>";

			echo "<pre>";
			print_r($attrs);
			echo "</pre>";

			echo "<pre>";
			print_r($attrs);
			echo "</pre>";		

		}


	}


	public function test($val)
	{

		echo "<pre>";
		print_r(akiformsprovinces());
		echo "</pre>";	

		echo $val;

	}


}

?>