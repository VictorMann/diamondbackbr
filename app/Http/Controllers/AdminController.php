<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Produto;
use App\ImagesProduto;
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
        $produtos = $produtos->orderBy('dt_create', 'DESC')->paginate(20);

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
        // cria instância
        $produto = new Produto();

        // atribui todos os campos exceto img
        $produto->fill( $request->except(['img']) );
        
        // tipos de imagens válidas
        $typeMimeValid = [
            'image/gif',
            'image/jpeg',
            'image/jpg',
            'imagem/png'
        ];

        if ($request->hasFile('img'))
        {
            $imagem_principal = null;
            $imagens_mini = [];

            foreach ($request->file('img') as $file)
            {
                if ($file->isValid() and in_array($file->getMimeType(), $typeMimeValid))
                {
                    if ( ! $imagem_principal ) $imagem_principal = $file;
                    else $imagens_mini[] = $file;
                }
            }

            if ($imagem_principal)
            {
                $imagem_principal->store('./', 'produtos');
                $produto->image = $imagem_principal->hashName();
                $produto->slug = str_slug($produto->titulo);
                $produto->dt_public = date('Y-m-d H:i:s');
                $produto->save();

                // Se há alguma imagem adicional
                if (count($imagens_mini))
                {
                    foreach ($imagens_mini as $mini)
                    {
                        $mini->store('./', 'produtos');
                        $imagesProduto = new ImagesProduto();
                        $imagesProduto->nome = $mini->hashName();
                        $imagesProduto->produto()->associate($produto);
                        $imagesProduto->save();
                    }
                }

                return redirect()->route('dashboard')->with([
                    'action' => 'create', 
                    'msg'    => "Produto {$produto->codigo} criado!",
                    'class'  => 'alert alert-success'
                ]);
            }
            else
            {
                // Arquivos inválidos
            }
        }
        else
        {
            // Não submeteu imagens
        }

        return back()->withInput();
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
        $produto = Produto::findOrFail($id);

        // obtem código do produto
        $codigo = $produto->codigo;
       
        // removendo imagens adicionais
        $produto->images->each(function($img) {
            // path da mini
            $path_img = $img->nome;
            // removendo db
            if ($img->delete())
            {
                // apagando imagem em disco
                Storage::disk('produtos')->delete($path_img);
            }
        });

        // path da imagem principal
        $path_img = $produto->image;
        // removendo db
        if ($produto->delete())
        {
            // apagando imagem em disco
            Storage::disk('produtos')->delete($path_img);
        }
        
        return back()->with([
            'action' => 'destroy', 
            'msg'    => "Produto {$codigo} removido com sucesso!",
            'class'  => 'alert alert-success'
        ]);
    }
}
