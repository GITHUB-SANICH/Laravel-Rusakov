<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MyInput extends Component
{
	public $inputType;
	public $value;
    /**
     * Create a new component instance.
     */
    public function __construct($inputType = 'text', $value = 'значение из контроллера компанента')
    {
		$this->inputType = $inputType;
		$this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.my-input');
    }
}
