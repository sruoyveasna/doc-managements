<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Field;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    // 1. PUBLIC LIST: outsiders + logged-in, only published
    public function publicIndex(Request $request)
    {
            $query = Document::with(['field', 'genre', 'uploader'])
        ->where('status', 'published');
    // only published

        if ($search = $request->query('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author_name', 'like', "%{$search}%")
                  ->orWhere('keywords', 'like', "%{$search}%")
                  ->orWhereHas('field', fn ($f) => $f->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('genre', fn ($g) => $g->where('name', 'like', "%{$search}%"));
            });
        }

        $documents = $query->orderByDesc('created_at')->paginate(10);

        return view('documents.public', compact('documents'));
    }

    // 2. PUBLIC/LOGGED-IN: show details
    public function show(Document $document)
    {
        // Guests can only see published documents
        if (!auth()->check() && $document->status !== 'published') {
            abort(404);
        }

        // Logged in: students can see only published, lecturers/admins can see all
        $user = auth()->user();
        if (! $user || (! $user->isAdmin() && ! $user->isLecturer())) {
            if ($document->status !== 'published') {
                abort(403, 'You are not allowed to view this document.');
            }
        }

        // $document->load(['field', 'genre', 'comments.user']);
        $document->load(['field', 'genre', 'uploader', 'comments.user']);


        return view('documents.show', compact('document'));
    }

    // 3. AUTH: download (students/lecturers/admins only)
    public function download(Document $document)
    {
        $user = auth()->user(); // not null because of 'auth' middleware

        // Allow drafts/archived only for admins + lecturers
        if ($document->status !== 'published' && !($user->isAdmin() || $user->isLecturer())) {
            abort(403);
        }

        if (! $document->file_path || ! Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('public')->download(
            $document->file_path,
            $document->title . '.' . pathinfo($document->file_path, PATHINFO_EXTENSION)
        );
    }

    // 4. MANAGEMENT LIST: lecturers + admins
    // Route uses: ->middleware(['auth', 'can:manage-documents'])
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Document::with(['field', 'genre', 'uploader']);

        // 🔒 If lecturer (and not admin), only see own documents
        if ($user->isLecturer() && ! $user->isAdmin()) {
            $query->where('uploaded_by', $user->id);
        }

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->query('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('keywords', 'like', "%{$search}%")
                  ->orWhere('author_name', 'like', "%{$search}%") // free-text author
                  ->orWhereHas('uploader', function ($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%");     // search by uploaded_by user name
                  });
            });
        }

        $documents = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        return view('admin.documents.index', compact('documents'));
    }

    // 5. CREATE FORM: lecturers + admins (admin-style view)
    public function create()
    {
        $fields  = Field::orderBy('name')->get();
        $genres  = Genre::orderBy('name')->get();

        return view('admin.documents.create', compact('fields', 'genres'));
    }

    // 6. STORE: save new document
    public function store(Request $request)
    {
        $user = auth()->user(); // safe, route has 'auth'

        $data = $request->validate([
            'title'             => 'required|string|max:255',
            'author_name'       => 'required|string|max:255',
            'publication_year'  => 'required|integer',
            'keywords'          => 'nullable|string|max:500',
            'field_id'          => 'required|exists:fields,id',
            'genre_id'          => 'required|exists:genres,id',
            'status'            => 'required|in:draft,published,archived',
            'file'              => 'required|file|mimes:pdf,doc,docx,txt|max:10240',
        ]);

        $path = $request->file('file')->store('documents', 'public');

        Document::create([
            'title'            => $data['title'],
            'author_name'      => $data['author_name'],
            'publication_year' => $data['publication_year'],
            'keywords'         => $data['keywords'] ?? null,
            'field_id'         => $data['field_id'],
            'genre_id'         => $data['genre_id'],
            'status'           => $data['status'],
            'file_path'        => $path,
            'uploaded_by'      => $user->id,
        ]);

        return redirect()->route('documents.index')->with('success', 'Document created successfully.');
    }

    // 7. EDIT FORM
    public function edit(Document $document)
    {
        $user = auth()->user();

        // 🔒 Lecturer can edit only their own document
        if ($user->isLecturer() && ! $user->isAdmin() && $document->uploaded_by !== $user->id) {
            abort(403, 'You are not allowed to edit this document.');
        }

        $fields  = Field::orderBy('name')->get();
        $genres  = Genre::orderBy('name')->get();

        return view('admin.documents.edit', compact('document', 'fields', 'genres'));
    }

    // 8. UPDATE
    public function update(Request $request, Document $document)
    {
        $user = auth()->user();

        // 🔒 Lecturer can update only their own document
        if ($user->isLecturer() && ! $user->isAdmin() && $document->uploaded_by !== $user->id) {
            abort(403, 'You are not allowed to update this document.');
        }

        $data = $request->validate([
            'title'             => 'required|string|max:255',
            'author_name'       => 'required|string|max:255',
            'publication_year'  => 'required|integer',
            'keywords'          => 'nullable|string|max:500',
            'field_id'          => 'required|exists:fields,id',
            'genre_id'          => 'required|exists:genres,id',
            'status'            => 'required|in:draft,published,archived',
            'file'              => 'nullable|file|mimes:pdf,doc,docx,txt|max:10240',
        ]);

        if ($request->hasFile('file')) {
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            $path = $request->file('file')->store('documents', 'public');
            $data['file_path'] = $path;
        }

        $document->update($data);

        return redirect()->route('documents.index')->with('success', 'Document updated.');
    }

    // 9. DELETE
    public function destroy(Document $document)
    {
        $user = auth()->user();

        // 🔒 Lecturer can delete only their own document
        if ($user->isLecturer() && ! $user->isAdmin() && $document->uploaded_by !== $user->id) {
            abort(403, 'You are not allowed to delete this document.');
        }

        $document->delete(); // soft delete if using SoftDeletes

        return redirect()->route('documents.index')->with('success', 'Document deleted.');
    }
}
