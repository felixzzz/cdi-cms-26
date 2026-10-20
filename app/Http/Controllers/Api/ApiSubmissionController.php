<?php

namespace App\Http\Controllers\Api;

use App\Actions\Utility\InboxAction;
use App\Enums\TopicType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Utility\InboxRequest;
use Illuminate\Support\Facades\Log;

class ApiSubmissionController extends Controller
{
    /**
     * Store Contact Us form submission via API.
     */
    public function storeContactUs(InboxRequest $request, InboxAction $inboxAction)
    {
        try {
            $inboxAction->handle($request, TopicType::ContactUs);

            return response()->json([
                'success' => true,
                'message' => __('Data successfully submitted'),
            ], 201);
        } catch (\Throwable $th) {
            Log::error('[ContactUs] Submission failed: ' . $th->getMessage(), [
                'exception' => $th,
                'email' => $request->input('email'),
            ]);

            return response()->json([
                'success' => false,
                'message' => __('Failed to submit inquiry. Please try again later.'),
            ], 500);
        }
    }

    /**
     * Store Whistleblowing form submission via API.
     */
    public function storeWhistleblowing(InboxRequest $request, InboxAction $inboxAction)
    {
        try {
            $inboxAction->handle($request, TopicType::Whistleblowing);

            return response()->json([
                'success' => true,
                'message' => __('Data successfully submitted'),
            ], 201);
        } catch (\Throwable $th) {
            Log::error('[Whistleblowing] Submission failed: ' . $th->getMessage(), [
                'exception' => $th,
                'email' => $request->input('email'),
            ]);

            return response()->json([
                'success' => false,
                'message' => __('Failed to submit whistleblowing report. Please try again later.'),
            ], 500);
        }
    }
}
