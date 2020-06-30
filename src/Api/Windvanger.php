<?php
declare(strict_types=1);

namespace Greenchoice\Api;

use DateTimeInterface;
use Greenchoice\Client;

class Windvanger extends AbstractApi
{
    /**
     * @param $contractId int
     * @param $customerId int
     * @param DateTimeInterface $date
     * @return array|string
     */
    public function getGenerated(int $contractId, int $customerId, DateTimeInterface $date)
    {
        $formattedDate = $date->format(Client::DATE_FORMAT);
        die(var_dump(sprintf("/api/windvanger/opwek/%s/%s/PerDag/%s", $customerId, $contractId, $formattedDate)));
        return $this->get(sprintf("/api/windvanger/opwek/%s/%s/PerDag/%s", $customerId, $contractId, $formattedDate));
    }
}
