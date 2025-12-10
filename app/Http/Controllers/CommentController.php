<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Document $document)
    {
        $user = $request->user(); // logged-in user (route already has ->middleware('auth'))

        // Make sure user is allowed to see this document:
        // - if document is published → everyone logged in can comment
        // - if not published → only admin/lecturer can comment
        if ($document->status !== 'published') {
            if (!($user->isAdmin() || $user->isLecturer())) {
                abort(403, 'You cannot comment on this document.');
            }
        }

        $data = $request->validate([
            'content' => 'required|string|max:2000',
            'rating'  => 'nullable|integer|min:1|max:5',
        ]);

        $document->comments()->create([
            'user_id' => $user->id,
            'content' => $data['content'],
            'rating'  => $data['rating'] ?? null,
        ]);

        return back()->with('success', 'Thank you for your comment!');
    }

    public function update(Request $request, Document $document, Comment $comment)
    {
        $user = $request->user();

        // ensure the comment belongs to this document
        if ($comment->document_id !== $document->id) {
            abort(404);
        }

        // only comment owner OR admin/lecturer can edit
        if ($user->id !== $comment->user_id && !($user->isAdmin() || $user->isLecturer())) {
            abort(403, 'You cannot edit this comment.');
        }

        $data = $request->validate([
            'content' => 'required|string|max:2000',
            'rating'  => 'nullable|integer|min:1|max:5',
        ]);

        $comment->update([
            'content' => $data['content'],
            'rating'  => $data['rating'] ?? null,
        ]);

        return back()->with('success', 'Your comment has been updated.');
    }

    public function destroy(Request $request, Document $document, Comment $comment)
    {
        $user = $request->user();

        // ensure the comment belongs to this document
        if ($comment->document_id !== $document->id) {
            abort(404);
        }

        // only comment owner OR admin/lecturer can delete
        if ($user->id !== $comment->user_id && !($user->isAdmin() || $user->isLecturer())) {
            abort(403, 'You cannot delete this comment.');
        }

        $comment->delete();

        return back()->with('success', 'Your comment has been deleted.');
    }
}
