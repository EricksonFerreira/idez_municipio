<?php

namespace App\Services\Providers;

use Illuminate\Support\Facades\Http;
use App\Contracts\MunicipioProviderInterface;

class IbgeProvider implements MunicipioProviderInterface
{
    public function getMunicipios(string $uf): array
    {
        try {
            $response = Http::withOptions([
                'verify' => app()->environment('production') ? true : false,
                'timeout' => 15,
            ])->get("https://servicodados.ibge.gov.br/api/v1/localidades/estados/{$uf}/municipios");

            if ($response->successful()) {
                return collect($response->json())->map(function ($item) {
                    return [
                        'name' => $item['nome'] ?? null,
                        'ibge_code' => $item['id'] ?? null
                    ];
                })->filter()->toArray();
            }

            throw new \RuntimeException("Failed to fetch municipalities from IBGE: " . $response->status());

        } catch (\Exception $e) {
            // Log the error or handle it as needed
            throw new \RuntimeException("Error fetching municipalities from IBGE: " . $e->getMessage());
        }
    }
}
