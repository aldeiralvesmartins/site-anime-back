<?php

namespace App\Strategy\Generic;

use App\Strategy\Strategy;
use App\Strategy\StrategyInterface;
use Symfony\Component\HttpFoundation\Response;

class GenericDeleteStrategy extends Strategy implements StrategyInterface
{
    public function __construct(protected $model, protected $params = null)
    {
    }

    public function handle()
    {
        try {
            $register = $this->model->find($this->params['id']);
            if (empty($register)) {
                throw new \Exception('messages.registry_not_found', Response::HTTP_NOT_FOUND);
            }
            $register->delete();

            return ['message' => __('messages.excluded_item')];
        } catch (\Exception $e) {
            return $e;
        }
    }
}
