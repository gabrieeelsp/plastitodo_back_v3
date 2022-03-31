<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\v1\AuthController;

use App\Http\Controllers\api\v1\EmpresaController;
use App\Http\Controllers\api\v1\SucursalController;
use App\Http\Controllers\api\v1\UserController;
use App\Http\Controllers\api\v1\StockproductController;
use App\Http\Controllers\api\v1\SaleproductController;

use App\Http\Controllers\api\v1\ClientController;

use App\Http\Controllers\api\v1\CajaController;

use App\Http\Controllers\api\v1\ValorController;

use App\Http\Controllers\api\v1\SaleController;
use App\Http\Controllers\api\v1\DevolutionController;
use App\Http\Controllers\api\v1\CreditnoteController;
use App\Http\Controllers\api\v1\DebitnoteController;

use App\Http\Controllers\api\v1\PaymentmethodController;
use App\Http\Controllers\api\v1\PaymentController;
use App\Http\Controllers\api\v1\RefondController;

use App\Http\Controllers\api\v1\ModelofactController;
use App\Http\Controllers\api\v1\IvaconditionController;

use App\Http\Controllers\api\v1\ComprobanteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(static function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::resource('empresas', EmpresaController::class)->only(['index', 'show']);
    Route::resource('sucursals', SucursalController::class)->only(['index', 'show']);
    Route::resource('stockproducts', StockproductController::class)->only(['index', 'show']);
    Route::resource('saleproducts', SaleproductController::class)->only(['index', 'show']);
    
    Route::resource('sales', SaleController::class)->only(['index', 'show']);

    Route::get('/sales/{id}/make_devolution', [SaleController::class, 'make_devolution']);

    Route::resource('devolutions', DevolutionController::class)->only(['index', 'show']);
});

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    Route::resource('users', UserController::class)->only(['index', 'update']);

    Route::resource('empresas', EmpresaController::class)->only(['store', 'update']);
    Route::resource('sucursals', SucursalController::class)->only(['store', 'update']);
    Route::resource('cajas', CajaController::class)->only(['index', 'store', 'show']);
    Route::post('cajas/{id}/close', [CajaController::class, 'close']);
    Route::get('cajas/find/{id}', [CajaController::class, 'find']);
    Route::resource('clients', ClientController::class)->only(['index', 'show']);
    Route::resource('valors', ValorController::class)->only(['index', 'show']);

    Route::get('clients/{id}/movements', [ClientController::class, 'get_movements']);    


    //venta
    Route::get('get_sale_products_venta', [SaleproductController::class, 'get_sale_products_venta']);
    Route::resource('sales', SaleController::class)->only(['store']);

    Route::resource('devolutions', DevolutionController::class)->only(['store']);
    Route::resource('creditnotes', CreditnoteController::class)->only(['store']);
    Route::resource('debitnotes', DebitnoteController::class)->only(['store']);

    Route::resource('payments', PaymentController::class)->only(['store']);
    Route::resource('refonds', RefondController::class)->only(['store']);

    Route::resource('paymentmethods', PaymentmethodController::class)->only(['index', 'show']);

    Route::resource('modelofacts', ModelofactController::class)->only(['index', 'show']);

    Route::resource('ivaconditions', IvaconditionController::class)->only(['index', 'show']);

    Route::post('sales/make_comprobante_factura', [ComprobanteController::class, 'make_comprobante_factura']);
});
