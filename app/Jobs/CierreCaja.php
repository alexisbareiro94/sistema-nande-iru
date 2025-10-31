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
    public $tenantId;
    public function __construct(Caja $caja, $tenantId)
    {
        $this->caja = $caja;
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
                'titulo' => 'Cierre de Caja',
                'mensaje' => "Monto Cierre: Gs. " . moneda($this->caja->monto_cierre),
                'is_read' => false,
                'user_id' => $admin->id,
                'color' => 'green',
                'tenant_id' => $this->tenantId,
            ]);
        }
        CierreCajaEvent::dispatch('Cierre de Caja', "Monto Cierre: Gs. " . moneda($this->caja->monto_cierre), 'green', $this->tenantId);
    }
}
