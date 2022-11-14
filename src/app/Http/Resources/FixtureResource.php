<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FixtureResource extends JsonResource
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
            "id" => $this->id,
            "match_week" => $this->match_week,
            "hometeam_name" => $this->hometeam_name,
            "awayteam_name" => $this->awayteam_name,
            "fixture_date_time" => $this->fixture_date_time,
            "members" => new MemberCollection($this->members),
        ];
    }
}
