<?php
declare(strict_types=1);

namespace Greenchoice\Api;

use DateTimeInterface;
use Greenchoice\Client;

class Usages extends AbstractApi
{
    public function getUsagePeriods(
        int $contractId,
        DateTimeInterface $startDate,
        DateTimeInterface $endDate,
        bool $isGas = false,
        int $year = 0,
        int $month = 0
    ): ?array {
        $formattedStartDate = $startDate->format(Client::DATE_FORMAT);
        $formattedEndDate   = $endDate->format(Client::DATE_FORMAT);

        $data = $this->get('/api/v2/verbruik/getverbruikperiodes', [
            'overeenkomstId' => $contractId,
            'startDate' => $formattedStartDate,
            'endDate' => $formattedEndDate,
            'year' => $year,
            'isGas' => $isGas ? 'true' : 'false',
            'month' => $month,
        ]);

        return $data === '' ? null : $data;
    }
}
