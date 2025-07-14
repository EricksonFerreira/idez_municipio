<?php

namespace Tests\Unit\Providers;

use App\Services\Providers\BrasilApiProvider;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class BrasilApiProviderTest extends TestCase
{
    private BrasilApiProvider $provider;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->provider = new BrasilApiProvider();
    }

    /** @test */
    public function retorna_municipios_para_uma_uf_valida()
    {
        Http::fake([
            'brasilapi.com.br/api/ibge/municipios/v1/PE' => Http::response([
                ['nome' => 'Recife', 'codigo_ibge' => '2611606'],
                ['nome' => 'Olinda', 'codigo_ibge' => '2609600'],
            ]),
        ]);

        $municipalities = $this->provider->getMunicipios('PE');

        $this->assertIsArray($municipalities);
        $this->assertCount(2, $municipalities);
        $this->assertEquals([
            'name' => 'Recife',
            'ibge_code' => '2611606'
        ], $municipalities[0]);
    }

    /** @test */
    public function lida_com_erros_da_api_adequadamente()
    {
        Http::fake([
            'brasilapi.com.br/api/ibge/municipios/v1/PE' => Http::response([], 500),
        ]);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Error fetching municipalities: Failed to fetch municipalities: 500');
        
        $this->provider->getMunicipios('PE');
    }
}
