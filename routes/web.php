<?php

use App\Http\Controllers\BlockedUserController;
use App\Http\Controllers\Web\Auth\ProfileController;
use App\Http\Controllers\Web\Auth\SetupController;
use App\Http\Controllers\Web\Debug\DebugController;
use App\Http\Controllers\Web\ExchangeRates\ExchangeRateController;
use App\Http\Controllers\Web\File\FileController;
use App\Http\Controllers\Web\Home\HomeController;
use App\Http\Controllers\Web\Import\ColumnsMappingController;
use App\Http\Controllers\Web\Import\ImportController;
use App\Http\Controllers\Web\Import\ImportSettingController;
use App\Http\Controllers\Web\Meta\MetaController;
use App\Http\Controllers\Web\Nordigen\Institution\InstitutionController;
use App\Http\Controllers\Web\Notification\NotificationController;
use App\Http\Controllers\Web\Social\ChatController;
use App\Http\Controllers\Web\Synchronization\SynchronizationController;
use App\Http\Controllers\Web\Transaction\Analytics\AnalyticsController;
use App\Http\Controllers\Web\Transaction\BudgetController;
use App\Http\Controllers\Web\Transaction\CategoryController;
use App\Http\Controllers\Web\Transaction\PersonaController;
use App\Http\Controllers\Web\Transaction\PersonalAccountController;
use App\Http\Controllers\Web\Transaction\ReportController;
use App\Http\Controllers\Web\Transaction\SettingsController;
use App\Http\Controllers\Web\Transaction\TransactionController;
use App\Http\Controllers\Web\User\UserController;
use App\Http\Controllers\Web\Utils\EmptyUrlController;
use App\Http\Controllers\Web\Version\VersionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth', 'deny_blocked'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/setup', [SetupController::class, 'setup'])->name('setup');

    Route::prefix('notifications')->as('notification.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/redirect/{notification}', [NotificationController::class, 'redirect'])->name('redirect');
    });

    Route::prefix('profile')->as('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('reports')->as('report.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/periodic', [ReportController::class, 'periodic'])->name('periodic');
    });

    Route::prefix('settings')->as('setting.')->group(function () {
        Route::get('/', [SettingsController::class, 'edit'])->name('edit');
        Route::post('/', [SettingsController::class, 'update'])->name('update');
    });

    Route::prefix('personas')->as('persona.')->group(function () {
        Route::get('/', [PersonaController::class, 'index'])->name('index');
        Route::patch('/{persona}', [PersonaController::class, 'update'])->name('update');
        Route::get('/mass-association', [PersonaController::class, 'associatePersonasToTransactions']);
    });

    Route::prefix('social')->as('social.')->group(function () {
        Route::prefix('chat')->as('chat.')->group(function () {
            Route::get('/', [ChatController::class, 'index'])->name('index');
            Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('send_message');
        });
    });

    Route::prefix('files')->as('file.')->group(function () {
        Route::get('/', [FileController::class, 'index'])->name('index');
        Route::post('/upload', [FileController::class, 'upload'])->name('upload');
        Route::get('{id}', [FileController::class, 'show'])->name('show');
    });

    Route::prefix('synchronizations')->as('synchronization.')->group(function () {
        Route::get('/', [SynchronizationController::class, 'index'])->name('index');
    });

    Route::prefix('institutions')->as('institution.')->group(function () {
        Route::get('/', [InstitutionController::class, 'index'])->name('index');
        Route::get('/{id}/select', [InstitutionController::class, 'select'])->name('select');
        Route::post('/{institutionId}', [InstitutionController::class, 'newAgreement'])->name('new_agreement');
        Route::get('/{id}/agreements', [InstitutionController::class, 'agreements'])->name('agreements');
        Route::post('/{agreementId}/requisitions', [InstitutionController::class, 'newRequisition'])->name('new_requisition');
        Route::delete('/agreements/{agreementId}', [InstitutionController::class, 'deleteAgreement'])->name('delete_agreement');
    });

    Route::prefix('transactions')->as('transaction.')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('index');
        Route::post('/', [TransactionController::class, 'create'])->name('create');
        Route::get('/{id}', [TransactionController::class, 'show'])->name('show');
        Route::patch('/{id}', [TransactionController::class, 'patch'])->name('patch');
    });

    Route::prefix('categories')->as('category.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
    });

    Route::prefix('analytics')->as('analytic.')->group(function () {
        Route::get('/', [AnalyticsController::class, 'index'])->name('index');
    });

    Route::prefix('personal-accounts')->as('personal-account.')->group(function () {
        Route::get('/edit', [PersonalAccountController::class, 'edit'])->name('edit');
        Route::put('/update', [PersonalAccountController::class, 'update'])->name('update');
    });

    Route::prefix('budgets')->as('budget.')->group(function () {
        Route::get('/', [BudgetController::class, 'index'])->name('index');
        Route::get('/new', [BudgetController::class, 'new'])->name('new');
        Route::get('/{id}', [BudgetController::class, 'show'])->name('show');
        Route::post('/', [BudgetController::class, 'create'])->name('create');
        Route::get('/{id}/edit', [BudgetController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [BudgetController::class, 'patch'])->name('patch');
    });

    Route::prefix('imports')->as('import.')->group(function () {
        Route::get('/', [ImportController::class, 'index'])->name('index');

        Route::prefix('settings')->as('import-setting.')->group(function () {
            Route::get('/', [ImportSettingController::class, 'index'])->name('index');
            Route::get('/{id}', [ImportSettingController::class, 'show'])->name('show');
            Route::post('/', [ImportSettingController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [ImportSettingController::class, 'edit'])->name('edit');
        });

        Route::prefix('columns-mappings')->as('columns-mapping.')->group(function () {
            Route::get('/', [ColumnsMappingController::class, 'index'])->name('index');
            Route::post('/', [ColumnsMappingController::class, 'store'])->name('store');
        });
    });

    Route::prefix('versions')->as('version.')->group(function () {
        Route::get('/', [VersionController::class, 'releaseNotes'])->name('release_notes');
    });

    Route::middleware('admin')->group(function () {
        Route::prefix('debug')->as('debug.')->group(function () {
            Route::get('/analyzers', [DebugController::class, 'analyzers'])->name('analyzers');
        });

        Route::prefix('users')->as('user.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/{id}/confirm-change-role', [UserController::class, 'confirmRoleChange'])
                ->name('confirm_change_role');
            Route::get('/{id}/confirm-block', [UserController::class, 'confirmBlock'])
                ->name('confirm_block');
            Route::get('/{id}/confirm-delete', [UserController::class, 'confirmDelete'])
                ->name('confirm_delete');
            Route::delete('/{id}/delete', [UserController::class, 'delete'])
                ->name('delete');
            Route::post('/{id}/change-role', [UserController::class, 'changeRole'])
                ->name('change_role');
            Route::post('/{id}/block', [UserController::class, 'block'])
                ->name('block');
            Route::post('/{id}/unblock', [UserController::class, 'unblock'])
                ->name('unblock');
            Route::get('/{id}', [UserController::class, 'show'])
                ->name('show');
        });

        Route::prefix('exchange-rates')->as('exchange_rate.')->group(function () {
            Route::get('/', [ExchangeRateController::class, 'index'])->name('index');
        });

        Route::prefix('meta')->as('meta.')->group(function () {
            Route::get('/', [MetaController::class, 'index'])->name('index');
        });
    });

    Route::get('/', [EmptyUrlController::class, 'redirect'])->name('empty');
});

Route::prefix('blocked')->as('blocked.')->group(function () {
    Route::get('/', [BlockedUserController::class, 'index'])
        ->name('index');
});

require __DIR__ . '/auth.php';
