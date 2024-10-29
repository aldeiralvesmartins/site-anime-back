<?php
/**
 * File: CompanyUpdateStrategy
 * Created by: divino
 * Created at: 24/11/2023
 */

namespace App\Strategy\Product;

use App\Strategy\Strategy;
use App\Strategy\StrategyInterface;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ProductCategoryStrategy extends Strategy implements StrategyInterface
{
    public function __construct(protected $model, protected $params = null)
    {
    }

    public function handle()
    {
        return (request()->method() === 'PATCH') ? $this->onOff() : $this->update(request()->all());
    }

    public function update(array $data)
    {
        try {
            $company = $this->model->find($this->params['id']);

            if ($company) {
                $company->update($data);
                return $company;
            }

            throw new \Exception('message.registry_not_found', Response::HTTP_NOT_FOUND);

        } catch (\Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

    public function onOff()
    {
        try {
            DB::beginTransaction();
            $company = $this->model->find($this->params['id']);

            if (!$company) {
                throw new \Exception('message.registry_not_found', Response::HTTP_NOT_FOUND);
            }

            $company->update(['active' => !$company->active]);

            DB::commit();

            return $company;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e;
        }
    }
}
