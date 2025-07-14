<?php

namespace App\Services\Providers;

use Illuminate\Support\Facades\Http;
use App\Contracts\MunicipioProviderInterface;

class BrasilApiProvider implements MunicipioProviderInterface
{
    public function getMunicipios(string $uf): array
    {
        try {
            $response = Http::withOptions([
                'verify' => app()->environment('production') ? true : false,
                'timeout' => 15,
            ])->get("https://brasilapi.com.br/api/ibge/municipios/v1/" . strtoupper($uf));

            if ($response->successful()) {
                return collect($response->json())->map(function ($item) {
                    return [
                        'name' => $item['nome'] ?? null,
                        'ibge_code' => $item['codigo_ibge'] ?? null,
                    ];
                })->filter()->toArray();
            }

            throw new \RuntimeException("Failed to fetch municipalities: " . $response->status());

        } catch (\Exception $e) {
            // Log the error or handle it as needed
            throw new \RuntimeException("Error fetching municipalities: " . $e->getMessage());
        }
    }
}
