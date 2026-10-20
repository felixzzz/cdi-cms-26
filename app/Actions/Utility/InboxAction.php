<?php

namespace App\Actions\Utility;

use App\Enums\TopicType;
use App\Enums\PreferenceKey;
use Illuminate\Http\Request;
use App\Models\Utility\Inbox;
use App\Mail\WhistleblowingMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Utility\InboxRequest;
use App\Repositories\Utility\PreferenceRepository;

class InboxAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function handle(InboxRequest $request, $type)
    {
        $inbox = Inbox::create([
            'type' => $type,
            ...$request->only(['first_name', 'last_name', 'country_id', 'topic_id', 'message', 'email'])
        ]);

        if ($type == TopicType::Whistleblowing) {
            $data = Inbox::with(['country', 'topic'])->where("id", $inbox->id)->first();

            $mail = (new PreferenceRepository())->find(PreferenceKey::email_pic_whistleblowing->value);
            if ($mail) {
                try {
                    Mail::to($mail->content_en)->send(new WhistleblowingMail($data));
                } catch (\Throwable $th) {
                    Log::error('ERROR SEND EMAIL to ' . $data->email);
                }
            }
        }
    }

    public function delete($ulid){
        return Inbox::where('ulid', $ulid)->delete();
    }
}
