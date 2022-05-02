<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

class Select extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $options, string $name, string $label = null)
    {
        $this->options = $options;
        $this->name = $name;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input.select')->with([
            'options' => $this->options,
            'name' => $this->name,
            'label' => $this->label,
        ]);
    }
}
