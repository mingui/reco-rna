<?php

namespace App\Http\Controllers;
use App\Models\Contenido;
use App\Models\Bibliografia;
use App\Models\Bibliografia_contenido;


use Illuminate\Http\Request;

class Bibliografia_contenidoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private $route = 'bibliografia_contenido';
    private $module = 'Bibliografia_contenido';
    private $pag = 25;
    private $folder = 'bibliografia_contenido';

    public function index(Request $request)
    {


        $title = $this->module;
        $data = Bibliografia_contenido::orderBy('id')->paginate($this->pag);
        $ruta = $this->route;

        return view($this->folder.'.index', compact('title', 'data', 'ruta', 'request'));
    }


    public function create()
    {

        $title = $this->module;
        $ruta = $this->route;
        $titulo = Bibliografia::pluck('titulo as name', 'id');
        $tema = Contenido::pluck('tema as name', 'id');

        return view($this->folder.'.create', compact('title', 'ruta', 'request', 'titulo','tema'));
    }


    public function store(Request $request)
    {
        // return $request->all();
        $data =  new Bibliografia_contenido();
        $data->fill($request->all());
        if($data->save()){
            session()->flash('success', 'Se ha creado correctamente');
        }else {
            session()->flash('danger', 'OPS!!, Algo salio mal, no se pudo guardar el registro');
        }

        return redirect($this->route);
    }


    public function show($id)
    {
        $title = $this->module .' Eliminar';
        $ruta = $this->route;
        $data = Bibliografia_contenido::Find($id);
        $titulo = Bibliografia::pluck('titulo as name', 'id');
        $tema = Contenido::pluck('tema as name', 'id');

        return view($this->folder.'.show', compact('title', 'data', 'ruta', 'request', 'titulo', 'tema'));
    }


    public function edit($id)
    {
        $title = $this->module;
        $data = Bibliografia_contenido::Find($id);
        $ruta = $this->route;
        $titulo = Bibliografia::pluck('titulo as name', 'id');
        $tema = Contenido::pluck('tema as name', 'id');

        return view($this->folder.'.edit', compact('title', 'data', 'ruta', 'request', 'titulo', 'tema'));
    }


    public function update(Request $request, $id)
    {
        $data = Bibliografia_contenido::FindOrFail($id);

        $data->fill($request->all());

        if($data->save()){

            session()->flash('success', 'Se ha actualizado correctamente');
        }else {
            session()->flash('danger', 'OPS!!, Algo salio mal, no se pudo actualizar  el registro');
        }

        return redirect($this->route);
    }


    public function destroy($id)
    {
        $data = Bibliografia_contenido::Find($id);
        $data->delete();
        session()->flash('success', 'Se ha eliminado correctamente');
        return redirect($this->route);
    }
}
