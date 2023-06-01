<?php

namespace App\Http\Controllers\Web\User;

use App\Models\Auth\Settings;
use App\Models\Import\ColumnsMapping;
use App\Models\Import\Import;
use App\Models\Import\ImportSetting;
use App\Models\Nordigen\EndUserAgreement;
use App\Models\Nordigen\Requisition;
use App\Models\Synchronization\Account;
use App\Models\Synchronization\Synchronization;
use App\Models\Transaction\Transaction;
use App\Models\User;
use App\Services\Auth\Device\DeviceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct(private readonly DeviceService $deviceService)
    {
    }

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

    public function show(mixed $id): View
    {
        // @todo
        $user = User::findOrFail($id);
        $transactionsCount = Transaction::whereUser($user)->count();
        $importsCount = Import::whereUser($user)->count();
        $importSettingsCount = ImportSetting::whereUser($user)->count();
        $columnsMappingsCount = ColumnsMapping::whereUser($user)->count();
        $endUserAgreementsCount = EndUserAgreement::whereUser($user)->count();
        $requisitionsCount = Requisition::whereUser($user)->count();
        $nordigenAccountsCount = Account::whereUser($user)->count();
        $synchronizationsCount = Synchronization::whereUser($user)->count();
        $baseCurrencyCode = Settings::whereUser($user)?->get()->first()?->base_currency_code ?? 'No data';
        $devices = $this->deviceService->all($user);

        return view('admin.users.show', [
            'user' => $user,
            'devices' => $devices,
            'baseCurrencyCode' => $baseCurrencyCode,
            'transactionsCount' => $transactionsCount,
            'importsCount' => $importsCount,
            'importSettingsCount' => $importSettingsCount,
            'columnsMappingsCount' => $columnsMappingsCount,
            'endUserAgreementsCount' => $endUserAgreementsCount,
            'requisitionsCount' => $requisitionsCount,
            'nordigenAccountsCount' => $nordigenAccountsCount,
            'synchronizationsCount' => $synchronizationsCount
        ]);
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
        $user = User::findOrFail($id);
        $role = $request->input('role');
        $user->is_admin = false;

        if ($role === 'ADMIN') {        // @todo - find a better way
            $user->is_admin = true;
        }

        $user->save();

        return redirect()->to(route('user.index'));
    }

    public function block(mixed $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->is_blocked = true;
        $user->save();

        return redirect()->to(route('user.index'));
    }

    public function unblock(mixed $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->is_blocked = false;
        $user->save();

        return redirect()->to(route('user.index'));
    }

    public function delete(mixed $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->to(route('user.index'));
    }
}
