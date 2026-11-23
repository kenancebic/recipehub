<?php

declare(strict_types=1);

class ExternalApiService
{
    private string $apiKey;
    private string $baseUrl = 'https://www.themealdb.com/api/json/v1/';
    private string $logFile;

    public function __construct()
    {
        $config = require __DIR__ . '/../config/config.php';

        $this->apiKey = (string) (
            $config['external_api']['themealdb_api_key'] ?? ''
        );

        $this->logFile = __DIR__ . '/../logs/external_api.log';

        if ($this->apiKey === '') {
            throw new RuntimeException('External API key is not configured.');
        }
    }

    public function searchMeals(string $query): array
    {
        $query = trim($query);

        if ($query === '') {
            throw new InvalidArgumentException('Search query cannot be empty.');
        }

        $url = $this->baseUrl
            . rawurlencode($this->apiKey)
            . '/search.php?s='
            . urlencode($query);

        $curl = curl_init($url);

        if ($curl === false) {
            $this->logError('Could not initialize cURL.');
            throw new RuntimeException('Recipe search is temporarily unavailable.');
        }

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
        ]);

        $response = curl_exec($curl);
        $curlError = curl_error($curl);
        $httpStatus = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($response === false) {
            $this->logError('cURL request failed: ' . $curlError);
            throw new RuntimeException('Recipe search is temporarily unavailable.');
        }

        if ($httpStatus !== 200) {
            $this->logError('TheMealDB returned HTTP status ' . $httpStatus);
            throw new RuntimeException('Recipe search is temporarily unavailable.');
        }

        $data = json_decode($response, true);

        if (!is_array($data) || !array_key_exists('meals', $data)) {
            $this->logError('TheMealDB returned an invalid JSON response.');
            throw new RuntimeException('Invalid response from recipe provider.');
        }

        return $data['meals'] ?? [];
    }

    private function logError(string $message): void
    {
        $logDirectory = dirname($this->logFile);

        if (!is_dir($logDirectory)) {
            mkdir($logDirectory, 0775, true);
        }

        $entry = '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL;

        error_log($entry, 3, $this->logFile);
    }
}
