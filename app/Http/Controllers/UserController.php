<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->user->select(
            'id',
            'name',
            'login'
        )->orderBy('name', 'ASC')
        ->paginate(15);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $action = route('usuarios.store');
        $title  = 'Cadastro';

        return view('users.form', compact('action', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $data = $request->except(['_token', '_method']);
            $data = Arr::add($data, 'email_verified_at', now());

            $this->user->create($data);
        } catch (Exception $e) {
            return redirect()->route('usuarios.index')->with('error', 'Erro ao cadastradar usuário.');
        }
        return redirect()->route('usuarios.index')->with('success', 'Usuário cadastrado com sucesso.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = $this->user->find($id);
        $action = route('usuarios.update', $user->id);
        $title  = 'Edição';
        return view('users.form', compact('user', 'action', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = $this->user->find($id);
            $user_id = $user->id;
            $validator = Validator::make($request->all(), [
                'name' => 'bail|required|min:3|max:255',
                'password' => 'bail|required|min:8|max:20',
                'login' => ['bail','required','min:3','max:8', function ($attribute, $value, $fail) use ($user_id) {
                    if ($this->user->where('id', '<>', $user_id)->where('login', $value)->exists()) {
                        return $fail("Já existe um usuário com esse login cadastrado.");
                    }
                }],
            ]);

            if ($validator->fails()) {
                return redirect("usuarios/$user_id/edit")
                    ->withErrors($validator)
                    ->withInput();
            }

            $user->update($request->except(['_token', '_method']));

        } catch (Exception $e) {
            return redirect()->route('usuarios.index')->with('error', 'Erro ao editar o usuário.');
        }
        return redirect()->route('usuarios.index')->with('success', 'Usuário atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = $this->user->find($id);
            $user->delete();
        } catch (Exception $e) {
            return redirect()->route('usuarios.index')->with('error', 'Erro ao remover o usuário.');
        }
        return redirect()->route('usuarios.index')->with('success', 'Usuário removida com sucesso.');
    }
}
