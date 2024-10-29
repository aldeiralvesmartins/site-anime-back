<?php

namespace App\Strategy\Generic;

use App\Strategy\Strategy;
use App\Strategy\StrategyInterface;

class GenericShowStrategy extends Strategy implements StrategyInterface
{
    public function __construct(protected $model = null, protected $params = null)
    {
    }

    public function handle()
    {
        try {
            return $this->find($this->params['id'], Request()->all());
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function find($id, $body = null, $columns = array('*'))
    {
        $query = $this->model;
        $query = $this->includeOrder($query, $body);
        return $query->find($id, $columns);
    }
}
