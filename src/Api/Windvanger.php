<?php
declare(strict_types=1);

namespace Greenchoice\Api;

use DateTimeInterface;
use Greenchoice\Client;

class Windvanger extends AbstractApi
{
    /**
     * @param $contractId int
     * @param $id2 string At this point in time, it's unknown what ID this is.
     * @param DateTimeInterface $date
     * @return array|string
     */
    public function getGenerated(int $contractId, string $id2, DateTimeInterface $date)
    {
        $formattedDate = $date->format(Client::DATE_FORMAT);

        return $this->get(sprintf("/api/windvanger/opwek/%s/%s/PerDag/%s", $id2, $contractId, $formattedDate));
    }
}
