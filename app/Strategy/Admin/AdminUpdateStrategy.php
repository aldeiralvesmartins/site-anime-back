<?php

namespace App\Strategy\Admin;

use App\Strategy\Strategy;
use App\Strategy\StrategyInterface;
use App\Traits\People\PeopleCreateUpdateTrait;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class AdminUpdateStrategy extends Strategy implements StrategyInterface
{

    use PeopleCreateUpdateTrait;

    public function __construct(protected $model, protected $params = null)
    {
    }

    public function handle()
    {
        return (request()->method() === 'PATCH') ? $this->onOff() : $this->update(request()->all());
    }

    public function onOff()
    {
        try {
            DB::beginTransaction();
            $admin = $this->model->find($this->params['id'])->load('person');
            if (!$admin) {
                throw new \Exception('message.registry_not_found', Response::HTTP_NOT_FOUND);
            }
            $admin->person()->update(['active' => !$admin->person->active]);
            DB::commit();
            return $admin;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

    public function update($request)
    {
        try {
            DB::beginTransaction();
            $admin = $this->model->find($this->params['id'])->load('person');
            if ($admin) {
                $this->createUpdatePhones($request, $admin->person);
                $this->createUpdatePerson(['id' => $admin->person->id, ...$request,
                    'address_id' => $this->createUpdateAddressForceDelete($request, $admin->person)]);
                $admin->update($request['admin']);
                DB::commit();
                return $admin;
            }
            throw new \Exception('message.registry_not_found', Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            DB::rollBack();
            return $e;
        }
    }
}
