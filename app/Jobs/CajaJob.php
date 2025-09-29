<?php

namespace App\Jobs;

use App\Events\CajaEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\{Caja, Notification, User};

class CajaJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public Caja $caja;
    public string $tipo;

    public function __construct(Caja $caja, string $tipo)
    {
        $this->caja = $caja;
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
                'titulo' => $this->tipo,
                'mensaje' => "Monto Cierre: Gs. " . moneda($this->caja->monto_cierre),
                'is_read' => false,
                'user_id' => $admin->id,
                'color' => 'green',
            ]);
        }
        if($this->tipo == 'Apertura de Caja'){
            CajaEvent::dispatch($this->tipo, "Monto Apertura: Gs. " . moneda($this->caja->monto_cierre), 'green');
        }else{
            CajaEvent::dispatch($this->tipo, "Monto Cierre: Gs. " . moneda($this->caja->monto_cierre), 'green');
        }
    }
}
