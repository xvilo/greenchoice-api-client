<?php
declare(strict_types=1);

namespace Greenchoice\Api;

class Customer extends AbstractApi
{
    public function getContracts()
    {
        return $this->get('/api/v1/klant/getovereenkomsten');
    }
}
