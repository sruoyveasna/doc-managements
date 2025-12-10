<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    // LIST: admin only
    public function index(Request $request)
    {
        $query = Genre::query();

        if ($search = $request->query('q')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $genres = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('admin.genres.index', compact('genres'));
    }

    // CREATE FORM
    public function create()
    {
        return view('admin.genres.create');
    }

    // STORE NEW GENRE
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:genres,name',
        ]);

        Genre::create($data);

        return redirect()
            ->route('genres.index')
            ->with('success', 'Genre created successfully.');
    }

    // EDIT FORM
    public function edit(Genre $genre)
    {
        return view('admin.genres.edit', compact('genre'));
    }

    // UPDATE
    public function update(Request $request, Genre $genre)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:genres,name,' . $genre->id,
        ]);

        $genre->update($data);

        return redirect()
            ->route('genres.index')
            ->with('success', 'Genre updated successfully.');
    }

    // DELETE
    public function destroy(Genre $genre)
    {
        $genre->delete();

        return redirect()
            ->route('genres.index')
            ->with('success', 'Genre deleted successfully.');
    }
}
