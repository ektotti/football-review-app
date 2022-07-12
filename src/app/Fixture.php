<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    protected $guarded = [
        'id',
    ];

    public function member()
    {
        $this->hasMany('App\Member');
    }

    public function post()
    {
        return $this->hasMany('App\Fixture');
    }

    static function getComingSoonFixtures()
    {
        $now = Carbon::now();
        $thirtyMinuteLater = new Carbon('+90 minutes');
        return Fixture::where('fixture_date_time', '>', $now)
            ->where('fixture_date_time', '<', $thirtyMinuteLater)
            ->simplePaginate(5)
            ->toArray();
    }

    static function getRecentFixtures()
    {
        $now = Carbon::now();
        return Fixture::where('fixture_date_time', '<', $now)
            ->orderBy('fixture_date_time', 'desc')
            ->simplePaginate(5)
            ->toArray();
    }
}
