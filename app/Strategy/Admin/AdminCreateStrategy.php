<?php

namespace App\Strategy\Admin;

use App\Enums\Roles;
use App\Strategy\Strategy;
use App\Strategy\StrategyInterface;
use App\Traits\People\PeopleCreateUpdateTrait;
use App\Traits\RolePermissions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AdminCreateStrategy extends Strategy implements StrategyInterface
{
    use RolePermissions;
    use PeopleCreateUpdateTrait;

    public function __construct(protected $model)
    {
    }

    public function handle()
    {
        return $this->create(Request()->all());
    }

    public function create($request)
    {
        try {
            DB::beginTransaction();
            $roleIdAdmin = $this->getIdFromRole($request['company_id'],Roles::Admin->value);
            if (!$roleIdAdmin) {
                throw new \Exception(__('error_messages.no_role_admin_registred'), Response::HTTP_NOT_FOUND);
            }
            $person = [
                'taxpayer' => $request['taxpayer'],
                'name' => $request['name'],
                'email' => $request['email'],
                'nickname' => $request['nickname'] ?? explode(' ', trim($request['name']))[0],
                'password' => Hash::make($request['password'] ?? getenv('PASSWORD_DEFAULT')),
                'role_id' => $roleIdAdmin,
                'company_id' => $request['company_id'],
                'type' => Roles::Admin->value,
                'address_id' => $this->createUpdateAddress($request),
                'image_id' => $this->createUpdateImages($request),
            ];
            $person = $this->createUpdatePerson($person);
            if (!empty($request['phones'])) {
                $person->phones()->createMany($request['phones']);
            }
            $person->admin()->create([...$request['admin'],'company_id' => $person->company_id]);
            DB::commit();
            return $person->load('address');
        } catch (\Exception $e) {
            DB::rollBack();
            return $e;
        }
    }
}

