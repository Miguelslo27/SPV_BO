<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use App\Http\Requests;
use App\Categoria;
// use App\Seguro;

class CategoriaController extends Controller
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
		$categorias = Categoria::all();
		
		return view('categorias.index', ['categorias' => $categorias, 'classes_categorias' => 'active']);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('categorias.create');
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
			'caracteristicas' => 'required',
			'icono' => 'required'
		]);

		$input = $request->all();
		$input['estado'] = isset ($input['estado']) && $input['estado'] == 'on' ? 1 : 0;

		Categoria::create($input);

		Session::flash('flash_message', 'La categoría se ha creado con éxito!');

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
		$categoria = Categoria::findOrFail($id);
		return view('categorias.show')->withCategoria($categoria);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$categoria = Categoria::findOrFail($id);
		return view('categorias.edit')->withCategoria($categoria);
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
		$categoria = Categoria::findOrFail($id);

		$this->validate($request, [
			'nombre' => 'required',
			'caracteristicas' => 'required',
			'icono' => 'required'
		]);

		$input = $request->all();
		$input['estado'] = isset ($input['estado']) && $input['estado'] == 'on' ? 1 : 0;

		$categoria->fill($input)->save();

		Session::flash('flash_message', 'La categoría se a modificado con éxito!');

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
		$categoria = Categoria::findOrFail($id);
		return view('categorias.delete')->withCategoria($categoria);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$categoria = Categoria::findOrFail($id);

	    $categoria->delete();

	    Session::flash('flash_message', 'La categoría se ha eliminado con éxito!');

	    return redirect()->route('categorias.index');
	}
}
