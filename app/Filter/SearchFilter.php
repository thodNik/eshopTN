<?php

namespace App\Filter;

use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\Filters\Filter;

class SearchFilter implements Filter
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function __invoke($query, $value, string $property)
    {
        $searchTerm = $value;

        return $query
            ->where(function ($q) use ($searchTerm, $query) {
                $columns = $query->getConnection()->getSchemaBuilder()->getColumnListing($this->model->getTable());

                foreach ($columns as $column) {

                    $query->orWhere($column, 'LIKE', '%'.$searchTerm.'%');
                }
            });

    }
}
