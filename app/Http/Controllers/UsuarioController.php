<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class UsuarioController extends Controller
{
    /**
     * Retorna todos os usuários existentes no banco de dados.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $usuarios = Usuario::where(array_filter($request->all()))->get();

        return response()->json(compact('usuarios'));
    }

    /**
     * Cria e salva um novo usuário no banco de dados.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(Request $request): JsonResponse
    {
        $request = $this->encryptSenha($request);
        $usuario = new Usuario($request->all());
        $usuario->saveOrFail();

        return response()->json(compact('usuario'));
    }

    /**
     * Busca um usuário no banco de dados.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $usuario = Usuario::findOrFail($id);

        return response()->json(compact('usuario'));
    }

    /**
     * Atualiza o usuário no banco de dados.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $request = $this->encryptSenha($request);
        $usuario = Usuario::findOrFail($id);
        $usuario->updateOrFail($request->all());

        return response()->json(compact('usuario'));
    }

    /**
     * Exclui o usuário do banco de dados.
     *
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(int $id): JsonResponse
    {
        $usuario = Usuario::findOrFail($id);
        $result = $usuario->delete();

        return response()->json(compact('result'));
    }

    /**
     * Encripta o valor 'senha' quando o request contiver o referido valor.
     *
     * @param Request $request
     * @return Request
     */
    public function encryptSenha(Request $request): Request
    {
        if ($request->has('senha')) {
            $request->merge([
                'senha' => bcrypt($request->get('senha')),
            ]);
        }
        return $request;
    }
}
