<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRoleRequest;
use App\Http\Requests\Admin\UpdateRoleRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        Role::create([
            'name' => $request->string('name')->toString(),
            'guard_name' => 'web',
            'is_system' => false,
        ]);

        return redirect()
            ->route('admin.roles.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => 'Rol creado correctamente',
                'text' => 'El rol ha sido creado correctamente',
                'confirmButtonText' => 'OK',
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): RedirectResponse
    {
        return redirect()->route('admin.roles.edit', $role);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): View|RedirectResponse
    {
        if ($redirectResponse = $this->protectedRoleRedirect($role)) {
            return $redirectResponse;
        }

        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        if ($redirectResponse = $this->protectedRoleRedirect($role)) {
            return $redirectResponse;
        }

        $role->update([
            'name' => $request->string('name')->toString(),
        ]);

        return redirect()
            ->route('admin.roles.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => 'Rol actualizado correctamente',
                'text' => 'El rol ha sido modificado correctamente',
                'confirmButtonText' => 'OK',
                'confirmButtonColor' => '#8B5CF6',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        if ($redirectResponse = $this->protectedRoleRedirect($role)) {
            return $redirectResponse;
        }

        $role->delete();

        return redirect()
            ->route('admin.roles.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => 'Rol eliminado',
                'text' => 'El rol fue eliminado correctamente',
                'confirmButtonText' => 'OK',
            ]);
    }

    private function protectedRoleRedirect(Role $role): ?RedirectResponse
    {
        if (! $role->is_system) {
            return null;
        }

        return redirect()
            ->route('admin.roles.index')
            ->with('swal', [
                'icon' => 'error',
                'title' => 'Rol protegido',
                'text' => 'Los roles del sistema no se pueden editar ni eliminar.',
                'confirmButtonText' => 'OK',
            ]);
    }
}
