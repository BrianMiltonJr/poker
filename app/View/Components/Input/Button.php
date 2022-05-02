<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

class Button extends Component
{
    public string $title;
    public string $route;
    public string $color;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $title, string $route, string $color = 'blue')
    {
        $this->title = $title;
        $this->route = $route;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input.button');
    }
}
