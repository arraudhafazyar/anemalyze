<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Radiobutton extends Component
{
    public $label;
    public $name;
    public $options;
    public $selected;

    public function __construct($label, $name, $options = [], $selected = null)
    {
        $this->label = $label;
        $this->name = $name;
        $this->options = $options;
        $this->selected = $selected;
    }

    public function render()
    {
        return view('components.radiobutton');
    }
}
