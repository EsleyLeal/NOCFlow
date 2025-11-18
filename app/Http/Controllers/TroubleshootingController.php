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
                $w->where('nome', 'like', "%{$q}%")
                  ->orWhere('cpe', 'like', "%{$q}%")
                  ->orWhere('pe', 'like', "%{$q}%")
                  ->orWhere('designador', 'like', "%{$q}%")
                  ->orWhere('vlans', 'like', "%{$q}%")
                  ->orWhere('publico', 'like', "%{$q}%")
                  ->orWhere('parceiro', 'like', "%{$q}%")
                  ->orWhere('porta', 'like', "%{$q}%")
                  ->orWhere('prtg', 'like', "%{$q}%")
                  ->orWhere('avenida', 'like', "%{$q}%")
                  ->orWhere('bairro', 'like', "%{$q}%")
                  ->orWhere('complemento', 'like', "%{$q}%")
                  ->orWhere('uf', 'like', "%{$q}%")
                  ->orWhere('cidade', 'like', "%{$q}%")
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

    // ===============================================
    // STORE
    // ===============================================
    public function store(Request $request)
{
    $data = $request->validate([
        'contrato'        => 'nullable|string|max:255',
        'nome'            => 'nullable|string|max:255',
        'cpe'             => 'nullable|string|max:255',
        'pe'              => 'nullable|string|max:255',
        'vlans'           => 'nullable|string|max:255',
        'designador'      => 'nullable|string|max:255',
        'onu'             => 'nullable|string|max:255',
        'prtg'            => 'nullable|string|max:1000',
        'parceiro'        => 'nullable|string|max:255',
        'contato_parceiro'=> 'nullable|string|max:255',
        'porta'           => 'nullable|string|max:255',
        'sw_acesso'       => 'nullable|string|max:255',
        'publico'         => 'nullable|string|max:255',
        'avenida'         => 'nullable|string|max:255',
        'bairro'          => 'nullable|string|max:255',
        'complemento'     => 'nullable|string|max:255',
        'uf'              => 'nullable|string|max:2',
        'cidade'          => 'nullable|string|max:255',
        'steps'           => 'nullable|string',
        'details'         => 'nullable|array',
    ]);

    // Se details vier vazio, salva null
    $data['details'] = !empty($data['details'])
        ? json_encode($data['details'], JSON_UNESCAPED_UNICODE)
        : null;

    $data['user_id'] = auth()->id();

    Troubleshooting::create($data);

    return back()->with('success', 'Troubleshooting adicionado com sucesso!');
}


    // ===============================================
    // UPDATE
    // ===============================================
    public function update(Request $request, Troubleshooting $troubleshooting)
{
    $user = auth()->user();

    if (!($user->isAdmin() || $user->id === $troubleshooting->user_id)) {
        return response()->json(['error' => 'Não autorizado'], 403);
    }

    $fields = [
        'contrato','nome','cpe','pe','vlans','designador','onu','prtg',
        'parceiro','contato_parceiro','porta','sw_acesso','publico',
        'avenida','bairro','complemento','uf','cidade','steps','details'
    ];

    $data = $request->only($fields);

    if (isset($data['details']) && is_array($data['details'])) {
        $data['details'] = json_encode($data['details'], JSON_UNESCAPED_UNICODE);
    }

    $troubleshooting->update($data);

    return redirect()->route('troubleshooting')
                     ->with('success', 'Troubleshooting atualizado com sucesso!');
}


    // ===============================================
    // DESTROY
    // ===============================================
    public function destroy(Troubleshooting $troubleshooting)
    {
        $user = auth()->user();

        if ($user->isAdmin() || $troubleshooting->user_id === $user->id) {
            $troubleshooting->delete();
            return response()->json(['success' => true], 200);
        }

        return response()->json(['error' => 'Não autorizado'], 403);
    }

    // ===============================================
    // SEARCH
    // ===============================================
    public function search(Request $request)
{
    $q = trim($request->get('q', ''));

    $query = Troubleshooting::query();

    if ($q) {
        $tokens = preg_split('/\s+/', $q);
        $stopwords = ['de','da','do','a','o','em','no','na'];
        $tokens = array_diff($tokens, $stopwords);

        foreach ($tokens as $token) {
            $query->where(function($w) use ($token) {
                $w->where('nome', 'like', "%{$token}%")
                  ->orWhere('cpe', 'like', "%{$token}%")
                  ->orWhere('pe', 'like', "%{$token}%")
                  ->orWhere('designador', 'like', "%{$token}%")
                  ->orWhere('vlans', 'like', "%{$token}%")
                  ->orWhere('publico', 'like', "%{$token}%")
                  ->orWhere('parceiro', 'like', "%{$token}%")
                  ->orWhere('porta', 'like', "%{$token}%")
                  ->orWhere('prtg', 'like', "%{$token}%")
                  ->orWhere('avenida', 'like', "%{$token}%")
                  ->orWhere('bairro', 'like', "%{$token}%")
                  ->orWhere('complemento', 'like', "%{$token}%")
                  ->orWhere('uf', 'like', "%{$token}%")
                  ->orWhere('cidade', 'like', "%{$token}%")
                  ->orWhere('steps', 'like', "%{$token}%")
                  ->orWhere('details', 'like', "%{$token}%");
            });
        }
    }

    $items = $query->latest()->limit(30)->get();

    return response()->json($items->map(function ($ts) {
        return [
            'id'          => $ts->id,
            'nome'        => $ts->nome,
            'cidade'      => $ts->cidade,
            'avenida'     => $ts->avenida,
            'complemento' => $ts->complemento,
            'cpe'         => $ts->cpe,
            'pe'          => $ts->pe,
            'designador'  => $ts->designador,
            'vlans'       => $ts->vlans,
            'publico'     => $ts->publico,
            'porta'       => $ts->porta,
            'parceiro'    => $ts->parceiro,
            'uf'          => $ts->uf,
        ];
    }));
}


    // ===============================================
    // EDIT (carregado via AJAX)
    // ===============================================
    public function edit($id)
    {
        $ts = Troubleshooting::findOrFail($id);
        return view('reuse.viewEditTroubleshooting', compact('ts'));

    }
}
