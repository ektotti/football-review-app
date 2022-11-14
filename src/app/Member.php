<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $guarded = [
        'id',
    ];
    
    public function fixture() {
        return $this->belongsTo('App\Fixture');
    }

    public function getPlayerAttribute() {
        // dd($this->attributes);
        return array_filter($this->attributes, function($val, $key){
            return str_contains($key, 'player') && $val !== null;
        },ARRAY_FILTER_USE_BOTH);
    }

    static function getSeparetedNameAndNumber($fixtureId, $teamName){
        $playerNmaneAndNumber = Member::getNameAndNumber($fixtureId, $teamName);
        $separetedNameAndNumber = [];
        foreach ($playerNmaneAndNumber as $key => $value) {
            $number = preg_replace("/[^0-9]+/",'', $value);
            $name = preg_replace("/[0-9]+/",'', $value);
            $separetedNameAndNumber += [$key => [
                'number' => $number,
                'name' => $name,
            ]];
        }
        return $separetedNameAndNumber;
    }

    static function getNameAndNumber($fixtureId, $teamName){
        $players = Member::where('fixture_id', $fixtureId)->where('team_name', $teamName)->get()->toArray();
        $players = array_diff($players[0], array(null));
        return array_filter($players, function($key){
           return preg_match('/(player_)\d+/u', $key); 
        }, ARRAY_FILTER_USE_KEY);
    }
}
