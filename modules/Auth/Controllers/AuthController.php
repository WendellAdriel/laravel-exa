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
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    #[OA\Post(
        path: '/v1/auth/login',
        description: 'Login',
        tags: ['Auth'],
    )]
    #[OA\RequestBody(
        description: 'Login credentials',
        required: true,
        content: new OA\JsonContent(properties: [
            new OA\Property(property: 'email', type: 'string'),
            new OA\Property(property: 'password', type: 'string'),
        ]),
    )]
    #[OA\Response(
        response: '200',
        description: 'Successful login',
        content: new OA\JsonContent(properties: [
            new OA\Property(property: 'type', type: 'string'),
            new OA\Property(property: 'token', type: 'string'),
        ]),
    )]
    public function login(Request $request, Login $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(
            new LoginResource($action->handle(LoginDTO::fromRequest($request)))
        );
    }

    #[OA\Post(
        path: '/v1/auth/logout',
        description: 'Logout',
        security: [['jwt' => []]],
        tags: ['Auth'],
    )]
    #[OA\Response(
        response: '204',
        description: 'Successful logout',
    )]
    public function logout(): NoContentResponse
    {
        Auth::guard('web')->logout();

        return new NoContentResponse();
    }

    #[OA\Get(
        path: '/v1/auth/me',
        description: 'Get current user',
        security: [['jwt' => []]],
        tags: ['Auth'],
    )]
    #[OA\Response(
        response: '200',
        description: 'The current user',
        content: new OA\JsonContent(properties: [
            new OA\Property(property: 'uuid', type: 'string'),
            new OA\Property(property: 'name', type: 'string'),
            new OA\Property(property: 'email', type: 'string'),
            new OA\Property(property: 'role', type: 'string'),
            new OA\Property(property: 'active', type: 'boolean'),
            new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
            new OA\Property(property: 'updated_at', type: 'string', format: 'date-time'),
        ]),
    )]
    public function user(): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new UserResource(Auth::user()));
    }
}
