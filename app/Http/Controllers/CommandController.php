<?php

namespace App\Http\Controllers;

use App\Models\Command;
use Illuminate\Http\Request;

class CommandController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->string('q');

        $query = Command::query();
        if ($q->isNotEmpty()) {
            $query->where(function($w) use ($q) {
                $w->where('command','like',"%{$q}%")
                  ->orWhere('vendor','like',"%{$q}%")
                  ->orWhere('protocol','like',"%{$q}%")
                  ->orWhere('task','like',"%{$q}%")
                  ->orWhere('description','like',"%{$q}%");
            });
        }

        $commands = $query->latest()->paginate(50);
        $stats = [
            'total' => Command::count(),
            'results' => $commands->total(),
            'favorites' => Command::where('favorite', true)->count(),
        ];

        return view('index', compact('commands','stats','q'));
    }

    public function store(Request $request)
    {
        // seu form usa "device" pro fabricante; mapeamos para 'vendor'
        $data = $request->validate([
            'device' => 'required|string',  // Cisco/Huawei/Datacom...
            'protocol' => 'nullable|string',
            'task' => 'nullable|string',
            'command' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $payload = [
            'vendor' => $data['device'],
            'protocol' => $data['protocol'] ?? null,
            'task' => $data['task'] ?? null,
            'command' => $data['command'],
            'description' => $data['description'] ?? null,
        ];

        Command::create($payload);

        return back()->with('success', 'Comando adicionado!');
    }
}
