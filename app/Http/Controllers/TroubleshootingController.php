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
                $w->where('NOME', 'like', "%{$q}%")
                  ->orWhere('IP', 'like', "%{$q}%")
                  ->orWhere('PE_RELACIONADO', 'like', "%{$q}%")
                  ->orWhere('DESIGNADOR', 'like', "%{$q}%")
                  ->orWhere('VLAN_GER', 'like', "%{$q}%")
                  ->orWhere('PARCEIRO', 'like', "%{$q}%")
                  ->orWhere('PORTA', 'like', "%{$q}%")
                  ->orWhere('LINK_PRTG', 'like', "%{$q}%")
                  ->orWhere('ENDERECO_NOVO', 'like', "%{$q}%")
                  ->orWhere('ENDERECO_BAIRRO', 'like', "%{$q}%")
                  ->orWhere('ENDERECO_COMPLEMENTO', 'like', "%{$q}%")
                  ->orWhere('ENDERECO_UF', 'like', "%{$q}%")
                  ->orWhere('ENDERECO_CIDADE', 'like', "%{$q}%")
                  ->orWhere('STEPS', 'like', "%{$q}%");
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
            'contrato'           => 'nullable|string|max:255',
            'nome'               => 'nullable|string|max:255',
            'cpe'                => 'nullable|string|max:255',
            'pe'                 => 'nullable|string|max:255',
            'vlans'              => 'nullable|string|max:255',
            'designador'         => 'nullable|string|max:255',
            'onu'                => 'nullable|string|max:255',
            'prtg'               => 'nullable|string|max:1000',
            'parceiro'           => 'nullable|string|max:255',
            'contato_parceiro'   => 'nullable|string|max:255',
            'porta'              => 'nullable|string|max:255',
            'sw_acesso'          => 'nullable|string|max:255',
            'avenida'            => 'nullable|string|max:255',
            'bairro'             => 'nullable|string|max:255',
            'complemento'        => 'nullable|string|max:255',
            'uf'                 => 'nullable|string|max:2',
            'cidade'             => 'nullable|string|max:255',
            'steps'              => 'nullable|string',
            'details'            => 'nullable|array',
        ]);

        $mapped = [
            'CONTRATO_NOVO'        => $data['contrato'] ?? null,
            'NOME'                 => $data['nome'] ?? null,
            'IP'                   => $data['cpe'] ?? null,
            'PE_RELACIONADO'       => $data['pe'] ?? null,
            'VLAN_GER'             => $data['vlans'] ?? null,
            'DESIGNADOR'           => $data['designador'] ?? null,
            'ONU'                  => $data['onu'] ?? null,
            'LINK_PRTG'            => $data['prtg'] ?? null,
            'PARCEIRO'             => $data['parceiro'] ?? null,
            'CONTATO_PARCEIRO'     => $data['contato_parceiro'] ?? null,

            'PORTA'                => $data['porta'] ?? null,
            'CIRCUITO'             => null,

            'SW_RELACIONADO'       => $data['sw_acesso'] ?? null,
            'ENDERECO_NOVO'        => $data['avenida'] ?? null,
            'ENDERECO_BAIRRO'      => $data['bairro'] ?? null,
            'ENDERECO_COMPLEMENTO' => $data['complemento'] ?? null,
            'ENDERECO_UF'          => $data['uf'] ?? null,
            'ENDERECO_CIDADE'      => $data['cidade'] ?? null,
            'STEPS'                => $data['steps'] ?? null,
            'DETAILS'              => !empty($data['details']) ? json_encode($data['details'], JSON_UNESCAPED_UNICODE) : null,
            'LAST_EDIT_USER'       => auth()->id(),
        ];

        Troubleshooting::create($mapped);

        return back()->with('success', 'Troubleshooting adicionado com sucesso!');
    }

    public function update(Request $request, Troubleshooting $troubleshooting)
    {
        $user = auth()->user();

        if (!($user->isAdmin() || $user->id === $troubleshooting->LAST_EDIT_USER)) {
            return response()->json(['error' => 'Não autorizado'], 403);
        }

        $input = $request->only([
            'contrato','nome','cpe','pe','vlans','designador','onu','prtg',
            'parceiro','contato_parceiro','porta','sw_acesso',
            'avenida','bairro','complemento','uf','cidade','steps','details'
        ]);

        $mapped = [
            'CONTRATO_NOVO'        => $input['contrato'] ?? $troubleshooting->CONTRATO_NOVO,
            'NOME'                 => $input['nome'] ?? $troubleshooting->NOME,
            'IP'                   => $input['cpe'] ?? $troubleshooting->IP,
            'PE_RELACIONADO'       => $input['pe'] ?? $troubleshooting->PE_RELACIONADO,
            'VLAN_GER'             => $input['vlans'] ?? $troubleshooting->VLAN_GER,
            'DESIGNADOR'           => $input['designador'] ?? $troubleshooting->DESIGNADOR,
            'ONU'                  => $input['onu'] ?? $troubleshooting->ONU,
            'LINK_PRTG'            => $input['prtg'] ?? $troubleshooting->LINK_PRTG,
            'PARCEIRO'             => $input['parceiro'] ?? $troubleshooting->PARCEIRO,
            'CONTATO_PARCEIRO'     => $input['contato_parceiro'] ?? $troubleshooting->CONTATO_PARCEIRO,

            'PORTA'                => $input['porta'] ?? $troubleshooting->PORTA,
            'CIRCUITO'             => $troubleshooting->CIRCUITO,

            'SW_RELACIONADO'       => $input['sw_acesso'] ?? $troubleshooting->SW_RELACIONADO,
            'ENDERECO_NOVO'        => $input['avenida'] ?? $troubleshooting->ENDERECO_NOVO,
            'ENDERECO_BAIRRO'      => $input['bairro'] ?? $troubleshooting->ENDERECO_BAIRRO,
            'ENDERECO_COMPLEMENTO' => $input['complemento'] ?? $troubleshooting->ENDERECO_COMPLEMENTO,
            'ENDERECO_UF'          => $input['uf'] ?? $troubleshooting->ENDERECO_UF,
            'ENDERECO_CIDADE'      => $input['cidade'] ?? $troubleshooting->ENDERECO_CIDADE,
            'STEPS'                => $input['steps'] ?? $troubleshooting->STEPS,
            'DETAILS'              => isset($input['details'])
                                        ? json_encode($input['details'], JSON_UNESCAPED_UNICODE)
                                        : $troubleshooting->DETAILS,
            'LAST_EDIT_USER'       => auth()->id(),
            'LAST_EDIT_TIME'       => now(),
        ];

        $troubleshooting->update($mapped);

        return redirect()->route('troubleshooting')
                         ->with('success', 'Troubleshooting atualizado com sucesso!');
    }

    public function destroy(Troubleshooting $troubleshooting)
    {
        $user = auth()->user();

        if ($user->isAdmin() || $troubleshooting->LAST_EDIT_USER === $user->id) {
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
            $tokens = preg_split('/\s+/', $q);
            $stopwords = ['de','da','do','a','o','em','no','na'];
            $tokens = array_diff($tokens, $stopwords);

            foreach ($tokens as $token) {
                $query->where(function($w) use ($token) {
                    $w->where('NOME', 'like', "%{$token}%")
                      ->orWhere('IP', 'like', "%{$token}%")
                      ->orWhere('PE_RELACIONADO', 'like', "%{$token}%")
                      ->orWhere('DESIGNADOR', 'like', "%{$token}%")
                      ->orWhere('VLAN_GER', 'like', "%{$token}%")
                      ->orWhere('PARCEIRO', 'like', "%{$token}%")
                      ->orWhere('PORTA', 'like', "%{$token}%")
                      ->orWhere('LINK_PRTG', 'like', "%{$token}%")
                      ->orWhere('ENDERECO_NOVO', 'like', "%{$token}%")
                      ->orWhere('ENDERECO_BAIRRO', 'like', "%{$token}%")
                      ->orWhere('ENDERECO_COMPLEMENTO', 'like', "%{$token}%")
                      ->orWhere('ENDERECO_UF', 'like', "%{$token}%")
                      ->orWhere('ENDERECO_CIDADE', 'like', "%{$token}%")
                      ->orWhere('STEPS', 'like', "%{$token}%")
                      ->orWhere('DETAILS', 'like', "%{$token}%");
                });
            }
        }

        $items = $query->latest()->limit(30)->get();

        return response()->json($items->map(function ($ts) {
            return [
                'id'          => $ts->id,
                'nome'        => $ts->NOME,
                'cidade'      => $ts->ENDERECO_CIDADE,
                'avenida'     => $ts->ENDERECO_NOVO,
                'complemento' => $ts->ENDERECO_COMPLEMENTO,
                'cpe'         => $ts->IP,
                'pe'          => $ts->PE_RELACIONADO,
                'designador'  => $ts->DESIGNADOR,
                'vlans'       => $ts->VLAN_GER,
                'publico'     => $ts->IP,
                'porta'       => $ts->PORTA,
                'circuito'    => $ts->CIRCUITO,
                'parceiro'    => $ts->PARCEIRO,
                'uf'          => $ts->ENDERECO_UF,
            ];
        }));
    }

    public function edit($id)
    {
        $ts = Troubleshooting::findOrFail($id);
        return view('reuse.viewEditTroubleshooting', compact('ts'));
    }
}
