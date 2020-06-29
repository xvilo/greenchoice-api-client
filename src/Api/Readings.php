<?php
declare(strict_types=1);

namespace Greenchoice\Api;

class Readings extends AbstractApi
{
    public function getCounter($id)
    {
        return $this->get('/api/v2/meterstanden/gettelwerken', [
            'overeenkomstId' => $id
        ]);
    }

    public function getData($id)
    {
        return $this->get('/api/v2/meterstanden/getstanden', [
            'overeenkomstId' => $id
        ]);
    }
}
