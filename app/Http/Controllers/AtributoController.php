<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use App\Http\Requests;
use App\Atributo;
use App\Seguro;

class AtributoController extends Controller
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
    public function index()
    {
        $atributos = Atributo::all();
        
        return view('atributos.index', ['atributos' => $atributos, 'classes_atributos' => 'active']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $seguros = Seguro::all();
        
        return view(
            'atributos.create',
            [
                'seguros' => $seguros
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'atributo' => 'required',
            'tipo' => 'required',
            'adhiere' => 'required',
            'cubre' => 'required'
        ]);

        $input = $request->all();
        $seguros_arr = $request->get('aplicacion');
        $seguros = implode(',', $seguros_arr ? $seguros_arr : []);

        $input['aplicacion'] = $seguros;
        $input['estado'] = isset ($input['estado']) && $input['estado'] == 'on' ? 1 : 0;

        Atributo::create($input);

        Session::flash('flash_message', 'El atributo se ha creado con éxito!');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $atributo = Atributo::findOrFail($id);
        return view('atributos.show', ['atributo' => $atributo]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $atributo = Atributo::findOrFail($id);
        $seguros = Seguro::all();
        $seguros_sel = explode(',', $atributo->aplicacion);

        // var_dump($seguros_sel);
        // exit;

        return view(
            'atributos.edit',
            [
                'atributo' => $atributo,
                'seguros' => $seguros,
                'seguros_sel' => $seguros_sel
            ]
        );
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
        $atributo = Atributo::findOrFail($id);

        $this->validate($request, [
            'atributo' => 'required',
            'tipo' => 'required',
            'adhiere' => 'required',
            'cubre' => 'required'
        ]);

        $input = $request->all();
        $seguros_arr = $request->get('aplicacion');
        $seguros = implode(',', $seguros_arr ? $seguros_arr : []);

        $input['aplicacion'] = $seguros;
        $input['estado'] = isset ($input['estado']) && $input['estado'] == 'on' ? 1 : 0;

        $atributo->fill($input)->save();

        Session::flash('flash_message', 'El atributo se ha modificado con éxito!');

        return redirect()->back();
    }

    /**
     * Show the form for deleting the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $atributo = Atributo::findOrFail($id);
        return view('atributos.delete')->withAtributo($atributo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $atributo = Atributo::findOrFail($id);

        $atributo->delete();

        Session::flash('flash_message', 'El atributo se ha eliminado con éxito!');

        return redirect()->route('atributos.index');
    }
}
