<?php

namespace App\Service;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DomCrawler\Crawler;

 class ServerSenderService
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */

    public function test(): string
    {
        return "work";
    }

    public function main(): string
    {
        $data = [];
        $data['arrival_date'] = '22-01-2025';
        $response = $this->sendStore($data);
        $crawler = new Crawler($response->getBody()->getContents());
        return $crawler->filter('#statement')->text();
    }

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

    public function sendStore($data): ResponseInterface
    {
        //$debugFile = fopen('debug.log', 'a');
        $client = new Client(['timeout'  => 10.0]);
        $response = $client->get('https://auto.customs.gov.kg/ru');
        $headers = $response->getHeaders();
        $crawler = new Crawler($response->getBody()->getContents());
        $token = $crawler->filter('input[name="_token"]')->attr('value');

        return $client->post('https://auto.customs.gov.kg/ru/store',[
            'headers' => $this->headerBuilder($headers),
            'form_params' => [
                '_token' => $token,
                'arrival_date' => $data['arrival_date'],
                'custom' => '41762101',
                'vehicle_number' => '01KG198ADL',
                'vehicle_country' => 'KG',
                'vehicle_type' => '38',
                'vehicle_vin_type' => 'vin',
                'vehicle_vin' => '12345678912345678',
                'vehicle_brand' => '10',
                'vehicle_model' => 'SD4544',
                'vehicle_photo' => 'sss.jpg',
                'vehicle_photo' => $this->imageConvert('C:\Users\mus_h\OneDrive\Documents\sss.jpg'),
                'trailer_number' => '',
                'trailer_vin_type' => 'vin',
                'trailer_vin' => '',
                'trailer_model' => '',
                'container_number' => '',
                'last_name' => 'Testov',
                'first_name' => 'test',
                'middle_name' => '',
                'personal_number' => '54556555455',
                'driver_country' => 'KG',
                'identity_card_kind' => '50',
                'doc_series' => 'sd545554',
                'doc_number' => '4545444',
                'active_tab' => 'pills-home',
                'input-option' => 'on',
            ],
            //'debug' => true //$debugFile
        ]);
        //fclose($debugFile);
    }
}
