<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CamundaService
{
    private string $clientId;
    private string $clientSecret;
    private string $zeebeAddress;
    private string $oauthUrl;

    public function __construct()
    {
        $this->clientId     = config('services.camunda.client_id') ?? env('CAMUNDA_CLIENT_ID');
        $this->clientSecret = config('services.camunda.client_secret') ?? env('CAMUNDA_CLIENT_SECRET');
        $this->zeebeAddress = config('services.camunda.zeebe_address') ?? env('CAMUNDA_ZEEBE_ADDRESS');
        $this->oauthUrl     = config('services.camunda.oauth_url') ?? env('CAMUNDA_OAUTH_URL');
    }

    private function getToken(): string
    {
        return Cache::remember('camunda_token', 3500, function () {
            $response = Http::withoutVerifying()
                ->asForm()
                ->post($this->oauthUrl, [
                    'grant_type'    => 'client_credentials',
                    'client_id'     => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'audience'      => 'zeebe.camunda.io',
                ]);
            return $response->json('access_token');
        });
    }

    public function iniciarProcesso(array $variaveis): array
    {
        $token = $this->getToken();

        error_log('Camunda zeebe address: ' . $this->zeebeAddress);
        error_log('Camunda token length: ' . strlen($token ?? ''));

        $response = Http::withoutVerifying()
            ->withToken($token)
            ->asJson()
            ->post($this->zeebeAddress . '/v2/process-instances', [
                'processDefinitionId' => 'Process_0dv1u4g',
                'variables'           => $variaveis,
        ]);

        error_log('Camunda status: ' . $response->status());
        error_log('Camunda body: ' . $response->body());

        if ($response->failed()) {
            return [];
        }

        return $response->json();
    }
}
