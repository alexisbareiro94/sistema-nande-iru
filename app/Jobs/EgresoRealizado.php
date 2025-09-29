<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\{MovimientoCaja, User, Notification};
use App\Events\NotificacionEvent;

class EgresoRealizado implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */

    public MovimientoCaja $movimiento;
    public string $tipo;

    public function __construct(MovimientoCaja $movimiento, string $tipo)
    {
        $this->movimiento = $movimiento;
        $this->tipo = $tipo;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            Notification::create([
                'titulo' => '',
                'mensaje' => 'Venta de: Gs. ' . moneda($this->movimiento->monto) . ' Registrado',
                'is_read' => false,
                'user_id' => $admin->id,
                'color' => 'blue',
            ]);
        }

        //NotificacionEvent::dispatch("Egreso: $movimiento->concepto", "Monto: Gs. ".  moneda($movimiento->monto),'yellow');
    }
}
