<?php

namespace App\Actions\Data;

use App\Helpers\StorageFile;
use App\Http\Requests\Data\TeamRequest;
use App\Models\Data\Team;

class TeamAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(TeamRequest $request)
    {
        $data = [
            ...$request->only(['name', 'type', 'description_en', 'description_id', 'position']),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = StorageFile::upload($request->file('image'), 'teams');
        }

        if ($request->hasFile('image_hero')) {
            $data['image_hero'] = StorageFile::upload($request->file('image_hero'), 'teams');
        }

        if ($request->hasFile('cv_file')) {
            $data['cv_file'] = StorageFile::uploadWithDetails($request->file('cv_file'), 'teams');
        }

        if ($request->hasFile('resume_file')) {
            $data['resume_file'] = StorageFile::uploadWithDetails($request->file('resume_file'), 'teams');
        }

        return Team::create($data);

    }

    public function update(TeamRequest $request, $ulid)
    {
        $data = [
            ...$request->only(['name', 'type', 'description_en', 'description_id', 'position']),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = StorageFile::upload($request->file('image'), 'teams');
        }

        if ($request->hasFile('image_hero')) {
            $data['image_hero'] = StorageFile::upload($request->file('image_hero'), 'teams');
        }

        if ($request->input("delete_cv_file") == 'yes') {
            $data['cv_file'] = null;
        } else {
            if ($request->hasFile('cv_file')) {
                $data['cv_file'] = StorageFile::uploadWithDetails($request->file('cv_file'), 'teams');
            }
        }


        if ($request->input("delete_resume_file") == 'yes') {
            $data['resume_file'] = null;
        } else {
            if ($request->hasFile('resume_file')) {
                $data['resume_file'] = StorageFile::uploadWithDetails($request->file('resume_file'), 'teams');
            }
        }

        return Team::where("ulid", $ulid)->update($data);
    }

    public function delete($ulid){
        return Team::where('ulid', $ulid)->delete();
    }
}
