<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\SettingHelper;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscribeFormMail;
use Log;
use App\Models\Post;

class SubscribeFormController extends Controller
{
    public function index(Request $request)
    {
        $page_id = 52681;

        $post = Post::query()
            ->where('id', $page_id)
            ->where('post_status', 'publish')
            ->first();

        $postMeta = $post->GetAllMetaData();


        $mail_address = SettingHelper::get_field('admin_email_address');

        if ($mail_address) {
            $mail = $mail_address;
        } else {
            $mail = 'info.reviewnepal@example.com';
        }


        try {
            $data = $request->validate([
                'email' => 'required|email|max:255',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }


        try {
            Mail::to($mail)->send(new SubscribeFormMail($data));

            return view('frontend.pages.thank_you', [
                'message' => 'You have successfully subscribed to our newsletter. You will receive our latest news and updates.',
                'post' => $post,
                'postMeta' => $postMeta,
            ]);
        } catch (\Exception $e) {
            Log::error('Subscribe form submission error: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
