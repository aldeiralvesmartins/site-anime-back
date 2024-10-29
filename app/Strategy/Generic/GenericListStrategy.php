<?php

namespace App\Strategy\Generic;

use App\Strategy\Strategy;
use App\Strategy\StrategyInterface;

class GenericListStrategy extends Strategy implements StrategyInterface
{
    public function __construct(protected $model)
    {
    }

    public function handle()
    {
        try {
            return $this->list(Request()->all());
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function list($body = null)
    {
        $query = $this->model;
        $query = $this->includeOrder($query, $body);
        $query = $this->filter($query, $body);
        return $query->get(['name as label', 'id']);
    }
}
