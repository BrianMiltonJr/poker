<?php

namespace App\View\Components;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Table extends Component
{
    public array $columns;
    public Collection $data;
    public array $actions;
    public bool $hasActions;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $headers, Builder $query, Closure $dataMap)
    {
        $this->columns = $headers;
        $models = $query->get();
        $this->actions = [];
        $bindedDataMap = Closure::bind($dataMap, $this);

        $this->data = $models->map($bindedDataMap);
        $this->hasActions = count($this->actions) > 0;
    }

    public function addAction(int $row, string $title, string $route, string $color = 'blue')
    {
        if (! array_key_exists($row, $this->actions)) {
            $this->actions[$row] = [];
        }
        $this->actions[$row][] = [
            'title' => $title,
            'route' => $route,
            'color' => $color,
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.table')->with([
            'columns' => $this->columns,
            'data' => $this->data,
            'actions' => $this->actions,
            'hasActions' => $this->hasActions,
        ]);
    }
}
