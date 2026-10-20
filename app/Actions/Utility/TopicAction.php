<?php

namespace App\Actions\Utility;

use Illuminate\Http\Request;
use App\Models\Utility\Topic;

class TopicAction
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
            ...$request->only(['name_en', 'name_id', 'type'])
        ];
        return Topic::create($data);
    }

    public function update(Request $request, $ulid){
        $data = [
            ...$request->only(['name_en', 'name_id', 'type'])
        ];
        return Topic::whereUlid($ulid)->update($data);
    }

    public function delete($ulid){
        return Topic::where('ulid', $ulid)->delete();
    }
}
