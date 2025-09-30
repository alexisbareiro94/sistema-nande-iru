<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificacionController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('all');
        if (filled($q)) {
            $items = Notification::orderByDesc('id')->get()->take($q);
            $notificaciones = $items->each(function ($not) {
                $not->update(['is_read' => true]);
            });

            return response()->json([
                'success' => true,
                'data' => $notificaciones,
                'count' => $notificaciones->count(),
            ]);
        } else {
            return response()->json([
                'success' => true,
                'notificaciones' => Notification::orderByDesc('id')->lazy()->take(3),
            ]);
        }
    }

    public function update(string $id)
    {
        try {
            Notification::find($id)->update(['is_read' => true]);

            return response()->json([
                'success' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
