<?php

namespace App\Actions\Sustainability;

use App\Models\Sustainability\Responsible;
use Illuminate\Http\Request;

class ResponsibleAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function update(Request $request, $ulid){
        $data = [
            ...$request->only([
                'title_en',
                'title_id',
                'description_en',
                'description_id',
                'list_en',
                'list_id',
            ])
        ];

        return Responsible::whereUlid($ulid)->update($data);
    }
}
