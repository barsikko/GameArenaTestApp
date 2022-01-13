<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GetProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'eid' => $this->eid,
            'title' => $this->title,
            'price' => $this->price,
            'categories' => $this->categories,
        ];
    }
}
