<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UpdatePersonalRequest;

class GestionUsersController extends Controller
{
    public function index_view()
    {
        $users = User::whereNot('role', 'admin')
            ->whereNot('role', 'cliente')
            ->get();

        return view('usuarios.index', [
            'users' => $users,
        ]);
    }

    public function index()
    {
        $users = User::whereNot('role', 'admin')
            ->whereNot('role', 'cliente')            
            ->get();

        return response()->json([
            'data' => $users,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'role' => 'required',
                'name' => 'required',
                'password' => 'required|min:8',
                'telefono' => 'required',
                'email' => 'required|email',
                'salario' => 'required|numeric',
                'activo' => 'required',
            ]);
            $validated['estado'] = true;
            User::create($validated);

            return back()->with('success', 'esta bien :D');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(string $id)
    {
        try {
            $user = User::whereNot('role', 'admin')
                ->whereNot('role', 'cliente')                
                ->where('id', $id)
                ->first();

            return response()->json([
                'success' => true,
                'data' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function update(UpdatePersonalRequest $request, string $id)
    {
        try {
            $data = $request->validated();            
            User::find($id)->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Usuario actualizado',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function delete(string $id)
    {
        try {
            User::destroy($id);
            return response()->json([
                'message' => 'Usuario eliminado',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}
