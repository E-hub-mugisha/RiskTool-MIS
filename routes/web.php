<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\BeneficiariesController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\MitigationController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportingController;
use App\Http\Controllers\RiskController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/departments/dashboard/page', [DepartmentController::class, 'index'])->name('departments.dashboard');
    Route::get('/dashboard/export/excel', [DashboardController::class, 'exportExcel'])->name('dashboard.export.excel');
    Route::get('/dashboard/export/pdf', [DashboardController::class, 'exportPDF'])->name('dashboard.export.pdf');

    Route::get('/regions', [DepartmentController::class, 'index'])->name('regions.index');
    Route::get('/regions/create', [DepartmentController::class, 'create'])->name('regions.create');
    Route::post('/regions', [DepartmentController::class, 'store'])->name('regions.store');
    Route::get('/regions/{region}/edit', [DepartmentController::class, 'edit'])->name('regions.edit');
    Route::put('/regions/{region}', [DepartmentController::class, 'update'])->name('regions.update');
    Route::delete('/regions/{region}', [DepartmentController::class, 'destroy'])->name('regions.destroy');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
    Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
    Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
    Route::get('/staff/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');
    Route::put('/staff/{staff}', [StaffController::class, 'update'])->name('staff.update');
    Route::delete('/staff/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');

    Route::get('/risks', [RiskController::class, 'index'])->name('risks.index');
    Route::post('/risks', [RiskController::class, 'store'])->name('risks.store');
    Route::get('/risks/{risk}', [RiskController::class, 'show'])->name('risks.show');
    Route::put('/risks/{risk}', [RiskController::class, 'update'])->name('risks.update');
    Route::delete('/risks/{risk}', [RiskController::class, 'destroy'])->name('risks.destroy');

    Route::get('/mitigations', [MitigationController::class, 'index'])->name('mitigations.index');
    Route::post('/mitigations', [MitigationController::class, 'store'])->name('mitigations.store');
    Route::get('/mitigations/{mitigation}', [MitigationController::class, 'show'])->name('mitigations.show');
    Route::put('/mitigations/{mitigation}', [MitigationController::class, 'update'])->name('mitigations.update');
    Route::delete('/mitigations/{mitigation}', [MitigationController::class, 'destroy'])->name('mitigations.destroy');

    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');

    // Resources Routes
    Route::get('/resources', [DepartmentController::class, 'indexResource'])->name('resources.index');
    Route::post('/resources', [DepartmentController::class, 'storeResource'])->name('resources.store');
    Route::put('/resources/{resource}', [DepartmentController::class, 'updateResource'])->name('resources.update');
    Route::delete('/resources/{resource}', [DepartmentController::class, 'destroyResource'])->name('resources.destroy');

    Route::get('/requests', [RiskController::class, 'indexRequest'])->name('requests.index');
    Route::post('/store/request/resources', [RiskController::class, 'RequestResources'])->name('storeRequestResources');
    Route::get('/requests/{id}', [RiskController::class, 'showRequest'])->name('requests.show');
    Route::put('/requests/{id}/approve', [RiskController::class, 'approveRequest'])->name('requests.approve');
    Route::post('/requests/{id}/reject', [RiskController::class, 'rejectRequest'])->name('requests.reject');
    Route::get('/get/regions/{region}/resources', [RiskController::class, 'byRegion']);

    // Allocations
    Route::get('/allocations', [RiskController::class, 'indexAllocation'])->name('allocations.index');
    Route::get('/allocations/{id}', [RiskController::class, 'showAllocation'])->name('allocations.show');
    Route::get('/allocations/recommend/{id}', [RiskController::class, 'recommend'])->name('allocations.recommend');
    Route::put('/allocations/{allocation}/approve', [RiskController::class, 'approveAllocation'])->name('allocations.approve');
    Route::post('/allocations/{allocation}/reject', [RiskController::class, 'rejectAllocation'])->name('allocations.reject');

    // Shipments
    Route::get('/shipments', [RiskController::class, 'indexShipment'])->name('shipments.index');
    Route::get('/shipments/{id}', [RiskController::class, 'showShipment'])->name('shipments.show');
    Route::get('/shipments/create', [RiskController::class, 'createShipment'])->name('shipments.create');
    Route::post('/shipments', [RiskController::class, 'storeShipment'])->name('shipments.store');
    Route::delete('/shipments/{shipment}', [RiskController::class, 'destroyShipment'])->name('shipments.destroy');

    // beneficiaries
    Route::get('/beneficiaries', [BeneficiariesController::class, 'index'])->name('beneficiaries.index');
    Route::post('/beneficiaries', [BeneficiariesController::class, 'store'])->name('beneficiaries.store');
    Route::put('/beneficiaries/{beneficiary}', [BeneficiariesController::class, 'update'])->name('beneficiaries.update');
    Route::delete('/beneficiaries/{beneficiary}', [BeneficiariesController::class, 'destroy'])->name('beneficiaries.destroy');

    // distribution points
    Route::get('/distribution-points', [BeneficiariesController::class, 'distributionPoints'])->name('distribution_points.index');
    Route::post('/distribution-points', [BeneficiariesController::class, 'storeDistributionPoint'])->name('distribution_points.store');
    Route::put('/distribution-points/{distributionPoint}', [BeneficiariesController::class, 'updateDistributionPoint'])->name('distribution_points.update');
    Route::delete('/distribution-points/{distributionPoint}', [BeneficiariesController::class, 'destroyDistributionPoint'])->name('distribution_points.destroy');

    // distributions
    Route::get('/distributions', [BeneficiariesController::class, 'indexDistribution'])->name('distributions.index');
    Route::get('/distributions/create', [BeneficiariesController::class, 'createDistribution'])->name('distributions.create');
    Route::post('/distributions', [BeneficiariesController::class, 'storeDistribution'])->name('distributions.store');
    Route::get('/distributions/{distribution}', [BeneficiariesController::class, 'showDistribution'])->name('distributions.show');
    Route::put('/distributions/{distribution}', [BeneficiariesController::class, 'updateDistribution'])->name('distributions.update');
    Route::delete('/distributions/{distribution}', [BeneficiariesController::class, 'destroyDistribution'])->name('distributions.destroy');

    Route::get('/reports', [ReportingController::class, 'index'])->name('reports.index');
    Route::get('/reports/export/excel', [ReportingController::class, 'exportExcel'])->name('reports.export.excel');
    Route::get('/reports/export/pdf', [ReportingController::class, 'exportPDF'])->name('reports.export.pdf');
    Route::get('/reports/export/csv', [ReportingController::class, 'exportCSV'])->name('reports.export.csv');
});


require __DIR__ . '/auth.php';
