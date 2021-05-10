 <?php

use App\Http\Controllers\AuthController;
 use App\Http\Controllers\BoardController;
 use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users', [UserController::class, 'get']);
Route::post('users', [UserController::class, 'add']);
Route::put('users/token', [UserController::class, 'update']);
Route::delete('users/token', [UserController::class, 'delete']);
Route::get('users/token', [AuthController::class, 'getUserByToken']);

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);

Route::get('games', [GameController::class, 'get']);
Route::post('games', [GameController::class, 'create']);
Route::get('games/token', [GameController::class, 'getGameByToken']);

Route::get('boards', [BoardController::class, 'get']);
