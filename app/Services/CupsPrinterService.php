<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class CupsPrinterService
{
    private string $cupsServer;
    private string $printerName;

    public function __construct()
    {
        // CUPS corre en el host
        $this->cupsServer = 'http://host.docker.internal:631';
        $this->printerName = config('printing.default_printer', 'POS58_RAW');
    }

    /**
     * Imprime contenido raw usando CUPS IPP
     */
    public function print(string $content, array $options = []): bool
    {
        try {
            // Usamos el comando lp a través del host
            // Alternativa: usar IPP directamente con biblioteca PHP
            $response = Http::post("{$this->cupsServer}/printers/{$this->printerName}", [
                'job-name' => $options['job_name'] ?? 'Laravel Print Job',
                'document-format' => 'application/octet-stream',
                'job-attributes' => [
                    'copies' => $options['copies'] ?? 1,
                ],
            ], [
                'body' => $content
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Error al imprimir con CUPS: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Alternativa: ejecutar comando lp en el host
     */
    public function printViaSsh(string $content): bool
    {
        // Esta opción requiere configurar SSH o usar un servicio intermediario
        // Por ahora, usaremos el servicio Express como puente
        return false;
    }

    /**
     * Verifica el estado de la impresora
     */
    public function getStatus(): array
    {
        try {
            $response = Http::get("{$this->cupsServer}/printers/{$this->printerName}");

            return [
                'available' => $response->successful(),
                'printer' => $this->printerName,
                'server' => $this->cupsServer
            ];
        } catch (\Exception $e) {
            return [
                'available' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Imprime un recibo para impresoras térmicas ESC/POS
     */
    public function printReceipt(array $lines, array $options = []): bool
    {
        $escpos = "\x1B\x40"; // Inicializar

        foreach ($lines as $line) {
            if (is_array($line)) {
                // Permite formateo: ['text' => '...', 'bold' => true, 'align' => 'center']
                if ($line['bold'] ?? false) {
                    $escpos .= "\x1B\x45\x01"; // Bold on
                }
                if (($line['align'] ?? '') === 'center') {
                    $escpos .= "\x1B\x61\x01"; // Center
                }
                $escpos .= $line['text'] . "\n";
                if ($line['bold'] ?? false) {
                    $escpos .= "\x1B\x45\x00"; // Bold off
                }
                if ($line['align'] ?? false) {
                    $escpos .= "\x1B\x61\x00"; // Left align
                }
            } else {
                $escpos .= $line . "\n";
            }
        }

        $escpos .= "\n\n\n"; // Feed
        $escpos .= "\x1D\x56\x00"; // Cortar papel

        return $this->print($escpos, $options);
    }
}
