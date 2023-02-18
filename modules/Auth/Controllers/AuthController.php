<?php

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Exa\Http\Responses\ApiSuccessResponse;
use Exa\Http\Responses\NoContentResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Actions\Login;
use Modules\Auth\DTOs\LoginDTO;
use Modules\Auth\Resources\LoginResource;
use Modules\Auth\Resources\UserResource;

class AuthController extends Controller
{
    public function login(Request $request, Login $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(
            new LoginResource($action->handle(LoginDTO::fromRequest($request)))
        );
    }

    public function logout(): NoContentResponse
    {
        Auth::guard('web')->logout();

        return new NoContentResponse();
    }

    public function user(): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new UserResource(Auth::user()));
    }
}
