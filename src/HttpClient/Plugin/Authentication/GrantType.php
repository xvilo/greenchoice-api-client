<?php
declare(strict_types=1);

namespace Greenchoice\HttpClient\Plugin\Authentication;

interface GrantType
{
    public function getKey(): string;
}
