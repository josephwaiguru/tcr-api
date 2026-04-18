<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EGroupResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'           => $this->id, // UUID
            'name'         => $this->name,
            'category'     => $this->category, // Mixed, Men, etc.
            'online'       => (bool) $this->is_online,
            'description'  => $this->description,
            'location'     => $this->location,
            'meeting_day'  => $this->meeting_date,
            'meeting_time' => $this->meeting_time, //->format('g:i A'),
            'member_count' => $this->members_count, // Use withCount() in controller
            'max_capacity' => 10, //$this->capacity,
            'leader' => [
                'name'      => $this->leader?->name,
                'avatarUrl' => $this->leader?->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($this->leader?->name),
            ],
        ];
    }
}