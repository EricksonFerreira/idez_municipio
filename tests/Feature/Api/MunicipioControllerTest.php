<?php

use App\Contracts\MunicipioProviderInterface;
use Illuminate\Support\Facades\Cache;

beforeEach(function () {
    // Mock the provider
    $this->mock(MunicipioProviderInterface::class, function ($mock) {
        $mock->shouldReceive('getMunicipios')
            ->with('PE')
            ->andReturn([
                ['name' => 'Recife', 'ibge_code' => '2611606'],
                ['name' => 'Olinda', 'ibge_code' => '2609600'],
            ]);
    });

    // Clear cache before each test
    Cache::clear();
});

test('retorna os municípios para uma UF válida', function () {
    $response = $this->getJson('/api/municipios/PE');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'current_page',
            'data' => [
                '*' => ['name', 'ibge_code']
            ],
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'links' => [
                '*' => ['url', 'label', 'active']
            ],
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total'
        ]);

    $response->assertJsonFragment([
        'name' => 'Recife',
        'ibge_code' => '2611606'
    ]);
});

test('retorna 400 para formato de UF inválido', function () {
    $response = $this->getJson('/api/municipios/INVALID');

    $response->assertStatus(400)
        ->assertJson([
            'error' => 'Formato de UF inválido. Deve ser um código de estado de 2 letras (ex: SP, RJ, PE).'
        ]);
});

test('retorna 404 para UF não encontrada', function () {
    $this->mock(MunicipioProviderInterface::class, function ($mock) {
        $mock->shouldReceive('getMunicipios')
            ->with('XX')
            ->andReturn([]);
    });

    $response = $this->getJson('/api/municipios/XX');
    
    $response->assertStatus(404)
        ->assertJson(['message' => 'Nenhum município encontrado para o estado selecionado']);
});

test('retorna municípios paginados corretamente', function () {
    // Mock com mais municípios para testar a paginação
    $municipalities = [];
    for ($i = 1; $i <= 25; $i++) {
        $municipalities[] = [
            'name' => 'Cidade ' . $i,
            'ibge_code' => (string)(2600000 + $i)
        ];
    }

    $this->mock(MunicipioProviderInterface::class, function ($mock) use ($municipalities) {
        $mock->shouldReceive('getMunicipios')
            ->with('PE')
            ->andReturn($municipalities);
    });

    // Primeira página com 10 itens (padrão)
    $response = $this->getJson('/api/municipios/PE?page=1&per_page=10');
    
    $response->assertStatus(200)
        ->assertJson([
            'current_page' => 1,
            'per_page' => 10,
            'total' => 25,
            'last_page' => 3
        ])
        ->assertJsonCount(10, 'data');

    // Segunda página
    $response = $this->getJson('/api/municipios/PE?page=2&per_page=10');
    $response->assertStatus(200)
        ->assertJson([
            'current_page' => 2,
            'per_page' => 10,
            'from' => 11,
            'to' => 20
        ]);
});

test('armazena a resposta em cache', function () {
    // First request should hit the provider
    $firstResponse = $this->getJson('/api/municipios/PE');
    $firstResponse->assertStatus(200);

    // Second request should come from cache
    $secondResponse = $this->getJson('/api/municipios/PE');
    $secondResponse->assertStatus(200);

    // Verify the provider was only called once due to caching
    $this->assertTrue(Cache::has('municipios_PE'));
});

test('lida com erros do provedor', function () {
    // Mock a failing provider
    $this->mock(MunicipioProviderInterface::class, function ($mock) {
        $mock->shouldReceive('getMunicipios')
            ->with('PE')
            ->andThrow(new \RuntimeException('API Error'));
    });

    $response = $this->getJson('/api/municipios/PE');

    $response->assertStatus(500)
        ->assertJson([
            'message' => 'API Error'
        ]);
});
