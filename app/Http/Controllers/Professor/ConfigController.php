<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Configuracao;
use App\Models\FotoCentro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConfigController extends Controller
{
    /**
     * Exibe o formulário de edição das configurações (registro único).
     */
    public function edit()
    {
        $config = Configuracao::first();
        if (!$config) {
            $config = Configuracao::create([
                'pix' => '',
                'whatsapp' => '',
                'maps_src' => '',
                'email' => '',
                'whatsapp_api_url' => 'https://api.uazapi.com.br',
                'whatsapp_api_token' => '',
            ]);
        }

        $fotosCentro = FotoCentro::ativas()->ordenadas()->get();

        return view('professor.config.edit', compact('config', 'fotosCentro'));
    }

    /**
     * Atualiza as configurações.
     */
    public function update(Request $request)
    {
        $dados = $request->validate([
            'pix' => ['nullable', 'string', 'max:255'],
            'whatsapp' => ['nullable', 'string', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'cidade' => ['nullable', 'string', 'max:255'],
            'bairro' => ['nullable', 'string', 'max:255'],
            'rua' => ['nullable', 'string', 'max:255'],
            'numero' => ['nullable', 'string', 'max:255'],
            'maps_src' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'whatsapp_api_url' => ['nullable', 'url', 'max:255'],
            'whatsapp_api_token' => ['nullable', 'string', 'max:255'],
        ], [
            'email.email' => 'Informe um e-mail válido.',
            'whatsapp_api_url.url' => 'Informe uma URL válida para a API.',
        ]);

        $config = Configuracao::firstOrCreate(['id' => 1], [
            'pix' => '',
            'whatsapp' => '',
            'instagram' => '',
            'cidade' => '',
            'bairro' => '',
            'rua' => '',
            'numero' => '',
            'maps_src' => '',
            'email' => '',
            'whatsapp_api_url' => 'https://api.uazapi.com.br',
            'whatsapp_api_token' => '',
        ]);

        $config->update($dados);

        return redirect()->route('professor.config.edit')->with('success', 'Configurações atualizadas com sucesso.');
    }

    /**
     * Adicionar nova foto do centro de treinamento
     */
    public function adicionarFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // Máx 5MB
            'descricao' => 'nullable|string|max:255',
        ], [
            'foto.required' => 'Selecione uma foto',
            'foto.image' => 'O arquivo deve ser uma imagem',
            'foto.mimes' => 'A foto deve ser nos formatos: jpeg, png, jpg ou gif',
            'foto.max' => 'A foto deve ter no máximo 5MB',
        ]);

        if ($request->hasFile('foto')) {
            $arquivo = $request->file('foto');
            $nomeOriginal = $arquivo->getClientOriginalName();
            $nomeArquivo = 'centro-' . time() . '-' . uniqid() . '.' . $arquivo->getClientOriginalExtension();
            
            // Criar diretório se não existir
            $diretorio = public_path('uploads/fotos_centro');
            if (!file_exists($diretorio)) {
                mkdir($diretorio, 0755, true);
            }
            
            // Mover arquivo para public
            $arquivo->move($diretorio, $nomeArquivo);
            $caminhoArquivo = 'uploads/fotos_centro/' . $nomeArquivo;

            // Definir ordem como próximo número
            $proximaOrdem = FotoCentro::max('ordem') + 1;

            FotoCentro::create([
                'caminho_arquivo' => $caminhoArquivo,
                'nome_original' => $nomeOriginal,
                'descricao' => $request->descricao,
                'ordem' => $proximaOrdem,
            ]);

            return redirect()->route('professor.config.edit')->with('success', 'Foto adicionada com sucesso!');
        }

        return redirect()->route('professor.config.edit')->with('error', 'Erro ao fazer upload da foto.');
    }

    /**
     * Excluir foto do centro de treinamento
     */
    public function excluirFoto(FotoCentro $foto)
    {
        // Excluir arquivo físico
        if ($foto->caminho_arquivo) {
            $caminhoArquivo = public_path($foto->caminho_arquivo);
            if (file_exists($caminhoArquivo)) {
                unlink($caminhoArquivo);
            }
        }

        // Excluir registro do banco
        $foto->delete();

        return redirect()->route('professor.config.edit')->with('success', 'Foto excluída com sucesso!');
    }
}
