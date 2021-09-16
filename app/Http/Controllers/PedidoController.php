<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class PedidoController extends Controller
{
    /**
     * Retorna todos os pedidos existentes no banco de dados.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $pedidos = Pedido::where(array_filter($request->all()))->get();

        return response()->json(compact('pedidos'));
    }

    /**
     * Cria e salva um novo pedido no banco de dados.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(Request $request): JsonResponse
    {
        $pedido = new Pedido($request->all());
        $pedido->saveOrFail();

        return response()->json(compact('pedido'));
    }

    /**
     * Busca um pedido no banco de dados.
     *
     * @param string $tipo
     * @param string $numero
     * @return JsonResponse
     */
    public function show(string $tipo, string $numero): JsonResponse
    {
        $pedido = Pedido::where([
            'tipo' => $tipo,
            'numero' => $numero,
        ])->firstOrFail();

        return response()->json(compact('pedido'));
    }

    /**
     * Atualiza o pedido no banco de dados.
     *
     * @param Request $request
     * @param string $tipo
     * @param string $numero
     * @return JsonResponse
     */
    public function update(Request $request, string $tipo, string $numero): JsonResponse
    {
        $pedido = Pedido::where([
            'tipo' => $tipo,
            'numero' => $numero,
        ])->firstOrFail();
        $pedido->updateOrFail($request->all());

        return response()->json(compact('pedido'));
    }

    /**
     * Exclui o pedido do banco de dados.
     *
     * @param string $tipo
     * @param string $numero
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(string $tipo, string $numero): JsonResponse
    {
        $pedido = Pedido::where([
            'tipo' => $tipo,
            'numero' => $numero,
        ])->firstOrFail();
        $result = $pedido->delete();

        return response()->json(compact('result'));
    }
}
