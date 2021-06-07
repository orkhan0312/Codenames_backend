 <?php

use App\Http\Controllers\AuthController;
 use App\Http\Controllers\CardController;
 use App\Http\Controllers\ClueController;
 use App\Http\Controllers\GameController;
 use App\Http\Controllers\TeamController;
 use App\Http\Controllers\TurnController;
 use App\Http\Controllers\UserController;
 use App\Http\Controllers\UserTeamController;
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
Route::put('users/{id}', [UserController::class, 'update']);
Route::delete('users/{id}', [UserController::class, 'delete']);
Route::get('users/token', [AuthController::class, 'getUserByToken']);

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::post('changePassword', [AuthController::class, 'changePassword']);

Route::get('games', [GameController::class, 'get']);
Route::post('games', [GameController::class, 'create']);
Route::get('games/token', [GameController::class, 'getGameByToken']);
Route::put('games/id', [GameController::class, 'update']);

Route::get('cards', [CardController::class, 'get']);
Route::get('cards/id', [CardController::class, 'getByGameId']);
Route::put('cards/id', [CardController::class, 'update']);
Route::get('cards/card', [CardController::class, 'getByCardId']);


Route::get('teams', [TeamController::class, 'get']);

 Route::get('users/teams', [UserTeamController::class, 'get']);
 Route::post('users/teams', [UserTeamController::class, 'add']);
 Route::get('users/teams/id', [UserTeamController::class, 'getByGameId']);

 Route::get('clues', [ClueController::class, 'get']);
 Route::post('clues', [ClueController::class, 'add']);
 Route::get('clues/game', [ClueController::class, 'getByGameId']);

 Route::get('turns', [TurnController::class, 'get']);
 Route::get('turns/game', [TurnController::class, 'getByGameId']);
 Route::put('turns', [TurnController::class, 'update']);
