<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produto;
use App\Categoria;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $produtos = Produto::select('id', 'categoria_id', 'codigo', 'titulo', 'cor', 'ano', 'dt_modify');
        
        // caso houve busca
        if ($busca = $request->input('q'))
        {
            $tipo = $request->input('tipo_busca');
            
            // caso tipo seja categoria
            if ($tipo == 'categoria')
            {
                $produtos->whereHas('categoria', function($query) use ($busca) {
                    $query->where('id', (int) $busca);
                });
            }
            else
            {
                $produtos->where($tipo, 'LIKE', "%{$busca}%");
            }
        }
        // aplicando paginação
        $produtos = $produtos->paginate(20);

        // caso houve busca adiciona a query de busca à paginação
        if ($busca) $produtos->withPath("?q={$busca}&tipo_busca={$tipo}");
        
        return view('admin.dashboard')->with('produtos', $produtos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.prod_create_update');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produto = Produto::findOrFail($id);
        // dd($produto);
        return view('admin.prod_create_update')->with('produto', $produto);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['dt_modify'] = date('Y-m-d H:i:s');
        
        Produto::findOrFail($id)->update($data);

        return redirect()->route('dashboard')->with([
            'action' => 'update', 
            'msg'    => "Produto {$request->codigo} atualizado com sucesso!",
            'class'  => 'alert alert-success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $codigo = Produto::findOrFail($id)->codigo;

        // Produto::destroy($id);
        return back()->with([
            'action' => 'destroy', 
            'msg'    => "Produto {$codigo} removido com sucesso!",
            'class'  => 'alert alert-success'
        ]);
    }
}
