<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Jetstream\Contracts\DeletesUsers;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $roles = Role::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $user = User::query()->create([
            'name' => $request->string('name')->toString(),
            'email' => $request->string('email')->toString(),
            'email_verified_at' => now(),
            'password' => Hash::make($request->string('password')->toString()),
        ]);

        $role = Role::query()->findOrFail($request->integer('role_id'));

        $user->syncRoles([$role]);

        return redirect()
            ->route('admin.users.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => 'Usuario creado',
                'text' => 'El usuario fue registrado correctamente',
                'confirmButtonText' => 'OK',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user, DeletesUsers $deletesUsers): RedirectResponse
    {
        abort_if($request->user()?->is($user), 403, 'YOU CANNOT DELETE YOURSELF.');

        $deletesUsers->delete($user);

        return redirect()
            ->route('admin.users.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => 'Usuario eliminado',
                'text' => 'El usuario fue eliminado correctamente',
                'confirmButtonText' => 'OK',
            ]);
    }
}
