<?php

namespace App\Jobs;

use App\Events\CierreCajaEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\{Caja, Notification, User};

class CierreCaja implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public Caja $caja;
    public function __construct(Caja $caja)
    {
        $this->caja = $caja;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            Notification::create([
                'titulo' => 'Cierre de Caja',
                'mensaje' => "Monto Cierre: Gs. " . moneda($this->caja->monto_cierre),
                'is_read' => false,
                'user_id' => $admin->id,
                'color' => 'green',
            ]);
        }
        CierreCajaEvent::dispatch('Cierre de Caja', "Monto Cierre: Gs. " . moneda($this->caja->monto_cierre), 'green');
    }
}
