<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use Session;
use App\Http\Requests;
use App\Categoria;
use App\Seguro;
use App\Atributo;

class SeguroController extends Controller
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
        $seguros = Seguro::all();

        foreach ($seguros as $seguro) {
            $seguro->atributos = self::getAttributes($seguro->id);
        }

        return view('seguros.index', ['seguros' => $seguros, 'classes_seguros' => 'active']);
    }

    private function getAttributes($id) {
        $seguro = Seguro::findOrFail($id);
        $todos_los_atributos = Atributo::all();

        $seg_atributos = array();
        foreach ($todos_los_atributos as $atributo) {
            $atr_seguros = explode(',', $atributo->aplicacion);
            if (in_array($seguro->id, $atr_seguros)) {
                $seg_atributos[] = $atributo;
            }
        }
        
        return $seg_atributos;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = Categoria::all();
        $seguros = Seguro::all();
        $files = Storage::disk('public')->allFiles();
        $archivos = array();

        foreach($files as $file) {
            $archivos[] = array(
                "name" => $file,
                "view_path" => '/filesystem/pdf/'.$file,
                "download_path" => '/filesystem/pdf/download/'.$file,
                "trash_path" => '/filesystem/pdf/delete/'.$file,
                "size" => Storage::disk('public')->size($file),
                "mimeType" => Storage::disk('public')->mimeType($file),
                "lastModified" => Storage::disk('public')->lastModified($file)
            );
        }
        
        return view(
            'seguros.create',
            [
                'seguros' => $seguros,
                'categorias' => $categorias,
                'archivos' => $archivos
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
            'nombre' => 'required',
            'categoria' => 'required',
            'pago' => 'required',
            'valor_cobertura' => 'required',
            'unidad_cobertura' => 'required',
            'aseguradora' => 'required'
        ]);

        $input = $request->all();
        $input['moneda']    = isset ($input['moneda']) && $input['moneda'] == 'on' ? 'USD' : '$';
        $input['estado']    = isset ($input['estado']) && $input['estado'] == 'on' ? 1 : 0;
        $input['comprobar'] = isset ($input['comprobar']) && $input['comprobar'] == 'on' ? 1 : 0;

        Seguro::create($input);

        Session::flash('flash_message', 'El seguro se ha creado con éxito!');

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
        $seguro = Seguro::findOrFail($id);
        if ($seguro->pertenencia) {
            $pertenencia = Seguro::findOrFail($seguro->pertenencia);
            return view('seguros.show', ['seguro' => $seguro, 'pertenencia' => $pertenencia]);
        }

        return view('seguros.show', ['seguro' => $seguro]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $seguro = Seguro::findOrFail($id);
        $categorias = Categoria::all();
        $seguros = Seguro::all();
        $files = Storage::disk('public')->allFiles();
        $archivos = array();

        foreach($files as $file) {
            $archivos[] = array(
                "name" => $file,
                "view_path" => '/filesystem/pdf/'.$file,
                "download_path" => '/filesystem/pdf/download/'.$file,
                "trash_path" => '/filesystem/pdf/delete/'.$file,
                "size" => Storage::disk('public')->size($file),
                "mimeType" => Storage::disk('public')->mimeType($file),
                "lastModified" => Storage::disk('public')->lastModified($file)
            );
        }

        return view(
            'seguros.edit',
            [
                'seguro' => $seguro,
                'seguros' => $seguros,
                'categorias' => $categorias,
                'archivos' => $archivos
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
        $seguro = Seguro::findOrFail($id);

        $this->validate($request, [
            'nombre' => 'required',
            'categoria' => 'required',
            'pago' => 'required',
            'valor_cobertura' => 'required',
            'unidad_cobertura' => 'required',
            'aseguradora' => 'required'
        ]);

        $input = $request->all();
        $input['moneda']    = isset ($input['moneda']) && $input['moneda'] == 'on' ? 'USD' : '$';
        $input['estado']    = isset ($input['estado']) && $input['estado'] == 'on' ? 1 : 0;
        $input['comprobar'] = isset ($input['comprobar']) && $input['comprobar'] == 'on' ? 1 : 0;

        $seguro->fill($input)->save();

        Session::flash('flash_message', 'El seguro se ha modificado con éxito!');

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
        $seguro = Seguro::findOrFail($id);
        return view('seguros.delete')->withSeguro($seguro);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $seguro = Seguro::findOrFail($id);

        $seguro->delete();

        Session::flash('flash_message', 'El seguro se ha eliminado con éxito!');

        return redirect()->route('seguros.index');
    }
}
