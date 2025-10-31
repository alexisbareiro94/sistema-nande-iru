<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Events\NotificacionEvent;
use App\Models\{Notification, Venta, User};

class VentaRealizada implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public Venta $venta;
    public $tenantId;
    public function __construct(Venta $venta, $tenantId)
    {
        $this->venta = $venta;
        $this->tenantId = $tenantId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $admins = User::where('role', 'admin')
            ->where('tenant_id', $this->tenantId)
            ->get();
        
        foreach ($admins as $admin) {
            Notification::create([
                'titulo' => 'Nueva Venta',
                'tenant_id' => $admin->id,
                'mensaje' => 'Venta de: Gs. ' . moneda($this->venta->total) . ' Registrado',
                'is_read' => false,
                'user_id' => $admin->id,
                'color' => 'blue',
            ]);
        }

        NotificacionEvent::dispatch('Nueva Venta', 'Venta de: Gs.' . moneda($this->venta->total) . ' Registrado', 'blue', $this->tenantId);

        foreach ($this->venta->productos as $producto) {
            if ($producto->stock_minimo >= $producto->stock && $producto->tipo == 'producto') {
                foreach ($admins as $admin) {
                    Notification::create([
                        'titulo' => 'Stock Bajo',
                        'tenant_id' => $admin->id,
                        'mensaje' => "$producto->nombre: $producto->stock unidades",
                        'is_read' => false,
                        'user_id' => $admin->id,
                        'color' => 'yellow',
                    ]);
                }
                NotificacionEvent::dispatch('Stock Bajo', "$producto->nombre: $producto->stock unidades", 'yellow', $this->tenantId);
            }
        }
    }
}


