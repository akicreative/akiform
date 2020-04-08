# akiform

This package is designed to create forms for Laravel / Bootstrap. 

This package is also being used to learn how to build packages so it is not expected to be used by general public and reliability can not be guaranteed.

## Use at your own risk.

# Installation

# Usage

## Initialization

```
$ar = new Akiform($errors, []);
```

### Arguments

var $errors = [];
var $tabindex = 1;
var $echo = true;
var $csrf = true;
var $horizontal = false;
var $horizontalleft = 'col-md-3';
var $horizontalright = 'col-md-9';
var $size = 'form-control-sm';
var $defaults = [];
var $constrainform = '';
var $inlinelist = false;
var $openform = false;
var $viewmode = false;

## Checkbox Switch

```
$ar->build('switch', 'Label', 'name', ['checkboxvalues' => [['test1', 'This is a test']]]);
```

## Date Picker

This date picker uses a Modal Pop up to show a calendar. 

```
$ar->build('datepicker', 'Label', 'name', []);
```

### Options

datepickertoday = [false]
datepickerclear = [true]

#### Configurations

```
$dpcfgs = [
	'yearstart' => date("Y"),
	'yearend' => date("Y") + 5,
	'startrange' => '',
	'endrange' => '',
	'exclude' => '',
	'datepickerformat' => 'd/m/Y'
];
```

### Include Class

You must include the class at the bottom of the page in the scripts section.

```
AkiForm::datepickerjs();
```


Coming soon.
