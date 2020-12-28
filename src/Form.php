<?php

namespace AkiCreative\AkiForms;

use Illuminate\Support\Str;

/**
 * FormService class
 *
 * @author akicreative
 */
class Form
{

	var $errors = [];
	var $tabindex = 1;
	var $fieldonly = false;
	var $echo = true;
	var $csrf = true;
	var $horizontal = false;
	var $horizontalleft = 'col-md-3';
	var $horizontalright = 'col-md-9';
	var $datepicker = false;
	var $size = 'form-control-sm';
	var $defaults = [];
	var $constrainform = '';
	var $inlinelist = false;
	var $openform = false;
	var $viewmode = false;
	var $divider = '<hr class="my-0">';
	var $compact = true;
	var $switchon = '<i class="fas fa-lg fa-check-square"></i>';
	var $switchoff = '<i class="far fa-lg fa-square"></i>';
	var $formgroupclass = '';
	var $labelclass = '';
	var $requiredappend = '';
	var $requiredprepend = '';
	var $requiredlabelclass = '';

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

	public function __construct($errors = [], $arguments = []){

		foreach($arguments as $key => $value){

			$this->$key = $value;
		}

		$this->errors = $errors;

		if($this->constrainform != ''){

			echo '<div class="row"><div class="' . $this->constrainform . '">';
		}

	}

	public function fill($values)
	{

		if(is_array($values)){

			$array = $values;

		}elseif(is_object($values)){

			$array  = $values->toArray();
		
		}else{

			return;
		}

		foreach($array as $key => $value){

			if(old($key)){

				$array[$key] = old($key);
			}
		}
	
		$this->defaults = $array;

	}

	public function open($arguments = [], $fill = false){

		$args = [

			'action' => url()->current(),
			'id' => 'entryform',
			'method' => 'POST',
			'class' => ''

		];

		echo '<form ' . $this->parse($args, $arguments) . '>';

		if($this->csrf){

			echo csrf_field();

		}

		if($fill){

			$this->fill($fill);

		}

		echo "\n";

		if($this->inlinelist){

			echo '<ul class="list-inline mb-0">';

			echo "\n";

		}

		$this->openform = true;

	}

	public function newinline()
	{

		if($this->inlinelist){

			echo '</ul><ul class="list-inline mt-3">';

		}

	}

	public function newli($value = '')
	{

		if($this->inlinelist && $value != ''){

			echo '<li class="list-inline-item">' . $value . '</li>';

		}

	}

	public function close(){

		if($this->inlinelist){

			echo '</ul>';

			echo "\n";

		}

		if($this->openform){

			echo '</form>' . "\n";

		}

		if($this->constrainform != ''){

			echo '</div></div>';
		}

	}

	public function hidden($name, $value, $id = ''){

		if($id == ''){

			$id = $name;
		}

		echo '<input type="hidden" name="' . $name . '" value="' . $value . '" id="' . $id . '">';
	}

