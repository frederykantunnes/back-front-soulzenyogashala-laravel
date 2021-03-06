<?php

namespace App\Http\Controllers;

use App\AlunosModel;
use App\AlunoTurmaModel;
use App\ExercicioModel;
use App\ExercicioTurmaModel;
use App\MeditacaoModel;
use Illuminate\Http\Request;

class FrontOperacoesController extends Controller
{
    public function inseriremturma(Request $request){
        $aluno = AlunosModel::findOrFail($request['id_aluno']);
        $tm = $request['id_turma'];
        $aluno->turma = $tm;
        $aluno->save();
        flash($aluno->nome.' foi inserido em na turma!')->success();
        return redirect()->route('turma.show',$tm );
    }

    public function removerdaturma($id){
        $aluno = AlunosModel::findOrFail($id);
        $tm = $aluno->turma;
        $aluno->turma = null;
        $aluno->save();
        flash($aluno->nome.' foi removido da turma com sucesso!')->success();
        return redirect()->route('turma.show', $tm);
    }


    public function inserirexercicioemturma(Request $request){
        $exercicio = new ExercicioTurmaModel();
        $tm = $request['id_turma'];
        $exercicio->id_turma = $tm;
        $exercicio->id_exercicio = $request['id_exercicio'];
        $exercicio->save();
        flash('Exercício inserido na turma!')->success();
        return redirect()->route('turma.show',$tm );
    }

    public function removerexerciciodaturma($id){
        $exercicio = ExercicioTurmaModel::findOrFail($id);
        $tm = $exercicio->id_turma;
        $exercicio->delete();
        flash('Exercício foi removido da turma com sucesso!')->success();
        return redirect()->route('turma.show', $tm);
    }


    public function redefinirsenha($id){
        $aluno = AlunosModel::findOrFail($id);
        $nome = $aluno->nome;
        $novaSenha = uniqid();
        $aluno->senha = md5($novaSenha);
        $aluno->save();
        flash("Senha de $nome Redefinida, nova senha é: $novaSenha")->important();
        return redirect()->route('aluno.index');
    }

    public function meditacao($id){
        $url = MeditacaoModel::where("categoria", $id)->orderByRaw('RAND()')->take(1)->first();
            return view("meditacao", compact('url'));
    }

}
