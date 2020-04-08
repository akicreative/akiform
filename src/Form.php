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
			'method' => 'POST'

		];

		echo '<form ' . $this->parse($args, $arguments) . '>';

		echo csrf_field();

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

		if($name == '' && $type != 'show'){

			$name = md5(rand() . time());
		}

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
			'datepickercfg' => []

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

		if(array_key_exists($name, $this->defaults)){

			$cfg['default'] = $this->defaults[$name];
		}

		if($type == 'show'){

			$fieldattributes = [];

		}else{

			$fieldattributes = ['name="' . $name . '"'];

		}	

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

				foreach($value as $akey => $avalue){

					$fieldattributes[] = $akey . '="' . $avalue . '"';

				}

			}

		}
		

		if(old($name)){

			$cfg['default'] = old($name);
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

			$horizontal = '';
			$horizontalleft = '';
			$horizontalright = '';

			if($cfg['horizontal']){

				$horizontal = 'row';
				$horizontalleft = $cfg['horizontalleft'] . ' col-form-label';
				$horizontalright = $cfg['horizontalright'];
			}

			if($this->viewmode){

				$horizontal .= ' mb-0';

			}elseif($this->compact){

				switch($type){

					case "textarea":
						$horizontal .= ' mb-2';
						break;
					case "show":
						$horizontal .= ' mb-1';
						$horizontalright .= ' pt-1';
						break;
					case "switch":
					case "checkbox":
					case "checkbox-inline":
						$horizontal .= ' mb-1';
						$horizontalright .= ' pt-1';
						break;
					default: 
						$horizontal .= ' mb-1';
						break;
				}

				
			}

			echo '<div class="form-group ' . $horizontal . '">';

			$labeltext = $label;

			if(in_array($type, ['button', 'submit'])){

				$labeltext = '';
			}

			echo '<label for="' .  $attrs['id'] . '" class="' . $horizontalleft . ' ' . $cfg['labelclass'] . '">' . $labeltext . '</label>';

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

		if($this->inlinelist){

			echo '<li class="list-inline-item">';

		}elseif($this->viewmode){

			echo '<div class="pt-2">';

		}

		switch($type){

			case 'text':
			case 'email':
			case 'password':
			case 'number':

				if($this->viewmode){

					echo $cfg['default'];


				}else{

				
					echo '<input type="' . $type . '" class="form-control ' . $this->size . ' ' . $cfg['class'] . '" ' . implode(' ', $fieldattributes) . ' aria-describedby="' .  $attrs['id'] . 'Help" ' . $required . ' value="' . $cfg['default'] . '">';

					echo $errorfeedback;
    
				}

				break;
			case 'file':

				if($this->viewmode){

					//echo $cfg['default'];


				}else{

				
					echo '<input type="' . $type . '" class="form-control-file ' . $this->size . ' ' . $cfg['class'] . ' pl-0" ' . implode(' ', $fieldattributes) . ' aria-describedby="' .  $attrs['id'] . 'Help" ' . $required . '>';

					echo $errorfeedback;
    
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

					echo '<textarea class="form-control ' . $this->size . ' ' . $cfg['class'] . '" ' . implode(' ', $fieldattributes) . ' aria-describedby="' .  $attrs['id'] . 'Help" ' . $required . '>' . $cfg['default'] . '</textarea>';
	    
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

				}

				break;

			case 'dateselect':

				if($this->viewmode){

					echo outdate($cfg['default']);

				}else{

					echo dateselect($name, $cfg['dateparams'] + ['default' => $cfg['default'], 'size' => $cfg['size']]);

				}

				break;

			case 'datepicker':

				if($this->viewmode){

					echo outdate($cfg['default'], $cfg['datepickerformat']);

				}else{

					$dpcfgs = [

						'yearstart' => date("Y"),
						'yearend' => date("Y") + 5,
						'startrange' => '',
						'endrange' => '',
						'exclude' => '',
						'datepickerformat' => 'd/m/Y'

					];

					$dpcfg = array_merge($dpcfgs, $cfg['datepickercfg']);


					echo '<div class="form-row mb-3">';

					echo '<div class="col-auto">';	

					echo '<div class="input-group">';

					echo '<input type="' . $type . '" class="form-control ' . $this->size . ' ' . $cfg['class'] . '" ' . implode(' ', $fieldattributes) . ' aria-describedby="' .  $attrs['id'] . 'Help" ' . $required . ' value="' . outdate($cfg['default'], $dpcfg['datepickerformat']) . '" readonly>';

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

					if($type == 'checkbox-inline'){

						echo '<div class="form-check form-check-inline">';

					}elseif($type == 'switch'){

						echo '<div class="custom-control custom-switch">';

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

					if($this->viewmode){

						$checked .= ' disabled';
					}

					$name = $a[0];
					$id = $name;

					if(is_array($cfg['checkboxmulti'])){

						$name = $name . '[]';
						$id = $id . $value;
					}

					echo '<input class="' . $controlclass . ' ' . $cfg['class'] . '" type="checkbox" name="' . $name . '" id="' . $id . '" tabindex="' . $this->tabindex . '" value="' . $value . '" ' . $checked . '>
  					<label class="' . $labelclass . '" for="' . $id . '">' . $a[1];

  					if($cfg['blockhelp'] != '' && $cfg['fieldonly']){

						echo '<br><small id="' . $attrs['id'] . 'Help" class="form-text text-muted">' . $cfg['blockhelp'] . '</small>';

					}

  					echo '</label>';

  					echo '</div>';

  					$this->tabindex++;

  				}


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

					if($type == 'radio-inline'){

						echo '<div class="form-check form-check-inline">';

					}elseif($type == 'switch'){

						echo '<div class="custom-control custom-switch">';

						$controlclass = 'custom-control-input';
						$labelclass = 'custom-control-label';

					}else{

						echo '<div class="form-check">';
					}

					$value = $a[0];

					if($cfg['default'] == $value){

						$checked = 'checked';
					}

					if($this->viewmode){

						$checked .= ' disabled';
					}

					echo '<input class="' . $controlclass . '" type="radio" name="' . $name . '" id="' . $name . $a[0] . '" tabindex="' . $this->tabindex . '" value="' . $value . '" ' . $checked . '>
  					<label class="' . $labelclass . '" for="' . $name . $a[0] . '">' . $a[1];

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

			if(!$cfg['last']){

				echo $this->divider;

			}

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


	public function test($val)
	{

		echo "<pre>";
		print_r(akiformsprovinces());
		echo "</pre>";	

		echo $val;

	}


}

?>