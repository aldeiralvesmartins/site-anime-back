<?php

namespace App\Models;

use App\Models\Scopes\CompanyScope;
use App\Services\CustomIdService;
use Illuminate\Database\Eloquent\Model as BaseModel;

abstract class Model extends BaseModel
{
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (in_array('company_id', $model->fillable)) {
                if (auth()->user()?->company_id) {
                    $model->attributes['company_id'] = auth()->user()?->company_id;
                }
            }
            if (in_array('id', $model->fillable)) {
                $model->id = CustomIdService::generateCustomId($model);
            }
            return $model;
        });
    }

    protected static function booted()
    {
        if (auth()->user()?->company_id) {
            static::addGlobalScope(new CompanyScope());
        }
    }

}
