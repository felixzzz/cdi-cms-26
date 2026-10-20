<?php

namespace App\Actions\Utility;

use Illuminate\Http\Request;
use App\Models\Utility\Country;

class CountryAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(Request $request){
        $data = [
            ...$request->only(['name', 'code'])
        ];
        return Country::create($data);
    }

    public function update(Request $request, $ulid){
        $data = [
            ...$request->only(['name', 'code'])
        ];
        return Country::whereUlid($ulid)->update($data);
    }

    public function delete($ulid){
        return Country::where('ulid', $ulid)->delete();
    }
}
