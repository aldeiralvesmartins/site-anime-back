<?php

namespace App\Strategy\Generic;

use App\Strategy\Strategy;
use App\Strategy\StrategyInterface;

class GenericIndexStrategy extends Strategy implements StrategyInterface
{

    public function __construct(protected $model = null)
    {
    }

    public function handle()
    {
        try {
            return $this->all(Request()->all());
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function all($body)
    {
        $query = $this->model;
        $query = $this->includeOrder($query, $body);
        $query = $this->filter($query, $body);
        return $query->paginate(env('APP_PAGINATE_DEFAULT', 15));
    }
}
