<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ConfigRequest;

class ConfigController extends Controller
{

    public function config_view()
    {
        return view('Auth.config');
    }

    public function config(ConfigRequest $request)
    {
        try {
            $data = $request->validated();
            auth()->user()->update([
                'tenant_id' => auth()->user()->id,
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'temp_password' => null,
                'expires_at' => null,
                'temp_used' => true,
                'empresa' => $data['empresa']
            ]);

            return redirect()->route('home');
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function omitido()
    {        
        try {
            $user = auth()->user();
            $omited = omited($user->id);

            if($omited) return redirect()->route('home');                
            
            $user->update([
                'tenant_id' => auth()->user()->id,
                'expires_at' => now()->addWeek(),
            ]);

            return redirect()->route('home');
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
