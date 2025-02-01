<?php

namespace App\Service;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DomCrawler\Crawler;

 class ServerSenderService
{
    public function headerBuilder($headers): array
    {
        $header = [];
        try{
            if(isset($headers['Set-Cookie'])){
                $header['Cookie'] = explode(';',$headers['Set-Cookie'][0])[0].';'.explode(';',$headers['Set-Cookie'][1])[0];
                $header['Content-Type'] = "application/x-www-form-urlencoded";
                $header['Accept'] = "*/*";
                return $header;
            }
            return $header;
        }catch (\Exception $e)
        {
            $header['error'] = $e->getMessage();
            return $header;
        }
    }

    public function imageConvert($imagePath): string
    {
        // Путь к изображению
        //$imagePath = 'path/to/your/image.jpg';

        // Проверьте, существует ли файл
        if (file_exists($imagePath)) {
            // Получить содержимое файла
            $imageData = file_get_contents($imagePath);

            // Преобразовать содержимое в Base64
            $base64 = base64_encode($imageData);

            // Определить MIME-тип файла (например, image/jpeg)
            $mimeType = mime_content_type($imagePath);

            // Создать строку Base64 с указанием MIME-типа
            $base64Image = 'data:' . $mimeType . ';base64,' . $base64;

            // Вывод или использование строки Base64
            return $base64Image;
        } else {
            return 'Файл не найден.';
        }
    }

     /**
      * @throws \GuzzleHttp\Exception\GuzzleException
      */
     public function sendStore($data): ResponseInterface
    {
        //$debugFile = fopen('debug.log', 'a');
        $client = new Client(['timeout'  => 10.0, 'verify' => false]);
        $response = $client->get('https://auto.customs.gov.kg/ru');
        $headers = $response->getHeaders();
        $crawler = new Crawler($response->getBody()->getContents());
        $token = $crawler->filter('input[name="_token"]')->attr('value');

        return $client->post('https://auto.customs.gov.kg/ru/store',[
            'headers' => $this->headerBuilder($headers),
            'form_params' => [
                '_token' => $token,
                'arrival_date' => $data->arrival_date,
                'custom' => $data->custom,
                'vehicle_number' => $data->vehicle_number,
                'vehicle_country' => $data->vehicle_country,
                'vehicle_type' => $data->vehicle_type,
                'vehicle_vin_type' => $data->vehicle_vin_type,
                'vehicle_vin' => $data->vehicle_brand,
                'vehicle_brand' => $data->custom,
                'vehicle_model' => $data->vehicle_model,
                'vehicle_photo' => 'sss.jpg',
                'vehicle_photo' => $this->imageConvert('C:\Users\mus_h\OneDrive\Documents\sss.jpg'),
                'trailer_number' => $data->trailer_number,
                'trailer_vin_type' => $data->trailer_vin_type,
                'trailer_vin' => $data->trailer_vin,
                'trailer_model' => $data->trailer_model,
                'container_number' => $data->container_number,
                'last_name' => $data->last_name,
                'first_name' => $data->first_name,
                'middle_name' => $data->middle_name,
                'personal_number' => $data->personal_number,
                'driver_country' => $data->driver_country,
                'identity_card_kind' => $data->identity_card_kind,
                'doc_series' => $data->doc_series,
                'doc_number' => $data->doc_number,
                'active_tab' => $data->active_tab,
                'input-option' => $data->input_option,
            ],
            //'debug' => true //$debugFile
        ]);
        //fclose($debugFile);
    }
}
