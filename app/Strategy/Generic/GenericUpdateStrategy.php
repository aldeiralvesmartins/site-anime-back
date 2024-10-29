<?php

namespace App\Strategy\Generic;

use App\Models\Image;
use App\Strategy\Strategy;
use App\Strategy\StrategyInterface;
use Symfony\Component\HttpFoundation\Response;

class GenericUpdateStrategy extends Strategy implements StrategyInterface
{
    public function __construct(protected $model = null, protected $params = null)
    {
    }

    public function handle()
    {
        try {
            return $this->update(Request()->all(), $this->params['id']);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function update(array $data, $id)
    {
            $product = $this->model->findOrFail($id);
            if ($product) {
            if (isset($data['image'])) {
                $image = Image::create(['image' => $data['image']]);
                $data['image_id'] = $image->id;
                if ($product->image_id) {
                    Image::destroy($product->image_id);
                }
            }

            $product->update([
                'name' => $data['name'],
                'code' => $data['code'],
                'quantity' => $data['quantity'],
                'price' => $data['price'],
                'description' => $data['description'],
                'inventoryStatus' => $data['inventoryStatus'],
                'rating' => $data['rating'],
                'category_id' => $data['category_id'],
                'company_id' => $data['company_id'],
            ]);
            return $product;
        }
        throw new \Exception('message.registry_not_found', Response::HTTP_NOT_FOUND);
    }
}
