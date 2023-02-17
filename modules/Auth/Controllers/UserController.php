<?php

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Exa\DTOs\DatatableDTO;
use Exa\Http\Responses\ApiSuccessResponse;
use Exa\Http\Responses\NoContentResponse;
use Illuminate\Http\Request;
use Modules\Auth\Actions\CreateUser;
use Modules\Auth\Actions\DeleteUser;
use Modules\Auth\Actions\FetchUser;
use Modules\Auth\Actions\FetchUsersList;
use Modules\Auth\Actions\UpdateUser;
use Modules\Auth\DTOs\CreateUserDTO;
use Modules\Auth\DTOs\UpdateUserDTO;

class UserController extends Controller
{
    public function index(Request $request, FetchUsersList $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse($action->handle(DatatableDTO::fromRequest($request)));
    }

    public function show(string $uuid, FetchUser $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse($action->handle($uuid));
    }

    public function store(Request $request, CreateUser $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse($action->handle(CreateUserDTO::fromRequest($request)));
    }

    public function update(Request $request, string $uuid, UpdateUser $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse($action->handle($uuid, UpdateUserDTO::fromRequest($request)));
    }

    public function destroy(string $uuid, DeleteUser $action): NoContentResponse
    {
        $action->handle($uuid);

        return new NoContentResponse();
    }
}
