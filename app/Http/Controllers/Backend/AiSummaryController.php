<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Ai\Agents\Summarizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Laravel\Ai\Ai;
use App\Models\Post;



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
        // dd('hait');
        $filePath = 'tts/post-' . $post->id . '.wav';

        // Check if we already generated the audio
        if (Storage::disk('public')->exists($filePath)) {
            return response()->json([
                'audio_url' => Storage::url($filePath)
            ]);
        }

        // Generate audio from the actual post content (limited to 4000 chars to avoid timeouts)
        $textToRead = mb_substr(strip_tags($post->post_content), 0, 4000);
        
        $audioResponse = Ai::audio(
            text: $textToRead,
            voice: 'Kore',
            instructions: null,
            model: 'gemini-3.1-flash-tts-preview',
            timeout: 120 // Increase timeout from 30s to 120s
        );

        // Save the audio file
        Storage::disk('public')->put(
            $filePath,
            (string) $audioResponse
        );

        // MUST return JSON so frontend can play it
        return response()->json([
            'audio_url' => Storage::url($filePath)
        ]);
    }
}
