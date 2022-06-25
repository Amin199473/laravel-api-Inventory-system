<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PosController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SalaryController;
use App\Http\Controllers\Api\SupplierController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// JWT Routes
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [AuthController::class, 'signup']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});


//Employee Routes
Route::apiResource('/employee', EmployeeController::class);


//Supplier Routes
Route::apiResource('/supplier', SupplierController::class);

//Category Routes
Route::apiResource('/category', CategoryController::class);

//Product Routes
Route::apiResource('/product', ProductController::class);
Route::post('/stock/update/{id}', [ProductController::class, "StockUpdate"]);

//Expense Routes
Route::apiResource('/expense', ExpenseController::class);

//Salary Routes
Route::post('/salary/paid/{id}', [SalaryController::class, 'Paid']);
Route::get('/salary', [SalaryController::class, 'index']);
Route::get('/salary/view/{id}', [SalaryController::class, 'ViewSalary']);
Route::get('/edit/salary/{id}', [SalaryController::class, 'EditSalary']);
Route::post('/update/salary/{id}', [SalaryController::class, 'UpdateSalary']);

//Customer Routes
Route::apiResource('/customer', CustomerController::class);


//Pos Routes
Route::get('/getting/product/{id}',[PosController::class,'GetProducts']);
Route::post('/orderDone',[PosController::class,'OrderDone']);


//Cart Routes
Route::get('/addToCart/{id}',[CartController::class,'AddToCart']);
Route::get('/cart/products/',[CartController::class,'CartProducts']);
Route::get('/cart/increment/{id}',[CartController::class,'CartIncrement']);
Route::get('/cart/decrement/{id}',[CartController::class,'CartDecrement']);
Route::get('/remove/cart/{id}',[CartController::class,'RemoveCart']);
Route::get('/vats',[CartController::class,'Vats']);


//Order Routes
Route::get('/orders',[OrderController::class,'TodayOrders']);
Route::get('/order/{id}',[OrderController::class,'Order']);
Route::get('/order/details/{id}',[OrderController::class,'OrderDetails']);
Route::post('/search/order/',[OrderController::class,'SearchOrderByDate']);


//Admin Dashboard Routes
Route::Get('/today/sell', [PosController::class,'TodaySell']);
Route::Get('/today/income', [PosController::class,'TodayIncome']);
Route::Get('/today/due', [PosController::class,'TodayDue']);
Route::Get('/today/expense', [PosController::class,'TodayExpense']);
Route::Get('/today/stockout', [PosController::class,'Stockout']);
