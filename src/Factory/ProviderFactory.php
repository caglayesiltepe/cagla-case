<?php

namespace App\Factory;

use App\Enum\ProviderEnum;
use App\Service\ApiService;
 class ProviderFactory{
     private ApiService $apiService;

     public function __construct(ApiService $apiService)
     {
         $this->apiService = $apiService;
     }
     public function getProviderList(string $provider): array
     {
         if (!isset(ProviderEnum::$providerUrls[$provider])) {
             throw new \InvalidArgumentException("Invalid provider:".$provider);
         }

         return $this->apiService->getData(ProviderEnum::$providerUrls[$provider]);
     }
 }