<?php

namespace App\Http\Controllers;

use App\Models\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class CommandController extends Controller
{
    public function index(Request $request)
    {
        $term       = trim($request->query('q', ''));
        $vendors    = (array) $request->query('vendor', []);
        $protocols  = (array) $request->query('protocol', []);
        $onlyFav    = (bool) $request->boolean('favorites'); // funciona sem login
        $sort       = $request->query('sort', 'recent');

        $query = Command::query();

        // busca
        if ($term !== '') {
            $like = "%{$term}%";
            $query->where(function ($w) use ($like) {
                $w->where('command', 'like', $like)
                  ->orWhere('vendor', 'like', $like)
                  ->orWhere('protocol', 'like', $like)
                  ->orWhere('task', 'like', $like)
                  ->orWhere('description', 'like', $like);
            });
        }

        // filtros
        if (!empty($vendors))   { $query->whereIn('vendor', $vendors); }
        if (!empty($protocols)) { $query->whereIn('protocol', $protocols); }

        // só favoritos (coluna booleana)
        if ($onlyFav && Schema::hasColumn('commands', 'favorite')) {
            $query->where('favorite', true);
        }

        // ordenação
        switch ($sort) {
            case 'used':
                if (Schema::hasColumn('commands', 'usage_count')) {
                    $query->orderByDesc('usage_count');
                    break;
                }
                // fallback -> recent
            case 'az':
                $query->orderBy('command');
                break;
            case 'vendor':
                $query->orderBy('vendor')->orderBy('command');
                break;
            default:
                $query->latest();
        }

        $commands = $query->paginate(50)->withQueryString();

        // stats
        $stats = [
            'total'     => Command::count(),
            'results'   => $commands->total(),
            'favorites' => Schema::hasColumn('commands', 'favorite')
                ? Command::where('favorite', true)->count()
                : 0,
        ];

        // a view já usa $cmd->favorite para pintar a estrela
        return view('index', [
            'commands' => $commands,
            'stats'    => $stats,
            'q'        => $term,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'device'      => ['required','string','max:100'],
            'protocol'    => ['nullable','string','max:50'],
            'task'        => ['nullable','string','max:255'],
            'command'     => ['required','string'],
            'description' => ['nullable','string'],
        ]);

        $payload = [
            'vendor'      => $data['device'],
            'protocol'    => $data['protocol'] ?? null,
            'task'        => $data['task'] ?? null,
            'command'     => $data['command'],
            'description' => $data['description'] ?? null,
        ];

        if (Schema::hasColumn('commands', 'favorite'))    $payload['favorite'] = false;
        if (Schema::hasColumn('commands', 'usage_count')) $payload['usage_count'] = 0;

        Command::create($payload);

        return back()->with('success', 'Comando adicionado!');
    }

    // -------- Favorito (coluna booleana) --------
    public function toggleFavorite(Request $request, Command $command)
    {
        if (!Schema::hasColumn('commands', 'favorite')) {
            return response()->json(['ok'=>false, 'error'=>'Coluna favorite ausente.'], 422);
        }

        $command->favorite = ! (bool) $command->favorite;
        $command->save();

        return response()->json([
            'ok'        => true,
            'favorited' => (bool) $command->favorite,
        ]);
    }

    // -------- Contador de uso --------
    public function incrementUsage(Request $request, Command $command)
    {
        if (Schema::hasColumn('commands', 'usage_count')) {
            $command->increment('usage_count');
        }
        return response()->noContent();
    }
}
