<?php

namespace App\Tools;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

/**
 * @property string html
 */
class Pdf
{
    /**
     * PdfHelper constructor.
     *
     * @param string $html
     */
    public function __construct(string $html)
    {
        $this->html = $html;
    }

    /**
     * @return null
     */
    public function render()
    {
        $client = new Client(['base_uri' => env('PDF_SERVICE_URL')]);
        $fileHandler = tmpfile();
        fwrite($fileHandler, $this->html);
        rewind($fileHandler);

        try {
            $response = $client->post(
                '/convert?auth=' . env('PDF_SERVICE_AUTH'),
                [
                    'multipart' => [
                        [
                            'name' => 'file',
                            'contents' => $fileHandler,
                        ]
                    ]
                ]
            );
            return $response->getBody();
        } catch (ClientException $e) {
            Log::error($e->getMessage());
            dd($e->getMessage(),1);
        } catch (RequestException $e) {
            Log::error($e->getMessage());
            $response = $e->getResponse();
            dd($response,2);
        }
    }
}
