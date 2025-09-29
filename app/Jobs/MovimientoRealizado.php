<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\{MovimientoCaja, User, Notification};
use App\Events\NotificacionEvent;

class MovimientoRealizado implements ShouldQueue
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
        if ($this->movimiento->concepto == 'Apertura de caja') {            
            $color = $this->tipo == 'ingreso' ? 'green' : 'orange';
            foreach ($admins as $admin) {
                Notification::create([
                    'titulo' => 'Nueva Apertura de caja',
                    'mensaje' => "Monto de apertura: Gs." . moneda($this->movimiento->monto),
                    'is_read' => false,
                    'user_id' => $admin->id,
                    'color' => 'blue',
                ]);
            }
            NotificacionEvent::dispatch('Nueva Apertura de caja', "Monto de apertura: Gs." . moneda($this->movimiento->monto), 'blue');
        } else {            
            $color = $this->tipo == 'ingreso' ? 'green' : 'orange';
            foreach ($admins as $admin) {
                Notification::create([
                    'titulo' => 'Nuevo ' . ucfirst($this->tipo),
                    'mensaje' => ucfirst($this->tipo) . ' de: Gs. ' . moneda($this->movimiento->monto) . ' Registrado',
                    'is_read' => false,
                    'user_id' => $admin->id,
                    'color' => $color,
                ]);
            }
            NotificacionEvent::dispatch('Nuevo ' . ucfirst($this->tipo), ucfirst($this->tipo) . ' de: Gs. ' . moneda($this->movimiento->monto) . ' Registrado', $color);
        }
    }
}
