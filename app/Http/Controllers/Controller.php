<?php

namespace App\Http\Controllers;

use App\helper\Language;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Exception;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $method;
    protected $controller;
    protected $IsInit = false;
    protected $lang;

    public function view(...$data)
    {
        $this->init();

        $data = count($data) ? $data[0] : $data;
        $data['lang']  = $this->lang;
        $data['title'] = 'title';
        $data['CSS']   = 'css'.DIRECTORY_SEPARATOR.$this->controller.DIRECTORY_SEPARATOR.$this->method.'.css';
        $data['js']    = 'js'.DIRECTORY_SEPARATOR.$this->controller.DIRECTORY_SEPARATOR.$this->method.'.js';

        return view($this->controller.'.'.$this->method,$data);
    }

    public function init()
    {
        if ($this->IsInit == false)
        {
            $path = Route::currentRouteAction();
            $path = explode('@',$path);
            $this->method = $path[1];
            $path = explode('\\',$path[0]);
            $this->controller = $path[count($path)-1];
            $this->controller = str_ireplace('Controller','',$this->controller);
            $this->controller = strtolower($this->controller);

            $this->lang = new Language($this->controller,$this->method);

            $this->IsInit = true;
        }
    }

    public function middlewareInit()
    {
        $this->middleware(['permission:'.$this->controller.'_read'])  ->only(['index','show']);
        $this->middleware(['permission:'.$this->controller.'_create'])->only(['create','store']);
        $this->middleware(['permission:'.$this->controller.'_update'])->only(['edit','update']);
        $this->middleware(['permission:'.$this->controller.'_delete'])->only('destroy');
    }

    protected function handleException(Exception $exception)
    {
        if ($exception->getCode() == APP_ERROR)
        {
            $message = $this->lang->text($exception->getMessage());
        }
        else
        {
            $message = $this->lang->text('error');
        }
        report($exception);
        return $message;
    }

    public function setSystemMessage($message)
    {
        session::flash('error' , $message);
    }
    public function success($message)
    {
        session::flash('success' , $this->lang->text($message));
    }
}
