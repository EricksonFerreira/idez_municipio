<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Contracts\MunicipioProviderInterface;
use App\Exceptions\ExternalApiException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class MunicipioController extends Controller
{
    public function index(string $uf, MunicipioProviderInterface $provider, Request $request)
    {
        try {
            // Validate UF (should be 2 characters)
            $uf = strtoupper(trim($uf));
            if (strlen($uf) !== 2) {
                return response()->json([
                    'error' => 'Invalid UF format. Must be a 2-letter state code (e.g., SP, RJ, PE).'
                ], 400);
            }
            
            // 1. Cache dos municípios
            $data = Cache::remember("municipios_{$uf}", 3600, function () use ($provider, $uf) {
                return $provider->getMunicipios($uf);
            });

            // Verifica se há municípios para a UF
            if (empty($data)) {
                return response()->json([
                    'message' => 'No municipalities found for the given UF'
                ], 404);
            }
    
            // 2. Paginação
            $page = max(1, (int) $request->get('page', 1));
            $perPage = min(100, max(1, (int) $request->get('per_page', 10)));
            $offset = ($page - 1) * $perPage;
    
            $paginated = new LengthAwarePaginator(
                array_slice($data, $offset, $perPage),
                count($data),
                $perPage,
                $page,
                [
                    'path' => $request->url(),
                    'query' => $request->query()
                ]
            );
    
            return response()->json($paginated);
    
        } catch (\RuntimeException $e) {
            Log::error('Error in MunicipioController: ' . $e->getMessage());
            throw new ExternalApiException($e->getMessage());
        } catch (\Throwable $e) {
            Log::error('Unexpected error in MunicipioController: ' . $e->getMessage());
            throw new ExternalApiException('Erro ao consultar a API de municípios');
        }
    }
}
