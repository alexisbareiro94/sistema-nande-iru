<?php

namespace App\View\Components;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Clientes extends Component
{
    /**
     * Create a new component instance.
     */
    public $clientes;
    public function __construct()
    {
        $this->clientes = User::where('activo', true)
            ->whereNotIn('role', ['admin', 'caja', 'personal'])
            ->where('tenant_id', tenant_id())
            ->orderByDesc('created_at')
            ->get();        
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.clientes', [
            'clientes' => $this->clientes, 
        ]);
    }
}
