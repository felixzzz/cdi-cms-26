<?php

namespace App\Actions\AboutUs;

use App\Helpers\StorageFile;
use App\Http\Requests\AboutUs\MembershipRequest;
use App\Models\AboutUs\Membership;

class MembershipAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(MembershipRequest $request){
        $data = [
            ...$request->only([
                'name_en',
                'name_id',
                'content_en',
                'content_id',
                'date'
            ])
        ];

        if ($request->hasFile('file')) {
            $data['file'] = StorageFile::upload($request->file('file'), 'aboutus/memberships');
        }

        return Membership::create($data);
    }

    public function update(MembershipRequest $request, $ulid){
        $data = [
            ...$request->only([
                'name_en',
                'name_id',
                'content_en',
                'content_id',
                'date'
            ])
        ];

        if ($request->hasFile('file')) {
            $data['file'] = StorageFile::upload($request->file('file'), 'aboutus/memberships');
        }

        return Membership::whereUlid($ulid)->update($data);
    }

    public function delete($ulid){
        return Membership::where('ulid', $ulid)->delete();
    }
}
