<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return [
        //     "team_name" => $this->team_name,
        //     "status" => $this->status,
        //     "players" => [
        //         "player_1" => [
        //             "name" => $this->player_1,
        //             "number" => "",
        //             "position" => "",
        //         ],
        //         "player_2" => [
        //             "name" => $this->player_2,
        //             "number" => "",
        //             "position" => "",
        //         ],
        //         "player_3" => [
        //             "name" => $this->player_3,
        //             "number" => "",
        //             "position" => "",
        //         ],
        //         "player_4" => [
        //             "name" => $this->player_4,
        //             "number" => "",
        //             "position" => "",
        //         ],
        //         "player_5" => [
        //             "name" => $this->player_5,
        //             "number" => "",
        //             "position" => "",
        //         ],
        //         "player_6" => [
        //             "name" => $this->player_6,
        //             "number" => "",
        //             "position" => "",
        //         ],
        //         "player_7" => [
        //             "name" => $this->player_7,
        //             "number" => "",
        //             "position" => "",
        //         ],
        //         "player_8" => [
        //             "name" => $this->player_8,
        //             "number" => "",
        //             "position" => "",
        //         ],
        //         "player_9" => [
        //             "name" => $this->player_9,
        //             "number" => "",
        //             "position" => "",
        //         ],
        //         "player_10" => [
        //             "name" => $this->player_10,
        //             "number" => "",
        //             "position" => "",
        //         ],
        //         "player_11" => [
        //             "name" => $this->player_11,
        //             "number" => "",
        //             "position" => "",
        //         ],
        //         "player_12" => [
        //             "name" => $this->player_12,
        //             "number" => "",
        //             "position" => "",
        //         ],
        //         "player_13" => [
        //             "name" => $this->player_13,
        //             "number" => "",
        //             "position" => "",
        //         ],
        //         "player_14" => [
        //             "name" => $this->player_14,
        //             "number" => "",
        //             "position" => "",
        //         ],
        //         "player_15" => [
        //             "name" => $this->player_15,
        //             "number" => "",
        //             "position" => "",
        //         ],
        //         "player_16" => [
        //             "name" => $this->player_16,
        //             "number" => "",
        //             "position" => "",
        //         ],
        //         "player_17" => [
        //             "name" => $this->player_17,
        //             "number" => "",
        //             "position" => "",
        //         ],
        //         "player_18" => [
        //             "name" => $this->player_18,
        //             "number" => "",
        //             "position" => "",
        //         ],
        //         "player_19" => [
        //             "name" => $this->player_19,
        //             "number" => "",
        //             "position" => "",
        //         ],
        //         "player_20" => [
        //             "name" => $this->player_20,
        //             "number" => "",
        //             "position" => "",
        //         ]
        //     ],
        // ];
    }
}