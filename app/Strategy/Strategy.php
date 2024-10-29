<?php


namespace App\Strategy;


use Illuminate\Support\Facades\DB;

class Strategy
{
    protected function includeOrder($query, $body = null)
    {
        if (array_key_exists('include', $body)) {
            foreach ($body['include'] as $include => $value) {
                //  $value = mb_strtolower($value);
                $query = $query->with("{$value}");
            }
        }
        return $query;
    }

    protected function filter($query, $body = null)
    {
        if (array_key_exists('filter', $body)) {
            if (is_string($body['filter'])) {
                $body['filter'] = json_decode($body['filter']);
            }
            foreach ($body['filter'] as $filter => $value) {
                if ($value !== true && $value !== false){
                    $value = mb_strtolower($value);
                    $value = iconv('UTF-8', 'ASCII//TRANSLIT', $value);
                }
                $value = empty($value) ? null : $value;
                if (strstr($filter, '.')) {
                    $filter = explode('.', $filter);
                    if (count($filter) > 2) {
                        $aux = end($filter);
                        array_pop($filter);
                        $relationshipsToNavigate = implode('.', $filter);
                        unset($filter);
                        $filter[0] = $relationshipsToNavigate;
                        $filter[1] = $aux;
                    }
                    $query = $query->whereHas($filter[0], function ($query) use ($filter, $value) {
                        $query->where(DB::raw("lower(unaccent(cast({$filter[1]} as text)))"), 'like', "%{$value}%");
                    });
                } else if ($value === null) {
                    $query = $query->where($filter, null);
                } else if ($value === true || $value === false){
                  $query = $query->where($filter, $value);
                } else {
                    $query = $query->where(DB::raw("lower(unaccent(cast({$filter} as text)))"), 'like', "%{$value}%");
                }
            }
        }
        return $query;
    }

    public function find($id, $body = null, $columns = array('*'))
    {
        $query = $this->model;
        $query = $this->includeOrder($query, $body);
        return $query->find($id, $columns);
    }
}
