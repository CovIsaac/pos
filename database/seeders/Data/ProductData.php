<?php

namespace Database\Seeders\Data;

class ProductData
{
    public static function get(): array
    {
        return [
            [
                'name' => 'Bloody Mary',
                'subcategory' => 'Clásico',
                'size_oz' => 16,
                'price' => 100,
                'image' => 'https://solovino.cerounocero.app/wp-content/uploads/2025/08/descargar-1.jpeg',
            ],
            [
                'name' => 'Aperol',
                'subcategory' => 'Aperol',
                'size_oz' => 16,
                'price' => 120,
                'image' => 'https://solovino.cerounocero.app/wp-content/uploads/2025/08/Imagen-de-WhatsApp-2025-08-13-a-las-15.35.46_b085bce9.jpg',
            ],
            [
                'name' => 'Rusa',
                'subcategory' => 'Rusa',
                'size_oz' => 16,
                'price' => 58,
                'image' => 'https://solovino.cerounocero.app/wp-content/uploads/2025/08/Imagen-de-WhatsApp-2025-08-14-a-las-10.43.27_c42cf1de-300x300.jpg',
            ],
            [
                'name' => 'Café',
                'subcategory' => 'Café',
                'size_oz' => 16,
                'price' => 35,
                'image' => 'https://solovino.cerounocero.app/wp-content/uploads/2025/08/descargar-1-1-300x300.jpeg',
            ],
            [
                'name' => 'Vodka Tonic',
                'subcategory' => 'Vodka Tonic',
                'size_oz' => 16,
                'price' => 130,
                'image' => 'https://solovino.cerounocero.app/wp-content/uploads/2025/08/Imagen-de-WhatsApp-2025-08-14-a-las-10.41.26_926bfb76-300x300.jpg',
            ],
            [
                'name' => 'Vodka Ricky',
                'subcategory' => 'Vodka Ricky',
                'size_oz' => 16,
                'price' => 98,
                'image' => 'https://solovino.cerounocero.app/wp-content/uploads/2025/08/Imagen-de-WhatsApp-2025-08-14-a-las-10.42.45_08407a32-300x300.jpg',
            ],
        ];
    }
}
