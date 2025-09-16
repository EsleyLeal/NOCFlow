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

        Troubleshooting::create($data);

        return back()->with('success', 'Troubleshooting adicionado!');
    }

    // Atualização inline (campos fixos, detalhes ou passos)
    public function update(Request $request, Troubleshooting $troubleshooting)
    {
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

    return response()->json(['success' => true]);
    }

    public function destroy(Troubleshooting $troubleshooting)
{
    $troubleshooting->delete();

    return response()->json(['success' => true]);
}

}
