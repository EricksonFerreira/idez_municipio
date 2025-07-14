<?php

namespace App\Contracts;

interface MunicipioProviderInterface
{
    public function getMunicipios(string $uf): array;
}
