<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class WorkerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //dd(Carbon::parse('2023-6-6')->year);
        
        
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'age' => $this->age,
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
