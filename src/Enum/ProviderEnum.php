<?php
namespace App\Enum;

class ProviderEnum
{
    // Operation Status Constants
    public const FAILURE = 0;
    public const SUCCESS = 1;

    // Provider Names Constants
    public const TASKS = 'tasks';
    public const DEVELOPERS = 'developers';

    // Provider URLs
    public static array $providerUrls = [
        self::TASKS => 'https://raw.githubusercontent.com/WEG-Technology/mock/main/mock-one',
        self::DEVELOPERS => 'https://raw.githubusercontent.com/WEG-Technology/mock/main/mock-two',
    ];
}
