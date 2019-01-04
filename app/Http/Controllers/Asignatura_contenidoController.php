<?php

namespace App\Http\Controllers;
use App\Models\Contenido;
use App\Models\Asignatura;
use App\Models\Asignatura_contenido;


use Illuminate\Http\Request;

class Asignatura_contenidoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private $route = 'asignatura_contenido';
    private $module = 'Asignatura_contenido';
    private $pag = 25;
    private $folder = 'asignatura_contenido';

    public function index(Request $request)
    {


        $title = $this->module;
        $data = Asignatura_contenido::orderBy('id')->paginate($this->pag);
        $ruta = $this->route;

        return view($this->folder.'.index', compact('title', 'data', 'ruta', 'request'));
    }


    public function create()
    {

        $title = $this->module;
        $ruta = $this->route;
        $nombre = Asignatura::pluck('nombre as name', 'id');
        $tema = Contenido::pluck('tema as name', 'id');

        return view($this->folder.'.create', compact('title', 'ruta', 'request', 'nombre','tema'));
    }


    public function store(Request $request)
    {
        // return $request->all();
        $data =  new Asignatura_contenido();
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
        $data = Asignatura_contenido::Find($id);
        $nombre = Asignatura::pluck('nombre as name', 'id');
        $tema = Contenido::pluck('tema as name', 'id');

        return view($this->folder.".show", compact('data', 'title', 'modulo', 'ruta', 'nombre', 'tema'));
    }


    public function edit($id)
    {
        $title = $this->module;
        $data = Asignatura_contenido::Find($id);
        $ruta = $this->route;
        $nombre = Asignatura::pluck('nombre as name', 'id');
        $tema = Contenido::pluck('tema as name', 'id');

        return view($this->folder.'.edit', compact('title', 'data', 'ruta', 'request', 'nombre', 'tema'));
    }


    public function update(Request $request, $id)
    {
        $data = Asignatura_contenido::FindOrFail($id);

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
        $data = Asignatura_contenido::Find($id);
        $data->delete();
        session()->flash('success', 'Se ha eliminado correctamente');
        return redirect($this->route);
    }
}