	public function build($type, $label, $name = '', $cfgs = []){

		// Text Area Minimum

		if($name == '' && $type != 'show'){

			$name = md5(rand() . time());
		}

		$cfg = [

			'fieldonly' => $this->fieldonly,
			'blockhelp' => '',
			'echo' => $this->echo,
			'size' => $this->size,
			'class' => '',
			'horizontal' => $this->horizontal,
			'horizontalleft' => $this->horizontalleft,
			'horizontalright' => $this->horizontalright,
			'labelclass' => $this->labelclass,
			'required' => false,
			'default' => '',
			'selectoptions' => [],
			'selectblankfirst' => false,
			'selectshortcut' => '',
			'checkboxvalues' => [], // [[name, label, value]],
			'checkboxmulti' => false,
			'testmode' => false,
			'dateparams' => [],
			'attrs' => [],
			'viewmode' => $this->viewmode,
			'last' => false,
			'html' => '',
			'datepickertoday' => false, 
			'datepickerclear' => true,
			'datepickercfg' => [],
			'textareamin' => 100,
			'textarearows' => 5,
			'switchon' => $this->switchon,
			'switchoff' => $this->switchoff,
			'formgroupclass' => $this->formgroupclass,
			'groupmb' => 'mb-2',
			'requiredappend' => $this->requiredappend,
			'requiredprepend' => $this->requiredprepend,
			'requiredlabelclass' => $this->requiredlabelclass,
			'readonly' => false,
			'fileshow' => true,
			'fileremove' => true,
			'fileassetid' => 0

		];

		if($type == 'datepicker'){

			$datepickername = $name;
			$name = $name . 'display';
		}

		$attrs = [

			'id' => strtolower($name),
			'tabindex' => $this->tabindex,
			'placeholder' => ''

		];	

		$this->tabindex++;

		if($type == 'datepicker'){

			if(array_key_exists($datepickername, $this->defaults)){

				$cfg['default'] = $this->defaults[$datepickername];
			}

		}else{

			$namearray = explode("-", $name);

			$temp = $namearray[0];

			if(array_key_exists($temp, $this->defaults)){

				if(is_array($this->defaults[$temp])){

					if(array_key_exists(1, $namearray)){ // Json Group

						if(array_key_exists($namearray[1], $this->defaults[$temp])){

							$tempkey = $namearray[1];

							$a = $this->defaults[$temp][$tempkey];

							$cfg['default'] = $a;

						}else{

							$cfg['default'] = '';
						}

					}else{

						$cfg['default'] = $this->defaults[$temp];

					}

					
				}else{

					$cfg['default'] = $this->defaults[$temp];
			

				}
			}

		}

		$fieldattributes = [];

		foreach($cfgs as $key => $value){

			if(array_key_exists($key, $attrs)){

				$attrs[$key] = $value;
			}

			if(array_key_exists($key, $cfg)){

				$cfg[$key] = $value;
			}

			if($key == 'attrs' && is_array($value)){

				if($this->inlinelist){

					if(!array_key_exists('style', $value)){

						$value['style'] = '';
					}

					$value['style'] .= ' width: auto;';

				}	

				if($type == 'textarea'){

					if(!array_key_exists('style', $value)){

						$value['style'] = '';
					}

					$value['style'] .= ' min-height: ' . $cfg['textareamin'] . 'px;';

				}

				foreach($value as $akey => $avalue){

					$fieldattributes[] = $akey . '="' . $avalue . '"';

				}

			}

		}

		if($type == 'select' && $cfg['readonly']){

			$fieldattributes[] = 'name="' . $name . '_readonly"';

		}else{

			$fieldattributes[] = 'name="' . $name . '"';

		}	

		if($type == 'datepicker'){


			if(old($datepickername)){

				$cfg['default'] = old($datepickername);
			}

		}else{

			if(old($name)){

				$cfg['default'] = old($name);
			}

		}
		

		if($this->inlinelist){

			$cfg['fieldonly'] = true;

		}

		foreach($attrs as $key => $value){

			$fieldattributes[] = $key . '="' . $value . '"';
		}

		$echo = true;

		ob_start();

		if(!$cfg['fieldonly']){

			echo '<div id="' . $attrs['id'] . '-div">';

		}

		if(!$cfg['fieldonly']){

			$horizontal = '';
			$horizontalleft = '';
			$horizontalright = '';

			if($cfg['horizontal']){

				$horizontal = 'row';

				if($this->viewmode){

					$horizontalleft = $cfg['horizontalleft'] . ' view-form-label';

				}else{

					$horizontalleft = $cfg['horizontalleft'] . ' col-form-label text-nowrap';
				
				}

				$horizontalright = $cfg['horizontalright'];
			}

			if($this->viewmode){

				$horizontal .= ' mb-0';

				echo '<div class="row ' . $cfg['formgroupclass'] . '">';

			}elseif($this->compact){

				switch($type){

					case "textarea":
						$horizontal .= ' mb-2';
						break;
					case "show":
						$horizontal .= ' mb-2';
						$horizontalright .= ' pt-1';
						break;
					case "switch":
					case "checkbox":
					case "checkbox-inline":
						$horizontal .= ' mb-2';
						$horizontalright .= ' pt-1';
					case "button":
					case "submit":

						if($cfg['formgroupclass'] == '') $cfg['formgroupclass'] = 'mt-2 mb-2';

						break;
					default: 
						$horizontal .= ' mb-2';
						break;
				}

				echo '<div class="form-group ' . $horizontal . ' ' . $cfg['formgroupclass'] . '">';

				
			}

			

			$labeltext = $label;

			if(in_array($type, ['button', 'submit'])){

				$labeltext = '';
			}

			if($cfg['required'] && $cfg['requiredappend'] != ''){

				$labeltext .= $cfg['requiredappend'];
			}

			if($cfg['required'] && $cfg['requiredprepend'] != ''){

				$labeltext = $cfg['requiredprepend'] . $labeltext;
			}

			if($cfg['required'] && $cfg['requiredlabelclass'] != ''){

				$cfg['labelclass'] .= ' ' . $cfg['requiredlabelclass'];
			}

			if($this->viewmode){

				echo '<div class="' . $horizontalleft . ' ' . $cfg['labelclass'] . '">' . $labeltext . '</div>';

			}else{

				echo '<label for="' .  $attrs['id'] . '" class="' . $horizontalleft . ' ' . $cfg['labelclass'] . '">' . $labeltext . '</label>';

			}

			if($cfg['horizontal']){

				echo '<div class="' . $horizontalright . '">';
			}

		}

		$required = '';

		if($cfg['required']){

			$required = 'required';
		}

		$readonly = '';

		if($cfg['readonly']){

			$required = '';
			$readonly = 'readonly';
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

		if($this->inlinelist){

			echo '<li class="list-inline-item align-top mb-2">';

		}elseif($this->viewmode){

			echo '<div class="">';

		}

		switch($type){

			case 'text':
			case 'email':
			case 'password':
			case 'number':
			case 'phone':

				if($type == 'phone'){

					$cfg['default'] = formatphone($cfg['default']);

				}

				if($this->viewmode){

					echo $cfg['default'];


				}else{

				
					echo '<input type="' . $type . '" class="form-control ' . $this->size . ' ' . $cfg['class'] . '" ' . implode(' ', $fieldattributes) . ' aria-describedby="' .  $attrs['id'] . 'Help" ' . $required . ' ' . $readonly . ' value="' . $cfg['default'] . '">';

					echo $errorfeedback;
    
				}

				break;
			case 'file':

				if($this->viewmode){

					//echo $cfg['default'];


				}else{

				
					echo '<input type="' . $type . '" class="form-control-file ' . $this->size . ' ' . $cfg['class'] . ' pl-0" ' . implode(' ', $fieldattributes) . ' aria-describedby="' .  $attrs['id'] . 'Help" ' . $required . '>';

					echo $errorfeedback;

					if($cfg['fileshow'] == 'image' && $cfg['fileassetid'] > 0){

						$imageurl = akiasseturl($cfg['fileassetid']);

						echo '<a href="' . $imageurl . '" target="_blank"><img src="' . akiasseturl($cfg['fileassetid'], 'tn') . '" class="img-fluid my-2"></a>';

					}elseif($cfg['fileshow'] == 'file' && $cfg['fileassetid'] > 0){

						$fileurl = akiasseturl($cfg['fileassetid']);

						echo '<a href="' . $fileurl . '" target="_blank" class="btn btn-sm btn-outline-primary my-2">Download File</a>';

					}

					if($cfg['fileremove'] && $cfg['fileassetid'] > 0){

						echo '<div class="mt-2"><input type="checkbox" name="removeasset' . $attrs['id'] . '" value="1"> Remove on save</div>';
					}
    
				}

				break;

			case 'plaintext':

				if($this->viewmode){

					echo $name;
				
				}else{

					echo '<input type="text" readonly class="form-control-plaintext" id="plaintext' . Str::slug($name, '') . '" value="' . $name . '">';

				}

				break;

			case 'show':

				echo '<div class="mt-0">';

				if($cfg['html'] != ''){

					echo $cfg['html'];

				}else{

					echo $name;
				}

				echo '</div>';

				break;

			case 'textarea':

				if($this->viewmode){

					echo $cfg['default'];

				}else{

					echo '<textarea class="form-control ' . $this->size . ' ' . $cfg['class'] . '" ' . implode(' ', $fieldattributes) . ' rows="' . $cfg['textarearows'] . '" aria-describedby="' .  $attrs['id'] . 'Help" ' . $required . ' ' . $readonly . '>' . $cfg['default'] . '</textarea>';
	    
					echo $errorfeedback;

				}

				break;

			case 'select':

				switch($cfg['selectshortcut']){

					case "yesno":
						$cfg['selectoptions'] = [1 => 'Yes', 0 => 'No'];
						break;

					case "noyes":
						$cfg['selectoptions'] = [0 => 'No', 1 => 'Yes'];
						break;

				}

				if($this->viewmode){

					if($cfg['default'] == '') $cfg['default'] = 0;

					if(array_key_exists($cfg['default'], $cfg['selectoptions'])){

						$a = $cfg['selectoptions'];

						echo $a["$cfg[default]"];
					
					}else{

						echo '';
					}

				}else{

					if($readonly == 'readonly'){

						$readonly = 'disabled';

						echo '<input type="hidden" name="' . $name . '" value="' . $cfg['default'] . '">';
					}

					echo '<select class="form-control ' . $this->size . ' ' . $cfg['class'] . '" ' . implode(' ', $fieldattributes) . ' aria-describedby="' .  $attrs['id'] . 'Help" ' . $required . ' ' . $readonly . '>';

					

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

				}

				break;

			case 'dateselect':

				if($this->viewmode || $readonly == 'readonly'){

					echo outdate($cfg['default']);

				}else{

					echo dateselect($name, $cfg['dateparams'] + ['default' => $cfg['default'], 'size' => $cfg['size']]);

				}

				break;

			case 'datepicker':

				$dpcfgs = [

					'yearstart' => date("Y"),
					'yearend' => date("Y") + 5,
					'startrange' => '',
					'endrange' => '',
					'exclude' => '',
					'datepickerformat' => 'd/m/Y'

				];

				$dpcfg = array_merge($dpcfgs, $cfg['datepickercfg']);

				if($this->viewmode || $readonly == 'readonly'){

					echo outdate($cfg['default'], $dpcfg['datepickerformat']);

				}else{

					$mbclass = 'mb-3';

					if(!$cfg['fieldonly']){

						$mbclass = '';
					}


					echo '<div class="form-row ' . $mbclass . '">';

					echo '<div class="col-auto">';	

					echo '<div class="input-group">';

					echo '<input type="' . $type . '" class="akidpdisplay form-control ' . $this->size . ' ' . $cfg['class'] . '" ' . implode(' ', $fieldattributes) . ' aria-describedby="' .  $attrs['id'] . 'Help" ' . $required . ' value="' . outdate($cfg['default'], $dpcfg['datepickerformat']) . '" style="background-color: #FFF;" data-target="' . $datepickername .'" readonly>';

					echo '<input type="hidden" name="' . $datepickername . '" id="' . $datepickername . '" value="' . $cfg['default'] . '"';

					foreach($dpcfg as $dpkey => $dpvalue){

						echo ' data-' . $dpkey . '="' . $dpvalue . '"';
					}

					echo ' data-title="' . $label . '">';

					echo '<div class="input-group-append">';

					echo '<button type="button" class="btn btn-secondary btn-sm akidppicker" data-target="' . $datepickername .'"><i class="fa fa-calendar"></i></button>';

					echo '</div>';

					if($cfg['datepickerclear']){

						echo '<div class="input-group-append">';

						echo '<button type="button" class="btn btn-outline-secondary btn-sm akidpclear" data-target="' . $datepickername . '"><i class="fa fa-times"></i></button>';

						echo '</div>';

					}

					if($cfg['datepickertoday']){

						echo '<div class="input-group-append">';

						echo '<button type="button" class="btn btn-outline-secondary btn-sm akidptoday" data-target="' . $datepickername . '" data-display="' . date($dpcfg['datepickerformat']) . '" data-sql="' . date("Y-m-d") . '">TODAY</button>';

						echo '</div>';

					}

					echo '</div>';

					



					echo $errorfeedback;

					echo '</div>';

					echo '</div>';

				}

				break;

			case 'checkbox':
			case 'checkbox-inline':
			case 'switch':


				$controlclass = 'form-check-input';
				$labelclass = 'form-check-label';

				//$fieldattributes = unset($fieldattributes['id']);
				//$fieldattributes = unset($fieldattributes['name']);

				$array = $cfg['checkboxvalues'];

				foreach($array as $a){

					$cfg['default'] = 0;

					if(array_key_exists($a[0], $this->defaults)){

						$cfg['default'] = $this->defaults["$a[0]"];
					}

					if(old($a[0])){

						$cfg['default'] = old($a[0]);
					}

					$checked = '';

					if($this->viewmode){

						echo '<div class="view-form-label">';

					}elseif($type == 'checkbox-inline'){

						echo '<div class="form-check form-check-inline ' . $cfg['groupmb'] . '">';

					}elseif($type == 'switch'){

						echo '<div class="custom-control custom-switch ' . $cfg['groupmb'] . '">';

						$controlclass = 'custom-control-input';
						$labelclass = 'custom-control-label';

					}else{

						echo '<div class="form-check">';
					}

					$value = 1;

					if(array_key_exists(2, $a)){

						$value = $a[2];
					}

			

					if(is_array($cfg['checkboxmulti'])){

						if(in_array($value, $cfg['checkboxmulti'])){

							$checked = 'checked';
						}


					}else{

						if($cfg['default'] == $value){

							$checked = 'checked';

						
						}

					}


					$name = $a[0];
					$id = $name;

					if($this->errors->has($name)){

						$cfg['class'] .= ' is-invalid';

						$errorfeedback = '<div class="invalid-feedback">
				          ' . $this->errors->first($name) . '
				        </div>';
					}

					if(is_array($cfg['checkboxmulti'])){

						$name = $name . '[]';
						$id = $id . $value;
					}

					if($this->viewmode){

						echo '<ul class="list-inline mb-0">';

						echo '<li class="list-inline-item mb-2">';

						if($checked == 'checked'){

							echo $cfg['switchon'];

						}else{

							echo $cfg['switchoff'];
						}

						echo '</li>';

						echo '<li class="list-inline-item mb-2">';

						echo $a[1];

						echo '</li>';						

						echo '</ul>';

					}else{

						echo '<input class="' . $controlclass . ' ' . $cfg['class'] . '" type="checkbox" name="' . $name . '" id="' . $id . '" tabindex="' . $this->tabindex . '" value="' . $value . '" ' . $checked . ' ' . implode(' ', $fieldattributes) . ' ' . $readonly . '>
  					<label class="' . $labelclass . '" for="' . $id . '">' . $a[1];

  					}

  					if($cfg['blockhelp'] != '' && $cfg['fieldonly']){

						echo '<div style="block"><small id="' . $attrs['id'] . 'Help" class="form-text text-muted">' . $cfg['blockhelp'] . '</small></div>';

					}

  					echo '</label>';

  					echo '</div>';

  					$this->tabindex++;

  				}

  				echo $errorfeedback;


				break;

			case 'radio':
			case 'radio-inline':

				$controlclass = 'form-check-input';
				$labelclass = 'form-check-label';

				//$fieldattributes = unset($fieldattributes['id']);
				//$fieldattributes = unset($fieldattributes['name']);

				$array = $cfg['checkboxvalues'];

				foreach($array as $a){

					if(old($a[0])){

						$cfg['default'] = old($a[0]);
					}

					$checked = '';

					if($this->viewmode){

						echo '<div>';

					}elseif($type == 'radio-inline'){

						echo '<div class="form-check form-check-inline">';

					}else{

						echo '<div class="form-check">';
					}

					$value = $a[0];

					if($cfg['default'] == $value){

						$checked = 'checked';
					}

					if($this->viewmode){

						echo '<ul class="list-inline mb-0">';

						echo '<li class="list-inline-item mb-2">';

						if($checked == 'checked'){

							echo $cfg['switchon'];

						}else{

							echo $cfg['switchoff'];
						}

						echo '</li>';

						echo '<li class="list-inline-item mb-2">';

						echo $a[1];

						echo '</li>';						

						echo '</ul>';

					}else{


						echo '<input class="' . $controlclass . '" type="radio" name="' . $name . '" id="' . $name . $a[0] . '" tabindex="' . $this->tabindex . '" value="' . $value . '" ' . $checked . ' ' . $readonly . '>
	  					<label class="' . $labelclass . '" for="' . $name . $a[0] . '">' . $a[1];

					}


  					if($cfg['blockhelp'] != '' && $cfg['fieldonly']){

						echo '<br><small id="' . $attrs['id'] . 'Help" class="form-text text-muted">' . $cfg['blockhelp'] . '</small>';

					}

  					echo '</label>';

  					echo '</div>';

  					$this->tabindex++;

  				}


				break;

			case 'button':
			case 'submit':

				$size = '';

				switch($cfg['size']){

					case "form-control-lg":
						$size = 'btn-lg';
						break;
					case "form-control-sm":
						$size = 'btn-sm';
						break;
				}

				if($cfg['class'] == ''){

					$cfg['class'] = 'btn-primary';
				}

				if(!$this->viewmode){

					echo '<button type="' . $type . '" class="btn ' . $size . ' ' . $cfg['class'] . '" id="' . $attrs['id'] . '" ' . implode(' ', $fieldattributes) . '>' . $label . '</button>';

				}else{

					$echo = false;
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

		if($this->inlinelist){

			echo '</li>';

		}elseif($this->viewmode){

			echo '</div>';

			if(!$cfg['last'] && !in_array($type, ['switch', 'radio', 'radio-inline', 'checkbox', 'checkbox-inline'])){

				echo $this->divider;

			}

		}

		if(!$cfg['fieldonly']){

			echo '</div>';

		}

		$output = ob_get_contents();

		ob_end_clean();

		if($echo){

			echo $output;

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

	public static function datepickerjs()
	{

echo <<<EOT

			<!-- Modal -->
			<div class="modal" id="akidatepickermodal" tabindex="-1" role="dialog" aria-labelledby="akidatepickerTitle" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="akidatepickerTitle"></h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div id="akidatepickerbody" class="modal-body">
EOT;
	
				

echo <<<EOT
			      </div>
		
			    </div>
			  </div>
			</div>

EOT;

			?>

			<script type="text/javascript">
          
            function akidpload(target)
            {

                var formData = new FormData($('#akidpform')[0]);

                var $target = $('#' + target);

                formData.append('target', target);
                formData.append('value', $target.val());
                formData.append('default', $target.val());
                formData.append('yearstart', $target.data('yearstart'));
				formData.append('yearend', $target.data('yearend'));
				formData.append('startrange', $target.data('startrange'));
				formData.append('endrange', $target.data('endrange'));
				formData.append('exclude', $target.data('exclude'));
				formData.append('datepickerformat', $target.data('datepickerformat'));

                $.ajax({

                    url: '<? echo route('akidatepickercalendar'); ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    
                    success: function(result){

                    	$('#akidatepickerTitle').html($target.data('title'));

                        $('#akidatepickerbody').html(result);

                        $('#akidatepickermodal').modal('show');

                    }

                });

            }

            function akidploadselect(date)
            {

                var formData = new FormData($('#akidpform')[0]);

                formData.append('value', date);

                $.ajax({

                    url: '<? echo route('akidatepickercalendar'); ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    
                    success: function(result){

                        $('#akidatepickerbody').html(result);

                    }

                });

            }



          (function(){

          	$(document).on('click', '.akidptoday', function(){

          		target = $(this).data('target');
          		display = $(this).data('display');
          		sql = $(this).data('sql');

          		$('#' + target + 'display').val(display);
          		$('#' + target).val(sql);

          	});

          	$(document).on('click', '.akidpclear', function(){

          		target = $(this).data('target');
        

          		$('#' + target + 'display').val('');
          		$('#' + target).val('');

          	});
          
            $(document).on('click', '.akidpprevnext', function(el){

                akidploadselect($(this).val());

            });

            $(document).on('change', '.akidptrigger', function(el){

                akidploadselect($('#akidpyear').val() + '-' + $('#akidpmonth').val() + '-01');

            });

            $(document).on('click', '.akidpdisplay', function(el){

                akidpload($(this).data('target'));

            });

            $(document).on('click', '.akidppicker', function(el){

                akidpload($(this).data('target'));

            });

            $(document).on('click', '.akidpset', function(el){

            	$this = $(this);

            	target = $this.data('target');
            	display = $this.data('display');
            	sql = $this.data('sql');

            	$('#' + target).val(sql);
            	$('#' + target + 'display').val(display);

            	$('#akidatepickermodal').modal('hide');

            });


          
          })();

        </script>

			<?

	}

	public static function lightboxjs($method = 'POST', $params = [])
	{

		$scrollable = '';
		$scroll = 'N';

		extract($params);
		
		if($scroll == 'Y'){

			$scrollable = 'modal-dialog-scrollable';
		}

		// Fixed Modal 
		
		echo <<<EOT

		<div class="modal fade" id="akilightbox" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
		  <div class="modal-dialog modal-xl {$scrollable}" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		         <h4><div id="akilightboxloading">
		        		
		        		<i class="fas fa-spinner fa-spin fa-lg"></i> LOADING
		        </div>
		    </h4>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div id="akilightboxbody" class="modal-body">
		      
		      </div>
		      
		    </div>
		  </div>
		</div>

		<script type="text/javascript">
			
		$('#akilightbox').on('show.bs.modal', function (event) {

			var button = $(event.relatedTarget) // Button that triggered the modal

			var target = button.data('url');

			$('#akilightboxloading').removeClass('d-none');

			$.ajax({

				url: target,
				data: { asset : button.data('asset') },
				type: '{$method}',
				success: function(result){

					$('#akilightboxbody').html(result);

					$('#akilightboxloading').addClass('d-none');

				}

			});

		})

		</script>


EOT;

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