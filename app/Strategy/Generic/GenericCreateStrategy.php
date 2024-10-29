<?php

namespace App\Strategy\Generic;

use App\Models\Image;
use App\Strategy\Strategy;
use App\Strategy\StrategyInterface;

class GenericCreateStrategy extends Strategy implements StrategyInterface
{
    public function __construct(protected $model)
    {
    }

    public function handle()
    {
        try {
            $request = Request()->all();
            $image = Image::create(['image' => $request['image']]);
            $product = $this->model->create([
                'name' => $request['name'] ?? null,
                'code' => $request['code'] ?? null,
                'quantity' => $request['quantity'] ?? null,
                'price' => $request['price'] ?? null,
                'description' => $request['description'] ?? null,
                'inventoryStatus' => $request['inventoryStatus'] ?? null,
                'rating' => $request['rating'] ?? null,
                'category_id' => $request['category_id'] ?? null,
                'company_id' => $request['company_id'] ?? null,
                'image_id' => $image->id,
            ]);
            if (isset($request['product_size'])) {
                $product->sizes()->createMany($request['product_size']);
            }
            return $product;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
