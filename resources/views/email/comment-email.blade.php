<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Comment Submitted</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f8f8;
            border-radius: 5px;
        }

        .email-header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .email-content {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .email-footer {
            font-size: 14px;
            color: #555;
        }

        .comment-content {
            font-style: italic;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">New Comment Submitted for Approval</div>

        <div class="email-content">
            <p><strong>Post Title:</strong> {{ $comment->post->post_title }}</p>
            <p><strong>Commenter:</strong> {{ $comment->user->name }}</p>
            <p><strong>Commenter Email:</strong> {{ $comment->user->email }}</p>
            <p><strong>Content:</strong></p>
            <p class="comment-content">{{ $comment->content }}</p>
            <p><strong>Submitted On:</strong> {{ $comment->created_at->format('F j, Y, g:i a') }}</p>
            <p><strong>User Agent:</strong> {{ $comment->comment_agent }}</p>
        </div>

        <div class="email-footer">
            <p>To approve or reject this comment, please log in to the admin panel.</p>
        </div>
    </div>
</body>

</html>
