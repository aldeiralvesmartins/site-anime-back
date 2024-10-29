<?php

namespace App\Http\Controllers;

use App\Traits\ErrorMessages;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
    use ErrorMessages;

    protected string $basePathModel = "App\\Models\\";

    public function index()
    {
        $action = $this->strategy();

        if (is_a($action, '\Exception')) {
            return $this->errorResponse($action);
        }

        return response()->json($action);
    }

    public function show($id)
    {
        $action = $this->strategy(['id' => $id]);

        if (is_a($action, '\Exception')) {
            return $this->errorResponse($action);
        }

        return response()->json($action);
    }

    public function delete($id)
    {
        $action = $this->strategy(['id' => $id]);

        if (is_a($action, '\Exception')) {
            return $this->errorResponse($action);
        }

        return response()->json($action);
    }

    public function list()
    {
        $action = $this->strategy();

        if (is_a($action, '\Exception')) {
            return $this->errorResponse($action);
        }

        return response()->json($action);
    }

    protected function className()
    {
        $name = explode("\\", get_class($this));
        return $name[count($name) - 1];
    }

    protected function strategy(?array $params = null)
    {
        $action = substr(Route::currentRouteAction(), (strpos(Route::currentRouteAction(), '@') + 1));
        $instance = config("strategy.{$this->className()}.{$action}");
        if (!$instance) {
            return response()->json(['message' => 'Strategy Not Registred'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return app()->makeWith($instance, ['model' => $this->model(), 'params' => $params])->handle();
    }

    protected function model()
    {
        $name = str_replace('Controller', '', $this->className());
        $instance = $this->basePathModel . $name;
        return app()->make($instance);
    }
}
