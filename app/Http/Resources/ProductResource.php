<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => strval($this->id),
            'type' => 'product',
            'attributes' => [
                'name' => $this->name,
                'description' => $this->description,
                'seller' => $this->seller,
                'price' => $this->price,
                'category' => $this->category->title
            ],

        ];
    }
}
