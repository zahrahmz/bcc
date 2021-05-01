<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;

return [
    'pagination' => [
        'per_page' => 10
    ],
    'files' => [
        'size' => [
            Product::class => [
                'width' => 467,
                'height' => 700,
                'ratio' => '467:700',
            ],
            Slider::class => [
                'width' => 1430,
                'height' => 570,
                'ratio' => '143 : 57',
            ],
            Category::class => [
                'width' => 590,
                'height' => 330,
                'ratio' => '143 : 57',
            ]
        ],
        'store_directory' => 'products',
        'disk' => 'public',
    ]
];
