<?php

namespace App\Service;

interface ApiClientInterface
{
    public function getData(string $url): array;
}
