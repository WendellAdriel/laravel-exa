<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Exa\DTOs\DatatableDTO;
use Exa\Http\Responses\ApiSuccessResponse;
use Exa\Http\Responses\NoContentResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Auth\Actions\CreateUser;
use Modules\Auth\Actions\DeleteUser;
use Modules\Auth\Actions\FetchUser;
use Modules\Auth\Actions\FetchUsersList;
use Modules\Auth\Actions\UpdateUser;
use Modules\Auth\DTOs\CreateUserDTO;
use Modules\Auth\DTOs\UpdateUserDTO;
use Modules\Auth\Resources\UserResource;
use OpenApi\Attributes as OA;

final class UserController extends Controller
{
    #[OA\Get(
        path: '/v1/users',
        description: 'Get users list',
        security: [['jwt' => []]],
        tags: ['Users Management'],
    )]

    #[OA\Parameter(name: 'page', in: 'query', required: false, schema: new OA\Schema(type: 'integer', default: 1))]
    #[OA\Parameter(name: 'per_page', in: 'query', required: false, schema: new OA\Schema(type: 'integer', default: 20))]
    #[OA\Parameter(name: 'sort_field', in: 'query', required: false, schema: new OA\Schema(type: 'string'))]
    #[OA\Parameter(name: 'sort_order', in: 'query', required: false, schema: new OA\Schema(type: 'string', enum: ['asc', 'desc']))]
    #[OA\Parameter(name: 'search', in: 'query', required: false, schema: new OA\Schema(type: 'string'))]

    #[OA\Response(
        response: '200',
        description: 'The list of users',
        content: new OA\JsonContent(properties: [
            new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/user')),
            new OA\Property(property: 'links', ref: '#/components/schemas/pagination-links'),
            new OA\Property(property: 'meta', ref: '#/components/schemas/pagination-meta'),
        ]),
    )]
    #[OA\Response(response: '401', description: 'Unauthorized')]
    #[OA\Response(response: '403', description: 'Forbidden')]
    #[OA\Response(response: '500', description: 'Server Error')]
    public function index(Request $request, FetchUsersList $action): JsonResponse
    {
        return UserResource::collection($action->handle(DatatableDTO::fromRequest($request)))->response();
    }

    #[OA\Get(
        path: '/v1/users/{uuid}',
        description: 'Get user',
        security: [['jwt' => []]],
        tags: ['Users Management'],
    )]

    #[OA\Parameter(name: 'uuid', in: 'path', required: true, schema: new OA\Schema(type: 'string'))]

    #[OA\Response(
        response: '200',
        description: 'The user',
        content: new OA\JsonContent(ref: '#/components/schemas/user'),
    )]
    #[OA\Response(response: '401', description: 'Unauthorized')]
    #[OA\Response(response: '403', description: 'Forbidden')]
    #[OA\Response(response: '404', description: 'Not Found')]
    #[OA\Response(response: '500', description: 'Server Error')]
    public function show(string $uuid, FetchUser $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new UserResource($action->handle($uuid)));
    }

    #[OA\Post(
        path: '/v1/users',
        description: 'Create user',
        security: [['jwt' => []]],
        tags: ['Users Management'],
    )]

    #[OA\RequestBody(
        description: 'User data',
        required: true,
        content: new OA\JsonContent(ref: '#/components/schemas/create-user'),
    )]

    #[OA\Response(
        response: '200',
        description: 'The created user',
        content: new OA\JsonContent(ref: '#/components/schemas/user'),
    )]
    #[OA\Response(response: '401', description: 'Unauthorized')]
    #[OA\Response(response: '403', description: 'Forbidden')]
    #[OA\Response(response: '422', description: 'Invalid Data')]
    #[OA\Response(response: '500', description: 'Server Error')]
    public function store(Request $request, CreateUser $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(
            new UserResource($action->handle(CreateUserDTO::fromRequest($request))),
            Response::HTTP_CREATED
        );
    }

    #[OA\Put(
        path: '/v1/users/{uuid}',
        description: 'Update user',
        security: [['jwt' => []]],
        tags: ['Users Management'],
    )]

    #[OA\Parameter(name: 'uuid', in: 'path', required: true, schema: new OA\Schema(type: 'string'))]

    #[OA\RequestBody(
        description: 'User data',
        required: true,
        content: new OA\JsonContent(ref: '#/components/schemas/update-user'),
    )]

    #[OA\Response(
        response: '200',
        description: 'The updated user',
        content: new OA\JsonContent(ref: '#/components/schemas/user'),
    )]
    #[OA\Response(response: '401', description: 'Unauthorized')]
    #[OA\Response(response: '403', description: 'Forbidden')]
    #[OA\Response(response: '404', description: 'Not Found')]
    #[OA\Response(response: '422', description: 'Invalid Data')]
    #[OA\Response(response: '500', description: 'Server Error')]
    public function update(Request $request, string $uuid, UpdateUser $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(
            new UserResource($action->handle($uuid, UpdateUserDTO::fromRequest($request)))
        );
    }

    #[OA\Delete(
        path: '/v1/users/{uuid}',
        description: 'Delete user',
        security: [['jwt' => []]],
        tags: ['Users Management'],
    )]

    #[OA\Parameter(name: 'uuid', in: 'path', required: true, schema: new OA\Schema(type: 'string'))]

    #[OA\Response(response: '204', description: 'User deleted')]
    #[OA\Response(response: '401', description: 'Unauthorized')]
    #[OA\Response(response: '403', description: 'Forbidden')]
    #[OA\Response(response: '404', description: 'Not Found')]
    #[OA\Response(response: '500', description: 'Server Error')]
    public function destroy(string $uuid, DeleteUser $action): NoContentResponse
    {
        $action->handle($uuid);

        return new NoContentResponse();
    }
}
