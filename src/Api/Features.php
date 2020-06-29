<?php
declare(strict_types=1);

namespace Greenchoice\Api;

use Greenchoice\HttpClient\Plugin\Authentication\GrantType;
use function GuzzleHttp\Psr7\build_query;

class Features extends AbstractApi
{
    public function getByWarrantId($id)
    {
        return $this->get('/api/v1/features/beschikbaar', [
            'overeenkomstId' => $id
        ]);
    }
}
