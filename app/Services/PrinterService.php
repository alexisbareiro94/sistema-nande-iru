<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PrinterService
{
    private string $printerServiceUrl;

    public function __construct()
    {
        // host.docker.internal apunta al host desde el contenedor
        $this->printerServiceUrl = 'http://host.docker.internal:3000';
    }

    public function print(string $data): bool
    {
        try {
            $response = Http::timeout(10)->post("{$this->printerServiceUrl}/print", [
                'data' => $data
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Error al imprimir: ' . $e->getMessage());
            return false;
        }
    }

    public function printRaw(string $data): bool
    {
        try {
            $response = Http::timeout(10)->post("{$this->printerServiceUrl}/print/raw", [
                'data' => $data
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Error al imprimir raw: ' . $e->getMessage());
            return false;
        }
    }

    public function status(): array
    {
        try {
            $response = Http::get("{$this->printerServiceUrl}/status");
            return $response->json();
        } catch (\Exception $e) {
            return [
                'available' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    // Para impresoras térmicas ESC/POS
    public function printReceipt(array $lines): bool
    {
        $escpos = "\x1B\x40"; // Inicializar impresora

        foreach ($lines as $line) {
            $escpos .= $line . "\n";
        }

        $escpos .= "\n\n\n"; // Feed de papel
        $escpos .= "\x1D\x56\x00"; // Cortar papel (si tiene)

        try {
            $response = Http::post("{$this->printerServiceUrl}/print/raw", [
                'data' => $escpos
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Error al imprimir recibo: ' . $e->getMessage());
            return false;
        }
    }
}
