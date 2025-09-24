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
                $w->where('ticket_code', 'like', "%{$q}%")
                  ->orWhere('client_name', 'like', "%{$q}%")
                  ->orWhere('description', 'like', "%{$q}%")
                  ->orWhere('steps', 'like', "%{$q}%");
            });
        }

        $items = $query->latest()->get();

        $stats = [
            'total'          => Troubleshooting::count(),
            'personalizados' => $items->count(),
            'padrao'         => 0,
        ];

        return view('troubleshooting', compact('items', 'stats', 'q'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ticket_code'       => 'nullable|string|max:255',
            'client_name'       => 'nullable|string|max:255',
            'troubleshoot_type' => 'nullable|string|max:255',
            'description'       => 'nullable|string|max:1000',
            'endereco'          => 'nullable|string|max:255',
            'bairro'            => 'nullable|string|max:255',
            'complemento'       => 'nullable|string|max:255',
            'cidade'            => 'nullable|string|max:255',
            'grupo'             => 'nullable|string|max:255',
            'uf'                => 'nullable|string|max:2',
            'steps'             => 'nullable|string',
            'details'           => 'nullable|array',
        ]);

        // Monta os detalhes adicionais
        $details = [];
        foreach ($request->all() as $key => $value) {
            if (in_array($key, [
                '_token',
                'ticket_code',
                'client_name',
                'troubleshoot_type',
                'description',
                'endereco',
                'bairro',
                'complemento',
                'cidade',
                'grupo',
                'uf',
                'steps'
            ])) {
                continue; // pula campos fixos
            }

            if (is_array($value)) {
                $details[$key] = $value;
            }
        }

        $data['details'] = json_encode($details, JSON_UNESCAPED_UNICODE);
        $data['user_id'] = auth()->id(); // vincula o dono

        Troubleshooting::create($data);

        return back()->with('success', 'Troubleshooting adicionado!');
    }

    public function update(Request $request, Troubleshooting $troubleshooting)
{
    $user = auth()->user();

    // só admin ou dono pode editar
    if (!($user->isAdmin() || $user->id === $troubleshooting->user_id)) {
        return response()->json(['error' => 'Não autorizado'], 403);
    }

    // === Caso 1: atualização de campo fixo ===
    if ($request->hasAny([
        'ticket_code','client_name','troubleshoot_type','description',
        'endereco','bairro','complemento','cidade','grupo','uf'
    ])) {
        $troubleshooting->update($request->only([
            'ticket_code','client_name','troubleshoot_type','description',
            'endereco','bairro','complemento','cidade','grupo','uf'
        ]));
    }

    // === Caso 2: atualização de steps (linha específica) ===
    if ($request->has(['step_index','value'])) {
        $steps = preg_split("/\r\n|\n|\r/", (string)($troubleshooting->steps ?? ''));
        $steps = array_values(array_filter(array_map('trim', $steps), fn($s) => $s !== ''));

        $index = (int) $request->step_index;
        if (isset($steps[$index])) {
            $steps[$index] = $request->value;
            $troubleshooting->steps = implode("\n", $steps);
            $troubleshooting->save();
        }
    }

    // === Caso 3: atualização de detalhes adicionais ===
    if ($request->has(['detail_key','subfield','value'])) {
        $details = json_decode($troubleshooting->details ?? '{}', true);

        $key = $request->detail_key;
        $sub = $request->subfield;

        if (isset($details[$key]) && is_array($details[$key])) {
            foreach ($details[$key] as $i => $entry) {
                if (!is_array($entry)) $details[$key][$i] = ['value' => $entry];
            }
            $details[$key][0][$sub] = $request->value;
        }

        $troubleshooting->details = json_encode($details, JSON_UNESCAPED_UNICODE);
        $troubleshooting->save();
    }

    // === Caso 4: atualização completa de steps (textarea inteiro) ===
    if ($request->has('steps')) {
        $troubleshooting->steps = $request->steps;
        $troubleshooting->save();
    }

    return response()->json(['success' => true], 200);
}


    public function destroy(Troubleshooting $troubleshooting)
{
    $user = auth()->user();

    // Só admin ou dono pode excluir
    if ($user->isAdmin() || $troubleshooting->user_id === $user->id) {
        $troubleshooting->delete();

        return response()->json(['success' => true], 200);
    }

    return response()->json(['error' => 'Não autorizado'], 403);
}

public function search(Request $request)
{
    $q = trim($request->get('q', ''));

    $query = Troubleshooting::query();

    if ($q) {
        // Quebra a pesquisa em tokens (palavras separadas por espaço)
        $tokens = preg_split('/\s+/', $q);

        // Opcional: ignora palavras "bobas"
        $stopwords = ['de','da','do','a','o','em','no','na'];
        $tokens = array_diff($tokens, $stopwords);

        foreach ($tokens as $token) {
            $query->where(function($w) use ($token) {
                $w->where('ticket_code', 'like', "%{$token}%")
                  ->orWhere('client_name', 'like', "%{$token}%")
                  ->orWhere('troubleshoot_type', 'like', "%{$token}%")
                  ->orWhere('description', 'like', "%{$token}%")
                  ->orWhere('endereco', 'like', "%{$token}%")
                  ->orWhere('bairro', 'like', "%{$token}%")
                  ->orWhere('complemento', 'like', "%{$token}%")
                  ->orWhere('cidade', 'like', "%{$token}%")
                  ->orWhere('grupo', 'like', "%{$token}%")
                  ->orWhere('uf', 'like', "%{$token}%")
                  ->orWhere('steps', 'like', "%{$token}%")
                  ->orWhere('details', 'like', "%{$token}%");
            });
        }
    }

    $items = $query->latest()->limit(30)->get();

    return response()->json($items->map(function ($ts) {
        return [
            'id'          => $ts->id,
            'ticket_code' => $ts->ticket_code,
            'client_name' => $ts->client_name,
            'cidade'      => $ts->cidade,
            'bairro'      => $ts->bairro,
            'grupo'       => $ts->grupo,
            'uf'          => $ts->uf,
            'description' => $ts->description,
        ];
    }));
}

public function edit($id)
{
    $ts = Troubleshooting::findOrFail($id);
    return response()->json([
        'id' => $ts->id,
        'ticket_code' => $ts->ticket_code,
        'client_name' => $ts->client_name,
        'troubleshoot_type' => $ts->troubleshoot_type,
        'description' => $ts->description,
        'endereco' => $ts->endereco,
        'bairro' => $ts->bairro,
        'complemento' => $ts->complemento,
        'cidade' => $ts->cidade,
        'grupo' => $ts->grupo,
        'uf' => $ts->uf,
        'steps' => $ts->steps,
        'details' => json_decode($ts->details, true),
    ]);
}


}
