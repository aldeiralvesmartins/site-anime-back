<?php

namespace App\Strategy\Product;

use App\Strategy\Strategy;
use App\Strategy\StrategyInterface;

class ProductDeleteMultipleStrategy extends Strategy implements StrategyInterface
{
    public function __construct(protected $model)
    {
    }
    public function handle()
    {
        try {
        return $this->deleteMultiple(Request()->all());
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function deleteMultiple($request)
    {
        $this->model->whereIn('id', $request['ids'])->delete();
        return response()->json(['message' => 'Produtos Excluidos com Sucesso.'], 200);
    }
}
