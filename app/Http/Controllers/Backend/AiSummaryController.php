<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Ai\Agents\Summarizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Ai\Facades\Ai;


class AiSummaryController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'content' => 'required|string|min:50',
        ]);

        try {
            $content = strip_tags($request->input('content'));

            // Truncate to avoid token limits (roughly 10k chars)
            $content = mb_substr($content, 0, 10000);

            $response = (new Summarizer)->prompt($content);

            return response()->json([
                'success' => true,
                'summary' => (string) $response,
            ]);
        } catch (\Exception $e) {
            Log::error('AI Summary generation failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to generate summary: ' . $e->getMessage(),
            ], 500);
        }
    }

    // In Text to speech
    public function generateAudio(Post $post)
    {
        $audio = Ai::driver('gemini')
            ->audio()
            ->generate([
                'input' => strip_tags($post->post_content),
                'model' => 'gemini-3.1-flash-tts-preview',
                'voice' => 'Kore', // Choose from available voices
            ]);

        // Save the audio file
        Storage::disk('public')->put(
            'tts/post-' . $post->id . '.wav',
            $audio
        );

        return response()->json([
            'audio_url' => Storage::url('tts/post-' . $post->id . '.wav')
        ]);
    }
}
