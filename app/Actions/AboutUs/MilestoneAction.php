<?php

namespace App\Actions\AboutUs;

use App\Http\Requests\AboutUs\MilestoneRequest;
use App\Models\AboutUs\Milestone;

class MilestoneAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(MilestoneRequest $request){
        $data = [
            ...$request->only([
                'year',
                'priority',
                'content_en',
                'content_id'
            ])
        ];

        return Milestone::create($data);
    }

    public function update(MilestoneRequest $request, $ulid){
        $data = [
            ...$request->only([
                'year',
                'priority',
                'content_en',
                'content_id'
            ])
        ];

        return Milestone::whereUlid($ulid)->update($data);
    }

    public function delete($ulid){
        return Milestone::where('ulid', $ulid)->delete();
    }
}
