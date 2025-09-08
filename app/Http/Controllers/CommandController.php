<?php

namespace App\Http\Controllers;

use App\Models\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema; // pra checar se a coluna existe

class CommandController extends Controller
{
    /**
     * LISTAGEM + FILTROS/ORDENAÇÃO
     */
    public function index(Request $request)
    {
        // parâmetros de query
        $term       = trim($request->query('q', ''));
        $vendors    = (array) $request->query('vendor', []);
        $protocols  = (array) $request->query('protocol', []);
        $onlyFav    = (bool) $request->boolean('favorites');
        $sort       = $request->query('sort', 'recent');

        $query = Command::query();

        // busca textual
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

        // só favoritos (se a coluna existir)
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
                // se não existir a coluna, cai no "recent"
                // no break aqui de propósito
            case 'az':
                $query->orderBy('command');
                break;
            case 'vendor':
                $query->orderBy('vendor')->orderBy('command');
                break;
            default: // recent
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

        return view('index', [
            'commands' => $commands,
            'stats'    => $stats,
            'q'        => $term,
        ]);
    }

    /**
     * CRIAÇÃO DE COMANDO (seu form usa "device" = vendor)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'device'      => ['required','string','max:100'],  // Cisco/Huawei/Datacom...
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

        // valores padrão se as colunas existirem
        if (Schema::hasColumn('commands', 'favorite')) {
            $payload['favorite'] = false;
        }
        if (Schema::hasColumn('commands', 'usage_count')) {
            $payload['usage_count'] = 0;
        }

        Command::create($payload);

        return back()->with('success', 'Comando adicionado!');
    }

    /**
     * TOGGLE FAVORITE (coluna booleana "favorite")
     * Endpoint para AJAX: POST /comandos/{command}/favorite
     */
    public function toggleFavorite(Command $command)
    {
        abort_unless(Schema::hasColumn('commands', 'favorite'), 404, 'Coluna favorite não existe na tabela commands.');

        $command->favorite = ! (bool) $command->favorite;
        $command->save();

        return response()->json([
            'ok'        => true,
            'favorited' => (bool) $command->favorite,
        ]);
    }

    /**
     * INCREMENT USAGE (coluna "usage_count")
     * Endpoint para AJAX: POST /comandos/{command}/used
     */
    public function incrementUsage(Command $command)
    {
        if (Schema::hasColumn('commands', 'usage_count')) {
            $command->increment('usage_count');
        }
        return response()->noContent();
    }
}
