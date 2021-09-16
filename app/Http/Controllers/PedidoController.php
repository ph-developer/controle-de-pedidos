<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Carbon\Carbon;
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
        $request = $this->parseRequestDates($request);

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
        $request = $this->parseRequestDates($request);

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
        $request = $this->parseRequestDates($request);

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

    /**
     * Converte o formato das datas do Request para o padrão do banco de dados.
     *
     * @param Request $request
     * @return Request
     */
    public function parseRequestDates(Request $request)
    {
        if ($request->dataChegada) {
            $dataChegada = Carbon::createFromFormat('d/m/Y', $request->dataChegada);
            $dataChegada->setHour(0)->setMinutes(0)->setSeconds(0)->setMicroseconds(0);
            $request->merge(['dataChegada' => $dataChegada]);
        }
        if ($request->dataEnvioFinanceiro) {
            $dataEnvioFinanceiro = Carbon::createFromFormat('d/m/Y', $request->dataEnvioFinanceiro);
            $dataEnvioFinanceiro->setHour(0)->setMinutes(0)->setSeconds(0)->setMicroseconds(0);
            $request->merge(['dataEnvioFinanceiro' => $dataEnvioFinanceiro]);
        }
        if ($request->dataRetornoFinanceiro) {
            $dataRetornoFinanceiro = Carbon::createFromFormat('d/m/Y', $request->dataRetornoFinanceiro);
            $dataRetornoFinanceiro->setHour(0)->setMinutes(0)->setSeconds(0)->setMicroseconds(0);
            $request->merge(['dataRetornoFinanceiro' => $dataRetornoFinanceiro]);
        }

        return $request;
    }
}
