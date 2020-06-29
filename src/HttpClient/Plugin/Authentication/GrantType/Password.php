<?php
declare(strict_types=1);

namespace Greenchoice\HttpClient\Plugin\Authentication\GrantType;

use Greenchoice\HttpClient\Plugin\Authentication\GrantType;

final class Password implements GrantType
{
    public function getKey(): string
    {
        return 'password';
    }
}
