<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
            'name' => $request->string('name')->squish()->toString(),
            'email' => $request->string('email')->lower()->toString(),
            'email_verified_at' => now(),
            'password' => $request->string('password')->toString(),
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
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        $roles = Role::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('admin.users.edit', compact('roles', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $user->update([
            'name' => $request->string('name')->squish()->toString(),
            'email' => $request->string('email')->lower()->toString(),
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => $request->string('password')->toString(),
            ]);
        }

        $role = Role::query()->findOrFail($request->integer('role_id'));

        $user->syncRoles([$role]);

        return redirect()
            ->route('admin.users.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => 'Usuario actualizado',
                'text' => 'El usuario fue modificado correctamente',
                'confirmButtonText' => 'OK',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user, DeletesUsers $deletesUsers): RedirectResponse
    {
        $protectionMessage = $user->deletionProtectionMessage($request->user());

        if ($protectionMessage !== null) {
            return redirect()
                ->route('admin.users.index')
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Usuario protegido',
                    'text' => $protectionMessage,
                    'confirmButtonText' => 'OK',
                ]);
        }

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
