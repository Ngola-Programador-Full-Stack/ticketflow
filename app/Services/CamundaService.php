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
        $this->clientId     = env('CAMUNDA_CLIENT_ID');
        $this->clientSecret = env('CAMUNDA_CLIENT_SECRET');
        $this->zeebeAddress = env('CAMUNDA_ZEEBE_ADDRESS');
        $this->oauthUrl     = env('CAMUNDA_OAUTH_URL');
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

        $response = Http::withoutVerifying()
            ->withToken($token)
            ->asJson()
            ->post($this->zeebeAddress . '/v2/process-instances', [
                'bpmnProcessId' => 'Process_0dv1u4g',
                'version'       => -1,
                'variables'     => $variaveis,
            ]);

        \Log::info('Camunda response', [
            'status' => $response->status(),
            'body'   => $response->json(),
        ]);

        if ($response->failed()) {
            \Log::error('Camunda error', ['body' => $response->body()]);
            return [];
        }

        return $response->json();
    }
}
