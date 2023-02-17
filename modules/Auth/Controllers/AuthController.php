<?php

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Exa\Http\Responses\ApiSuccessResponse;
use Exa\Http\Responses\NoContentResponse;
use Illuminate\Http\Request;
use Modules\Auth\Actions\FetchLoggedUser;
use Modules\Auth\Actions\Login;
use Modules\Auth\Actions\Logout;
use Modules\Auth\DTOs\LoginDTO;

class AuthController extends Controller
{
    public function login(Request $request, Login $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse($action->handle(LoginDTO::fromRequest($request)));
    }

    public function logout(Logout $action): NoContentResponse
    {
        $action->handle();

        return new NoContentResponse();
    }

    public function user(FetchLoggedUser $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse($action->handle());
    }
}
