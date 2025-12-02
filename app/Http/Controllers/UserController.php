<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::all();

        return view('users.index', [
            'users' => $users,
        ]);
    }

    public function create(Request $request): View
    {
        return view('users.form');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'nullable|string|min:8|confirmed',
            ]);

            // If id provided, update existing user
            $id = $request->input('id', null);
            if ($id) {
                $user = User::find($id);
                if (!$user) {
                    return redirect()->back()->with('error', 'Usuario no encontrado')->withInput();
                }

                // If password provided, hash it
                if (!empty($validated['password'])) {
                    $validated['password'] = Hash::make($validated['password']);
                } else {
                    unset($validated['password']);
                }

                $user->update($validated);
            } else {
                // create new user, require password
                if (empty($validated['password'])) {
                    throw ValidationException::withMessages(['password' => ['La contraseña es requerida al crear un usuario.']]);
                }

                $validated['password'] = Hash::make($validated['password']);

                $user = User::create($validated);
            }

            return redirect()->route('users.index')->with('success', 'Usuario registrado/actualizado exitosamente.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit(Request $request, User $user): View
    {
        return view('users.form', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');
    }

    /**
     * Endpoint para DataTables server-side
     */
    public function dataTable(Request $request)
    {
        $request->validate([
            'draw' => 'integer',
            'start' => 'integer|min:0',
            'length' => 'integer|min:1|max:100',
            'search.value' => 'nullable|string|max:255',
        ]);

        $query = User::query();

        $search = $request->input('search.value');
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $totalRecords = User::count();

        $filteredQuery = clone $query;
        $recordsFiltered = $filteredQuery->count();

        $columns = ['name', 'email', 'id'];
        $orderColumn = $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'asc');
        $query->orderBy($columns[$orderColumn] ?? 'id', $orderDir);

        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);

        $data = $query->skip($start)->take($length)->get();

        $data = $data->map(function ($user) {
            return [
                'name' => $user->name,
                'email' => $user->email,
                'actions' => '
                    <button class="btn btn-primary btn-sm" onclick="execute(\'/users/' . $user->id . '/edit\')">
                        <i class="bi bi-pencil"></i> <span class="d-none d-sm-inline">Edit</span>
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="deleteRecord(\'/users/' . $user->id . '\')">
                        <i class="bi bi-trash"></i> <span class="d-none d-sm-inline">Delete</span>
                    </button>
                ',
            ];
        });

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }
}
