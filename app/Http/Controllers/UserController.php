<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Exception;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * TODO:SHOW method
     */
    public function __construct()
    {
        $this->init();
        $this->middlewareInit();
    }

    public function index(Request $request)
    {
       $users = [];
       if ($request->has('search'))
        {
            $search = $request->input('search');
            if ($search != '')
            {
                $users  = User::whereRoleIs('user')->where('name','like', '%' .$search. '%')
                                ->paginate(APP_PAGINATE);
            }
        }
       else
       {
           $users =  User::whereRoleIs('user')->paginate(APP_PAGINATE);
       }
       return $this->view(compact('users'));
    }

    public function create()
    {
        return $this->view();
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $this->init();
        try {
            $user = new User($request->all());

            if ($request->has('password'))
            {
                $user->password = bcrypt($request->password);
            }

            if ($user->save() == false)
            {
                throw new Exception('error',APP_ERROR);
            }
            $user->attachRole('user');
            $user->syncPermissions($request->permissions);
            $this->success('success_add');
            return redirect()->route('users.index');
        } catch (Exception $e)
        {
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->route('users.index');
        }
    }

    public function edit(User $user)
    {
        return $this->view(compact('user'));
    }

    public function update(UserRequest $request, user $user): RedirectResponse
    {
        $this->init();
        DB::beginTransaction();
        try
        {
            if ($user->update($request->all()) == false)
            {
                throw new Exception('error_update');
            }
            $user->syncPermissions($request->permissions);

            DB::commit();
            $this->success('success_update');
            return redirect()->route('users.index');
        } catch (Exception $e)
        {
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->route('users.index');
        }
    }

    public function destroy(User $user): RedirectResponse
    {
        try {
            if ($user->delete() == false)
            {
                throw new Exception('error_destroy',APP_ERROR);
            }

            $this->success('success_destroy');
            return redirect()->route('users.index');
        } catch (Exception $e)
        {
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->route('users.index');
        }
    }
}
