<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use Illuminate\Http\Request;
use App\Models\Formulario;
use App\Models\PreguntaFormulario;
use App\Models\Token;
use App\Models\Pregunta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FormularioController extends Controller
{
    // Mostrar todos los formularios
    public function index()
    {
        // Traemos todos los formularios con sus preguntas
        $formularios = Formulario::with('preguntas')->get();
        return view("formRese", compact('formularios'));
    }

    public function show(Request $request)
    {
        return Formulario::find($request->get('token'));
    }

    // Guardar un nuevo formulario
    public function store(Request $request)
    {
        try {
            // Creación del token para empresa
            $token = new Token();
            $token->token = $token->createToken('token_form');
            $token->save();

            // Creación del token para alumno
            $token_a = new Token();
            $token_a->token = $token_a->createToken('token_form');
            $token_a->save();

            // Creación del formulario de empresa
            $formulario = new Formulario();
            $formulario->nombre = $request->get('nombre');
            $formulario->definicion = 'Formulario para la empresa '.$request->get('nombre');
            $formulario->tipo = 'empresa';
            $formulario->id_token = $token['id'];
            $formulario->save();

            // Creación del formulario del alumno
            $formulario_a = new Formulario();
            $formulario_a->nombre = 'Alumno de '.$request->get('nombre');
            $formulario_a->definicion = 'Formulario para el alumno de la empresa '.$request->get('nombre');
            $formulario_a->tipo = 'alumno';
            $formulario_a->id_token = $token_a['id'];
            $formulario_a->save();

            // Asignación de las preguntas del formulario de la empresa (order = 1)
            $preguntas = Pregunta::All()->where('order', 1);
            foreach($preguntas as $pregunta){
                $pregunta_formulario = new PreguntaFormulario();
                $pregunta_formulario->id_formulario = $formulario['id'];
                $pregunta_formulario->id_pregunta = $pregunta['id'];
                $pregunta_formulario->save();
            }

            // Asignación de las preguntas del formulario del alumno (order = 2)
            $preguntas_a = Pregunta::All()->where('order', 2);
            foreach($preguntas_a as $pregunta){
                $pregunta_formulario = new PreguntaFormulario();
                $pregunta_formulario->id_formulario = $formulario_a['id'];
                $pregunta_formulario->id_pregunta = $pregunta['id'];
                $pregunta_formulario->save();
            }

            $empresas = Empresa::paginate(10);
            return view('/empresas', compact(['empresas', 'token', 'token_a']))->with('success', 'Formularios creados correctamente');

        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'No pude guardar el formulario :(',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $formulario = Formulario::findOrFail($id);
        $formulario->update($request->all());
        return $formulario;
    }

    public function delete($id)
    {
        $formulario = Formulario::findOrFail($id);
        $formulario->delete();
        return 204;
    }

    // Obtener preguntas por token
    public function getPreguntasByToken($token)
    {
        try {
            $tokenData = DB::select("SELECT * FROM tokens WHERE token = ?", [$token]);

            if (empty($tokenData)) {
                return response()->json([
                    'message' => 'Token no encontrado',
                    'token' => $token
                ], 404);
            }

            $tokenData = $tokenData[0];
            
            $formulario = DB::table('formularios')
                ->where('id_token', $tokenData->id)
                ->first();

            if (!$formulario) {
                return response()->json([
                    'message' => 'Formulario no encontrado',
                    'token_id' => $tokenData->id
                ], 404);
            }

            $preguntas = DB::table('preguntas as p')
                ->select(
                    'p.id',
                    'p.titulo as question',
                    'p.tipo as type',
                    'pf.id as pregunta_formulario_id'
                )
                ->join('preguntaformulario as pf', 'p.id', '=', 'pf.id_pregunta')
                ->join('formularios as f', 'pf.id_formulario', '=', 'f.id')
                ->where('f.id', $formulario->id)
                ->get();

            return response()->json($preguntas);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error en el servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getQuestionsByToken($token)
    {
        $formulario = Formulario::where('token', $token)->firstOrFail();
        $preguntas = $formulario->preguntas()->get();
        
        return response()->json($preguntas);
    }

    public function submitAnswers($token, Request $request)
    {
        try {
            $tokenData = DB::table('tokens')
                ->where('token', $token)
                ->first();

            if (!$tokenData) {
                return response()->json([
                    'message' => 'Token no encontrado',
                    'token' => $token
                ], 404);
            }

            $formulario = DB::table('formularios')
                ->where('id_token', $tokenData->id)
                ->first();

            if (!$formulario) {
                return response()->json([
                    'message' => 'Formulario no encontrado',
                    'token_id' => $tokenData->id
                ], 404);
            }

            $fechaActual = date('Y-m-d H:i:s');

            foreach ($request->answers as $answer) {
                // Obtener el id_pregunta_formulario
                $preguntaFormulario = DB::table('preguntaformulario')
                    ->where('id_pregunta', $answer['pregunta_id'])
                    ->where('id_formulario', $formulario->id)
                    ->first();

                if ($preguntaFormulario) {
                    // Obtener el tipo de pregunta
                    $tipoPregunta = DB::table('preguntas')
                        ->where('id', $answer['pregunta_id'])
                        ->value('tipo');

                    // Guardar la respuesta según el tipo
                    DB::table('resenyas')->insert([
                        'fecha_resena' => $fechaActual,
                        'valoracion' => $answer['respuesta'],
                        'id_pregunta_formulario' => $preguntaFormulario->id
                    ]);
                }
            }

            return response()->json([
                'message' => 'Reseñas guardadas correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al guardar las reseñas',
                'error' => $e->getMessage(),
                'data' => [
                    'fecha' => $fechaActual,
                    'request' => $request->all()
                ]
            ], 500);
        }
    }
}
