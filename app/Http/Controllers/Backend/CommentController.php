<?php

namespace App\Http\Controllers\Backend;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create_comment', ['only' => ['create','store']] );
        $this->middleware('permission:read_comment', ['only' => ['index']] );
        $this->middleware('permission:update_comment', ['only' => ['update','edit']] );
        $this->middleware('permission:delete_comment', ['only' => 'destroy']);
    }

    public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        $baseQuery = Comment::query()->with(['user', 'post'])->latest();

        if ($status !== 'all') {
            $baseQuery->whereApproved($status === 'approved' ? 1 : 0);
        }
        $comments = $baseQuery->get();

        $approvedComments = Comment::where('approved', 1)->count();
        $pendingComments = Comment::where('approved', 0)->count();

        return view('backend.comments.index-comment', [
            'comments' => $comments,
            'status' => $status,
            'approvedComments' => $approvedComments,
            'pendingComments' => $pendingComments,
        ]);
    }


    public function edit(Comment $id)
    {
        $comment = $id;
        $user = $comment->user;
        $post = $comment->post;

        return view('backend.comments.edit-comment', compact('comment', 'user', 'post'));
    }

    public function update(Request $request, Comment $id)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required'
        ]);

        $comment = $id;
        $comment->update([
            'user_id' => $request->user_id,
            'post_id' => $request->post_id,
            'content' => $request->content,
            'approved' => $request->action,
            'type' => 'comment',
        ]);


        session()->flash('success', 'Comment Updated.');
        return redirect()->back();

    }

    public function destroy(Comment $id)
    {
        $id->delete();

        session()->flash('success', 'Comment Deleted.');
        return redirect()->back();
    }
}
