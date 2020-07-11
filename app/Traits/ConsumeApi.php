<?php


namespace App\Traits;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;

trait ConsumeApi
{
    public function sendRequest($method, $request_url, $params=[], $headers=[])
    {
        $client = new Client([
            'base_uri' => $this->base_url,
        ]);

        try {
            $response = $client->request($method, $request_url, [
                'form_params' => $params,
                'headers'     => $headers
            ]);

            return [
                'content' => $response->getBody()->getContents(),
                'code'    => $response->getStatusCode()
            ];
        } catch (ClientException $e) {
            $response = $e->getResponse();

            return [
                'content' => $response->getBody()->getContents(),
                'code'    => $response->getStatusCode()
            ];
        } catch (ServerException $e) {
            $response = $e->getResponse();

            return [
                'content' => $response->getBody()->getContents(),
                'code'    => $response->getStatusCode()
            ];
        } catch (BadResponseException $e) {
            $response = $e->getResponse();

            return [
                'content' => $response->getBody()->getContents(),
                'code'    => $response->getStatusCode()
            ];
        } catch (GuzzleException $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }
}
