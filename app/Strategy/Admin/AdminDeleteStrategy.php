<?php

namespace App\Strategy\People;

use App\Exceptions\Message;
use App\Models\Cid;
use App\Models\PeopleSpouse;
use App\Models\Resident;
use App\Strategy\Strategy;
use App\Strategy\StrategyInterface;
use Illuminate\Support\Facades\DB;

class AdminDeleteStrategy extends Strategy implements StrategyInterface
{

    public function __construct(protected $model, protected $params = null)
    {
    }

    public function handle()
    {
        $register = $this->model->find($this->params['id']);
        if (empty($register)) {
            return Message::getMessageRegistryNotFound();
        }
        if ($register->properties->count()) {
            return Message::getMessagePersonHasProperty();
        }
        try {
            DB::beginTransaction();
            $hasDeleted = $register->delete();
            DB::commit();
            if ($hasDeleted) {
                return Message::getMessageRegistryDeleted();
            }
        } catch (\Exception $e) {
            debug($e);
            DB::rollBack();
            return Message::getMessageRegistryNotFound();
        }

    }
}
