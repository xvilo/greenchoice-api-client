<?php
declare(strict_types=1);

namespace Greenchoice\Api;

use Greenchoice\HttpClient\Plugin\Authentication\GrantType;
use function GuzzleHttp\Psr7\build_query;

class Warrants extends AbstractApi
{
    public function getApproved($id)
    {
        return $this->get('/api/v2/machtigingen/geaccordeerd', [
            'overeenkomstId' => $id
        ]);
    }
}
