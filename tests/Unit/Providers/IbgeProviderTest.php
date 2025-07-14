<?php

namespace Tests\Unit\Providers;

use App\Services\Providers\IbgeProvider;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class IbgeProviderTest extends TestCase
{
    private IbgeProvider $provider;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->provider = new IbgeProvider();
    }

    /** @test */
    public function retorna_municipios_para_uma_uf_valida()
    {
        Http::fake([
            'servicodados.ibge.gov.br/api/v1/localidades/estados/PE/municipios' => Http::response([
                ['id' => 1, 'nome' => 'Recife'],
                ['id' => 2, 'nome' => 'Olinda'],
            ]),
        ]);

        $municipalities = $this->provider->getMunicipios('PE');

        $this->assertIsArray($municipalities);
        $this->assertCount(2, $municipalities);
        $this->assertEquals([
            'name' => 'Recife',
            'ibge_code' => 1
        ], $municipalities[0]);
    }

    /** @test */
    public function lida_com_erros_da_api_adequadamente()
    {
        Http::fake([
            'servicodados.ibge.gov.br/api/v1/localidades/estados/PE/municipios' => Http::response([], 500),
        ]);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Failed to fetch municipalities from IBGE: 500');
        
        $this->provider->getMunicipios('PE');
    }
}
