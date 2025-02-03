<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class DTOMapper
{
    public function __construct(private SerializerInterface $serializer) {}

    public function map(Request $request, string $dtoClass): object
    {
        $data = $request->request->all();

        // Добавляем файлы в данные вручную
        foreach ($request->files->all() as $key => $file) {
            $data[$key] = $file; // `UploadedFile` объект
        }

        return $this->serializer->denormalize($data, $dtoClass);
    }
}
