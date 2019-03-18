<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Produto;
use App\ImagesProduto;
use App\Categoria;
use App\Carrossel;

class AdminController extends Controller
{
    private $produto;

    private static $typeMimeImageValid = [
        'image/gif',
        'image/jpeg',
        'image/jpg',
        'imagem/png',
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function getTypeMimeImageValid()
    {
        return self::$typeMimeImageValid;
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function alterPassword(Request $request)
    {
        Auth::user()->password = bcrypt($request->pass);
        Auth::user()->save();
        return 1;
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
        $this->produto = new Produto();
        $this->produto->fill( $request->except(['img', 'order']) );
        $this->produto->dt_public = date('Y-m-d H:i:s');
        
        $slug = str_slug($this->produto->titulo);

        // verifica se já existe algum produto com o mesmo slug
        if (Produto::where('slug', $slug)->count())
        {
            $slug .= '_'. str_random(6);
        }

        $this->produto->slug = $slug;
        $this->produto->save();

        $this->saveImagesOrder($request->img, $request->order);

        return redirect()->route('dashboard')->with([
            'action' => 'create', 
            'msg'    => "Produto {$this->produto->codigo} criado!",
            'class'  => 'alert alert-success'
        ]);
        
        return back()->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->produto = Produto::findOrFail($id);
        return view('admin.prod_create_update')->with('produto', $this->produto);
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
        $this->produto = Produto::findOrFail($id);
        $data = $request->except(['_token', '_method', 'order', 'ri', 'img']);
        $data['dt_modify'] = date('Y-m-d H:i:s');
        $slug = str_slug($data['titulo']);

        // verifica se já existe algum produto com o mesmo slug
        if (Produto::where('slug', $slug)->where('id', '<>', $id)->count())
        {
            $slug .= '_'. str_random(6);
        }

        $data['slug'] = $slug;
        
        // Caso foi removido imagens
        if ($ri = $request->input('ri'))
        {
            $ri = explode(',', $ri);

            foreach ($ri as $id)
            {
                $imagesProduto = ImagesProduto::findOrFail($id);
                // apagando imagem em disco
                Storage::disk('produtos')->delete($imagesProduto->nome);
                // removendo do db
                $imagesProduto->delete();
            }
        }

        $this->saveImagesOrder($request->img, $request->order);
        
        // Atualiza dados do produto
        $this->produto->update($data);

        return redirect()->route('dashboard')->with([
            'action' => 'update', 
            'msg'    => "Produto {$request->codigo} atualizado com sucesso!",
            'class'  => 'alert alert-success'
        ]);
    }

    private function saveImagesOrder($file_images, $ordem = [])
    {
        $ordem = collect($ordem)->map(function($v) {
            return json_decode($v);
        });

        if ($file_images)
        {
            $orderFilesUpload = $ordem->splice( - count($file_images) );
            
            $images = [];

            foreach ($file_images as $i => $file)
            {
                if ($file->isValid() and in_array($file->getMimeType(), self::getTypeMimeImageValid()))
                {
                    // atribui como indice o valor da ordem
                    // daquela imagem especifica
                    $images[] = $file;
                }
            }
    
            if (count($images))
            {
                foreach ($images as $i => $image)
                {
                    $imagesProduto = new ImagesProduto();
                    $imagesProduto->nome = $image->hashName();
                    $imagesProduto->order = $orderFilesUpload[$i];
                    $imagesProduto->produto()->associate($this->produto);
                    $imagesProduto->save();
    
                    $image->store('./', 'produtos');
                }
            }
            else
            {
                // Arquivos inválidos
            }
        }

        if ($ordem->count())
        {
            $ordem->each(function($ref) {
                $imagesProduto = ImagesProduto::find($ref->id);
                if ($imagesProduto)
                {
                    $imagesProduto->order = $ref->p;
                    $imagesProduto->save();
                }
            });
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->produto = Produto::findOrFail($id);

        // obtem código do produto
        $codigo = $this->produto->codigo;
       
        // removendo imagens adicionais
        $this->produto->images->each(function($imagesProduto) {
            // path da mini
            $path_img = $imagesProduto->nome;
            // removendo db
            if ($imagesProduto->delete())
            {
                // apagando imagem em disco
                Storage::disk('produtos')->delete($path_img);
            }
        });
        
        $this->produto->delete();

        return back()->with([
            'action' => 'destroy', 
            'msg'    => "Produto {$codigo} removido com sucesso!",
            'class'  => 'alert alert-success'
        ]);
    }

    public function carrIndex()
    {
        $carrossels = Carrossel::orderBy('order')->get();
        
        return view('admin.carrossel')->with('carrossels', $carrossels);
    }

    public function carrUpdate(Request $request)
    {
        $ordem = null;

        // verifica se há imagens para remover
        if ($request->del)
        {
            $ids = explode(',', $request->del);
            foreach ($ids as $id)
            {
                $c = Carrossel::find($id);
                
                if ($c) {
                    // apagando imagem em disco
                    Storage::disk('carrossel')->delete($c->nome);
                    // removendo do db
                    $c->delete();
                }
            }
        }

        // se tem order
        if ($request->order)
        {
            $ordem = collect($request->order)->map(function($v) {
                return json_decode($v);
            });

            // ordena imagens já existente e remove de order
            $ordem = $ordem->filter(function($v) {
                if (is_object($v))
                {
                    Carrossel::where('id', $v->id)->update([
                        'order'      => $v->p,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
                return is_numeric($v);
            })->values();
        }

        // caso tenha novas imagens
        if ($request->img)
        {
            foreach ($request->img as $i => $fileImg)
            {
                if ($fileImg->isValid() and in_array($fileImg->getMimeType(), self::getTypeMimeImageValid()))
                {
                    $c = new Carrossel();
                    $c->nome  = $fileImg->hashName();
                    $c->mini  = 'none';
                    $c->order = $ordem[$i];
                    $c->save();
    
                    $fileImg->store('./', 'carrossel');
                }
            }
        }

        return back()->with([
            'action' => 'update', 
            'msg'    => "Carrossel alterado com sucesso!",
            'class'  => 'alert alert-success'
        ]);
    }
}
