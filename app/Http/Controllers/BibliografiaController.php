<?php

namespace App\Http\Controllers;

//use DummyFullModelClass;
use App\Models\Bibliografia;
use Illuminate\Http\Request;

class BibliografiaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private $route = 'bibliografia';
    private $module = 'Bibliografia';
    private $pag = 25;
    private $folder = 'bibliografia';

    public function index(Request $request)
    {


        $title = $this->module;
        $data = Bibliografia::orderBy('titulo')
            ->where('titulo', 'LIKE' , '%'. $request->q ."%")
            ->paginate($this->pag);
        $ruta = $this->route;

        return view($this->folder . '.index', compact('title', 'data', 'ruta', 'request'));
    }

    public function create()
    {

        $title = $this->module;
        $ruta = $this->route;

        return view($this->folder . '.create', compact('title', 'ruta', 'request'));
    }


    public function store(Request $request)
    {
        // return $request->all();
        $data = new Bibliografia();
        $data->fill($request->all());
        if ($data->save()) {
            session()->flash('success', 'Se ha creado correctamente');
        } else {
            session()->flash('danger', 'OPS!!, Algo salio mal, no se pudo guardar el registro');
        }

        return redirect($this->route);
    }


    public function show($id)
    {
        $title = $this->module . ' Eliminar';
        $ruta = $this->route;
        $data = Bibliografia::Find($id);
        return view($this->folder . ".show", compact('data', 'title', 'modulo', 'ruta'));
    }


    public function edit($id)
    {
        $title = $this->module;
        $data = Bibliografia::Find($id);
        $ruta = $this->route;

        return view($this->folder . '.edit', compact('title', 'data', 'ruta', 'request'));
    }


    public function update(Request $request, $id)
    {
        $data = Bibliografia::FindOrFail($id);

        $data->fill($request->all());

        if ($data->save()) {

            session()->flash('success', 'Se ha actualizado correctamente');
        } else {
            session()->flash('danger', 'OPS!!, Algo salio mal, no se pudo actualizar  el registro');
        }

        return redirect($this->route);
    }


    public function destroy($id)
    {
        $data = Bibliografia::Find($id);
        $data->delete();
        session()->flash('success', 'Se ha eliminado correctamente');
        return redirect($this->route);
    }
}
