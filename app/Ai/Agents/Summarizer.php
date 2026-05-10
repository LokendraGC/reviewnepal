<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Promptable;
use Stringable;

class Summarizer implements Agent
{
    use Promptable;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return 'You are a professional news editor. Summarize the following news content into exactly 3 or 4 concise bullet points in the same language as the input. Format the output as an HTML unordered list using <ul> and <li> tags. Keep each point under 25 words. Do not add any introduction, conclusion, or extra wrapper — just the <ul> with <li> items.';
    }
}
