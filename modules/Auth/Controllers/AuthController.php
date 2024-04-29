<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Exa\Http\Responses\ApiSuccessResponse;
use Exa\Http\Responses\NoContentResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Actions\Login;
use Modules\Auth\DTOs\LoginDTO;
use Modules\Auth\Resources\LoginResource;
use Modules\Auth\Resources\UserResource;
use OpenApi\Attributes as OA;

final class AuthController extends Controller
{
    #[OA\Post(
        path: '/v1/auth/login',
        description: 'Login',
        tags: ['Auth'],
    )]

    #[OA\RequestBody(
        description: 'Login credentials',
        required: true,
        content: new OA\JsonContent(ref: '#/components/schemas/login'),
    )]

    #[OA\Response(
        response: '200',
        description: 'Successful login',
        content: new OA\JsonContent(ref: '#/components/schemas/login-response'),
    )]
    #[OA\Response(response: '401', description: 'Unauthorized')]
    #[OA\Response(response: '403', description: 'Forbidden')]
    #[OA\Response(response: '422', description: 'Invalid Data')]
    #[OA\Response(response: '500', description: 'Server Error')]
    public function login(LoginDTO $dto, Login $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new LoginResource($action->handle($dto)));
    }

    #[OA\Post(
        path: '/v1/auth/logout',
        description: 'Logout',
        security: [['jwt' => []]],
        tags: ['Auth'],
    )]

    #[OA\Response(response: '204', description: 'Successful logout')]
    #[OA\Response(response: '401', description: 'Unauthorized')]
    #[OA\Response(response: '403', description: 'Forbidden')]
    #[OA\Response(response: '500', description: 'Server Error')]
    public function logout(): NoContentResponse
    {
        auth()->logout(true);

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
        content: new OA\JsonContent(ref: '#/components/schemas/user'),
    )]
    #[OA\Response(response: '401', description: 'Unauthorized')]
    #[OA\Response(response: '403', description: 'Forbidden')]
    #[OA\Response(response: '500', description: 'Server Error')]
    public function user(): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new UserResource(Auth::user()));
    }
}
