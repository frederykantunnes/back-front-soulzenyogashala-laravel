<?php

namespace App\Http\Controllers;

use App\ExercicioModel;
use App\ExercicioTurmaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiExerciciosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ExercicioModel::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $exercicio = new ExercicioModel($request->all());
        $exercicio->save();
        return $exercicio;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Support\Collection
     */
    public function show($id)
    {
        if($id==0){
            return ExercicioModel::all()->where('gratuito', 1)->values();
        }else{
            $dados =  DB::table('exercicios')
                ->join('exercicio_turma', 'exercicios.id', '=', 'exercicio_turma.id_exercicio')
                ->where('exercicio_turma.id_turma', $id)
                ->select("exercicios.id", 'exercicios.audio_video', 'exercicios.descricao', 'exercicios.duracao', 'exercicios.imagem', 'exercicios.titulo', 'exercicios.gratuito', 'exercicios.id_user', 'exercicios.created_at', 'exercicios.updated_at')
                ->get();

            return $dados;

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $exercicio = ExercicioModel::findOrFail($id);
        $exercicio->update($request->all());
        return $exercicio;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exercicio = ExercicioModel::findOrFail($id);
        $exercicio->delete();
    }
}
