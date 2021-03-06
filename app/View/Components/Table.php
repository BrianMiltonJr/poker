<?php

namespace App\View\Components;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Illuminate\View\Component;

class Table extends Component
{
    public array $columns;
    public array $searchableColumns;
    private Collection $data;
    public array $actions;
    public bool $hasActions;
    public array $headerActions;
    private LengthAwarePaginator $paginator;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        array $headers,
        Builder $query,
        Closure $dataMap,
        array $searchableColumns = [],
        string $tableIdentifier = 'page',
        int $rows = 15
    ) {
        $this->columns = $headers;
        $this->searchableColumns = $searchableColumns;
        $requestQuery = Request::query();

        if (array_key_exists('search', $requestQuery)) {
            $query = $this->laceSearchParams($requestQuery['search'], $searchableColumns, $query);
        }
        $models = $query->paginate($rows, ['*'], $tableIdentifier);
        $this->actions = [];
        $bindedDataMap = Closure::bind($dataMap, $this);

        $this->paginator = $models;
        $this->data = collect($models->items())->map($bindedDataMap);
        $this->hasActions = count($this->actions) > 0;
        $this->headerActions = [];
    }

    private function laceSearchParams(string $param, array $searchableColumns, Builder $query): Builder {
        foreach ($searchableColumns as $searchableColumn) {
            $query->where($searchableColumn, 'LIKE', "%$param%");
        }
        return $query;
    }

    public function addAction(int $row, string $title, string $route, string $color = 'gray')
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

    public function addHeaderAction(string $title, string $route, string $color = 'gray')
    {
        $this->headerActions[] = [
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
            'headerActions' => $this->headerActions,
            'paginator' => $this->paginator,
            'searchableColumns' => $this->searchableColumns,
        ]);
    }
}
