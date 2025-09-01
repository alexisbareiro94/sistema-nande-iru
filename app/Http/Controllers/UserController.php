<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        try {
            $users = User::where(function ($query) use ($q) {
                $query->whereLike('name', "%{$q}%")
                    ->orWhereLike('ruc_ci', "%{$q}%");
            })
                ->whereNotIn('role', ['admin', 'caja'])
                ->get();

            return response()->json([
                'success' => true,
                'users' => $users,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request) {
        
    }
}
