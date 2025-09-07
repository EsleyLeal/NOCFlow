<?php

namespace App\Http\Controllers;

use App\Models\Troubleshooting;
use Illuminate\Http\Request;

class TroubleshootingController extends Controller
{
    public function page(Request $request)
    {
        $q = $request->string('q');

        $query = Troubleshooting::query();
        if ($q->isNotEmpty()) {
            $query->where(function ($w) use ($q) {
                $w->where('title', 'like', "%{$q}%")
                  ->orWhere('description', 'like', "%{$q}%")
                  ->orWhere('steps', 'like', "%{$q}%");
            });
        }

        $items = $query->latest()->get();

        $stats = [
            'total'          => Troubleshooting::count(),
            'personalizados' => $items->count(), // ajuste depois se tiver flag
            'padrao'         => 0,
        ];

        return view('troubleshooting', compact('items', 'stats', 'q'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string',
            'description' => 'nullable|string',
            'steps'       => 'nullable|string', // 1 passo por linha
        ]);

        Troubleshooting::create($data);

        return back()->with('success', 'Troubleshooting adicionado!');
    }
}
