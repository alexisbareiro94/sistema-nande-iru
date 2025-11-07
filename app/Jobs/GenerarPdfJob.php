<?php

namespace App\Jobs;

use App\Events\NotificacionEvent;
use App\Events\PdfGeneradoEvent;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Barryvdh\DomPDF\Facade\Pdf;

class GenerarPdfJob implements ShouldQueue
{
    use Queueable;

    /**
     *       
     * Create a new job instance.
     */
    public $ventas;
    public $ingresos;
    public $egresos;
    public $userId;
    public $tenantId;

    public function __construct($userId, $ventas, $ingresos = null, $egresos = null, $tenantId)
    {
        $this->ventas = $ventas;
        $this->ingresos = $ingresos;
        $this->egresos = $egresos;
        $this->userId = $userId;                
        $this->tenantId = $tenantId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {        
            if($this->ingresos != null && $this->egresos != null){
                $pdf = Pdf::loadView('pdf.ventasE', [
                    'ventas' => $this->ventas,
                    'ingresos' => $this->ingresos,
                    'egresos' => $this->egresos,
                ]);
            }else{
                $pdf = Pdf::loadView('pdf.ventas', [
                    'ventas' => $this->ventas
                ]);
            }
            
            $path = public_path("reports/report.pdf");  
            $pdf->save($path);
            NotificacionEvent::dispatch('Reporte generado', 'Nuevo reporte generado', 'blue', $this->tenantId);
            Notification::create([
                'titulo' => 'Reporte Generado',
                'mensaje' => 'Nuevo reporte generado',
                'color' => 'blue',
                'user_id' => $this->userId,
                'is_read' => false,
                'tenant_id' => $this->tenantId,
            ]);            
            PdfGeneradoEvent::dispatch($this->userId, $path);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
