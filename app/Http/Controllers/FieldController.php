<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    // List fields
    public function index(Request $request)
    {
        $query = Field::query()->withCount('documents');

        if ($search = $request->query('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $fields = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('admin.fields.index', compact('fields'));
    }

    // Create form
    public function create()
    {
        return view('admin.fields.create');
    }

    // Store new field
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255|unique:fields,name',
            'description' => 'nullable|string|max:1000',
        ]);

        Field::create($data);

        return redirect()
            ->route('fields.index')
            ->with('success', 'Field created successfully.');
    }

    // Edit form
    public function edit(Field $field)
    {
        return view('admin.fields.edit', compact('field'));
    }

    // Update field
    public function update(Request $request, Field $field)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255|unique:fields,name,' . $field->id,
            'description' => 'nullable|string|max:1000',
        ]);

        $field->update($data);

        return redirect()
            ->route('fields.index')
            ->with('success', 'Field updated successfully.');
    }

    // Delete field
    public function destroy(Field $field)
    {
        // optional: prevent deletion if documents exist
        if ($field->documents()->exists()) {
            return back()->with('error', 'Cannot delete a field that is used by documents.');
        }

        $field->delete();

        return redirect()
            ->route('fields.index')
            ->with('success', 'Field deleted successfully.');
    }
}
