<?php

namespace App\Http\Controllers\Web\User;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        // @todo move to service
        $users = User::query()
            ->whereNot('id', $user->id)
            ->latest()
            ->get();

        return view('admin.users.index', compact('users'));
    }

    public function confirmRoleChange(mixed $id): View
    {
        $user = User::findOrFail($id);
        return view('admin.users.confirm-role-change', compact('user'));
    }

    public function confirmDelete(mixed $id): View
    {
        $user = User::findOrFail($id);
        return view('admin.users.confirm-delete', compact('user'));
    }

    public function confirmBlock(mixed $id): View
    {
        $user = User::findOrFail($id);
        return view('admin.users.confirm-block', compact('user'));
    }


    public function changeRole(mixed $id, Request $request): RedirectResponse
    {
        $isAdmin = $request->input('is_admin');
        $user = User::findOrFail($id);
        $user->update(['is_admin' => $isAdmin]);

        return redirect()->to(route('user.index'));
    }

    public function block(mixed $id, Request $request): RedirectResponse
    {
        $isAdmin = $request->input('is_blocked');
        $user = User::findOrFail($id);
        $user->update(['is_blocked' => $isAdmin]);

        return redirect()->to(route('user.index'));
    }

    public function delete(mixed $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->to(route('user.index'));
    }
}
