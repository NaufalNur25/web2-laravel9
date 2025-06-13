<?php

namespace App\Http\Resources\Api\Spotify;

use Illuminate\Http\Resources\Json\JsonResource;

class DropdownTrackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this['id'],
            'type' => 'track',
            'name' => $this['name'],
            'type' => $this['type'],
            'uri' => $this['uri'],
            'href_link' => $this['href'],
            'artists' => @$this['artists'] ? [
                'id' => $this['artists'][0]['id'],
                'name' => implode(', ', array_column($this['artists'], 'name')),
            ] : null,
        ];
    }
}
