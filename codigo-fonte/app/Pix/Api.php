<?php

namespace App\Pix;

class Api
{

  /**
   * URL base do PSP(provedor de serviço de pagamento) Gerencianet
   * @var string
   */
  private $baseUrl;

  /**
   * Client ID do oAuth2 do PSP
   * @var string
   */
  private $clientId;

  /**
   * Client secret do oAuth2 do PSP
   * @var string
   */
  private $clientSecret;

  /**
   * Caminho absoluto até o arquivo do certificado
   *
   * @var string
   */
  private $certificate;

  /**
   * Define os dados iniciais da classe
   * @param string $baseUrl
   * @param string $clientId
   * @param string $clientSecret
   * @param string $certificate
   */
  public function __construct($baseUrl, $clientId, $clientSecret, $certificate)
  {
    $this->baseUrl = $baseUrl;
    $this->clientId = $clientId;
    $this->clientSecret = $clientSecret;
    $this->certificate = $certificate;
  }

  /**
   * 
   * Método responsável por criar uma cobrança imediata.
   * @param string $txid
   * @param array $request
   * @return array
   */
  public function createCob($txid, $request)
  {
    return $this->send('PUT', '/v2/cob/' . $txid, $request);
  }

  /**
   * Método responsável por obter o token de acesso às APIs Pix
   *
   * @return string
   */
  private function getAccessToken()
  {
    //Obtendo o endpoint completo
    $endpoint = $this->baseUrl . '/oauth/token';

    //Headers
    $headers = [
      'Content-Type: application/json'
    ];

    //Corpo da requisição
    $request = [
      'grant_type' => 'client_credentials'
    ];

    //Configuração do curl
    $curl = curl_init();
    curl_setopt_array($curl, [
      CURLOPT_URL => $endpoint,
      CURLOPT_USERPWD => $this->clientId . ':' . $this->clientSecret,
      CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => json_encode($request),
      CURLOPT_SSLCERT => $this->certificate,
      CURLOPT_SSLCERTPASSWD => '',
      CURLOPT_HTTPHEADER => $headers
    ]);

    //Executa o CURL
    $response = curl_exec($curl);
    curl_close($curl);

    /* echo "<pre>";
    print_r($response);
    echo "</pre>";
    exit; */

    //Response em array
    //O "true" força para que a resposta seja um array.
    $responseArray = json_decode($response, true);

    //Retorna o access token
    return $responseArray['access_token'] ?? '';
  }

  /**
   * 
   * Método responsável por enviar a requisição ao PSP gerencianet
   * @param string $method
   * @param string $resource
   * @param array $request
   * @return array
   */
  private function send($method, $resource, $request = [])
  {
    //Endpoint completo
    $endpoint = $this->baseUrl . $resource;

    /* echo "<pre>";
    print_r($endpoint);
    echo "</pre>";
    exit; */

    //Headers
    $headers = [
      'Cache-control: no-cache',
      'Content-type: application/json',
      'Authorization: Bearer ' . $this->getAccessToken()
    ];

     /* echo "<pre>";
    print_r($headers);
    echo "</pre>";
    exit; */

    //Configuração do curl
    $curl = curl_init();
    curl_setopt_array($curl, [
      CURLOPT_URL => $endpoint,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_CUSTOMREQUEST => $method,
      CURLOPT_SSLCERT => $this->certificate,
      CURLOPT_SSLCERTPASSWD => '',
      CURLOPT_HTTPHEADER => $headers
    ]);

    switch ($method) {
      case 'POST':
      case 'PUT':
        curl_setopt($curl, CURLOPT_POSTFIELDS,json_encode($request));
        break;
    }

    //Executa o CURL
    $response = curl_exec($curl);
    curl_close($curl);

    echo "<pre>";
    print_r($response);
    echo "</pre>";
    exit;
  }
}
