<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'status' => $this->status,
            'user_id' => $this->user->name,
            'created_at' => $this->created_at->format('d/m/Y a'),
            'updated_at' => $this->updated_at->format('d/m/Y a'),
        ];
    }
}
