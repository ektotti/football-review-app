<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MemberCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collectResource($this->collection)->transform(function ($member) {
            $playersName = $member->getPlayerAttribute();
            $playersInfo = [];
            foreach ($playersName as $key => $value) {
                $playerNameNum = $this->pickNumFromStr($value);
                $playersInfo[$key] =
                    [
                        "name" => isset($playerNameNum[0]) ? $playerNameNum[0] : null,
                        "number" => isset($playerNameNum[1]) ? $playerNameNum[1] : null,
                        "position" => "",
                    ];
            }

            return [
                    'team_name' => $member->team_name,
                    'status' => $member->status,
                    'players' => $playersInfo
                    ];
        });
        return $this->collection;
    }

    // どこか別ファイルに切り出したい。
    public function pickNumFromStr($str)
    {
        return preg_split("/[_]/", $str);
    }
}
