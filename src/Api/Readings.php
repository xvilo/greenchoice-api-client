<?php
declare(strict_types=1);

namespace Greenchoice\Api;

class Readings extends AbstractApi
{
    public function getCounters(int $contractId)
    {
        return $this->get('/api/v2/meterstanden/gettelwerken', [
            'overeenkomstId' => $contractId
        ]);
    }

    public function getCounterData(int $contractId)
    {
        return $this->get('/api/v2/meterstanden/getstanden', [
            'overeenkomstId' => $contractId
        ]);
    }
}
