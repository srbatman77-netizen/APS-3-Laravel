<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::orderBy('created_at', 'desc')->get();
        return view('produtos.index', compact('produtos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:1000',
            'preco' => 'required|numeric|min:0',
            'estoque' => 'required|integer|min:0',
        ], [
            'nome.required' => 'O nome do produto é obrigatório.',
            'preco.required' => 'O preço é obrigatório.',
            'preco.numeric' => 'O preço deve ser um valor numérico.',
            'estoque.required' => 'A quantidade em estoque é obrigatória.',
            'estoque.integer' => 'O estoque deve ser um número inteiro.',
        ]);

        Produto::create($validated);

        return redirect()->route('produtos.index')
            ->with('success', 'Produto cadastrado com sucesso!');
    }
}
