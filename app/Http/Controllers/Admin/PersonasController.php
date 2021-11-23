<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\facades\Http;
use App\Http\Controllers\Parametros;

class PersonasController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('can:admin.personas.index')->only('index');
        $this->middleware('can:admin.personas.create')->only('create', 'store');
        $this->middleware('can:admin.personas.edit')->only('edit', 'update');
        $this->middleware('can:admin.personas.show')->only('show', 'destroy');
    }

    public function index()
    {
        $response = Http::get("http://18.117.164.59:3000/api/personas");
        $personas = json_decode($response->getBody());


        $estado = auth()->user()->est_user;

        if ($estado  && !Parametros::TiempoPass(auth()->user()->id)) {

        return view('admin.persona.index', ['personas' => $personas]);

        } else {
            return view('admin.inactivo.index');
        }
    }

    public function create()
    {
        $estado = auth()->user()->est_user;

        if ($estado  && !Parametros::TiempoPass(auth()->user()->id)) {

        return view('admin.persona.create');

        } else {

        return view('admin.inactivo.index');

        }

    }

    public function store(Request $request)
    {
        $request->validate([
            "primer_nombre" => 'required|regex:/(^([a-zA-Z\S])(\D+)?$)/u',
            "segundo_nombre" => 'required|regex:/(^([a-zA-Z\S])(\D+)?$)/u',
            "primer_apellido" => 'required|regex:/(^([a-zA-Z\S])(\D+)?$)/u',
            "sexo" => 'required',
            "edad" => 'required|numeric',
            "tipo_persona" => 'required',
            "fecha_nacimiento" => 'required|date',
            "rtn_persona" => 'required|numeric',
            "direccion" => 'required|regex:/(^([\w\s]+)(\s\d\w+)?$)/u',
            "municipio" => 'required|regex:/(^([a-zA-z\s]+)(\d+)?$)/u',
            "departamento" => 'required|regex:/(^([a-zA-z\s]+)(\d+)?$)/u',
            "numero_telefono" => 'required|numeric',
            "tipo_telefono" => 'required'
        ]);
        $response = Http::post('http://18.117.164.59:3000/api/personas/',[
            "primer_nom" => $request['primer_nombre'],
            "segundo_nom" => $request['segundo_nombre'],
            "primer_apel" => $request['primer_apellido'],
            "sexo" => $request['sexo'],
            "edad" => $request['edad'],
            "tipo_persona" => $request['tipo_persona'],
            "fec_nac_persona" => $request['fecha_nacimiento'],
            "rtn_persona" => $request['rtn_persona'],
            "des_direc" => $request['direccion'],
            "municipio" => $request['municipio'],
            "departamento" => $request['departamento'],
            "num_tel" => $request['numero_telefono'],
            "tipo_tel" => $request['tipo_telefono'],
            "usr_registro" => auth()->user()->name
        ]);


        $estado = auth()->user()->est_user;

        if ($estado  && !Parametros::TiempoPass(auth()->user()->id)) {

        return redirect()->route('admin.personas.index')->with('info', 'Se registro la persona con exito');

        } else {
            return view('admin.inactivo.index');
        }
    }

    public function edit($persona)
    {
        $response = Http::get("http://18.117.164.59:3000/api/personas/".$persona);
        $personas = json_decode($response->getBody()->getContents())[0];

        $data = [];
        $data['persona'] = $persona;

        $estado = auth()->user()->est_user;

        if ($estado  && !Parametros::TiempoPass(auth()->user()->id)) {

        return view('admin.persona.edit',['personas' =>$personas]);

        } else {
            return view('admin.inactivo.index');
        }

    }

    public function update(Request $request, $persona)
    {
        $request->validate([
            "primer_nombre" => 'required|regex:/(^([a-zA-Z\S])(\D+)?$)/u',
            "segundo_nombre" => 'required|regex:/(^([a-zA-Z\S])(\D+)?$)/u',
            "primer_apellido" => 'required|regex:/(^([a-zA-Z\S])(\D+)?$)/u',
            "sexo" => 'required',
            "edad" => 'required|numeric',
            "tipo_persona" => 'required',
            "fecha_nacimiento" => 'required|date',
            "rtn_persona" => 'required|numeric',
            "direccion" => 'required|regex:/(^([\w\s]+)(\s\d\w+)?$)/u',
            "municipio" => 'required|regex:/(^([a-zA-z\s]+)(\d+)?$)/u',
            "departamento" => 'required|regex:/(^([a-zA-z\s]+)(\d+)?$)/u',
            "numero_telefono" => 'required|numeric',
            "tipo_telefono" => 'required'
        ]);

        $response = Http::put('http://18.117.164.59:3000/api/personas/'. $persona, [
            "primer_nom" => $request['primer_nombre'],
            "segundo_nom" => $request['segundo_nombre'],
            "primer_apel" => $request['primer_apellido'],
            "sexo" => $request['sexo'],
            "edad" => $request['edad'],
            "tipo_persona" => $request['tipo_persona'],
            "fec_nac_persona" => $request['fecha_nacimiento'],
            "rtn_persona" => $request['rtn_persona'],
            "des_direc" => $request['direccion'],
            "municipio" => $request['municipio'],
            "departamento" => $request['departamento'],
            "num_tel" => $request['numero_telefono'],
            "tipo_tel" => $request['tipo_telefono'],
            "usr_registro" => auth()->user()->name
        ]);

        $estado = auth()->user()->est_user;

        if ($estado  && !Parametros::TiempoPass(auth()->user()->id)) {

        return redirect()->route('admin.personas.index')->with('info', 'Se actualizo la persona con exito');

        } else {
            return view('admin.inactivo.index');
        }

    }

    public function show($persona)
    {
        $response = Http::get("http://18.117.164.59:3000/api/personas/".$persona);
        $personas = json_decode($response->getBody()->getContents())[0];

        $data = [];
        $data['persona'] = $persona;

        $estado = auth()->user()->est_user;

        if ($estado  && !Parametros::TiempoPass(auth()->user()->id)) {

        return view('admin.persona.show', ['personas' =>$personas]);

        } else {
            return view('admin.inactivo.index');
        }

    }

    public function destroy($persona)
    {
        $response = Http::delete('http://18.117.164.59:3000/api/personas/'.$persona,[
            "usr_registro" => auth()->user()->name
        ]);

        $estado = auth()->user()->est_user;

        if ($estado  && !Parametros::TiempoPass(auth()->user()->id)) {

        return redirect()->route('admin.personas.index')->with('info', 'Se elimino la persona con exito');

        } else {
            return view('admin.inactivo.index');
        }

    }
}
