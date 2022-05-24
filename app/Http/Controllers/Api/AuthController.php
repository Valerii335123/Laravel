<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * @var \App\Repositories\User\UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;

    /**
     * @param \App\Repositories\User\UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param \App\Http\Requests\User\LoginRequest $request
     */
    public function login(LoginRequest $request)
    {
        $user = $this->userRepository->findByEmail($request->email);

        //Check password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return new JsonResponse(
                [
                    'message' => __('Bad credentials')
                ], Response::HTTP_UNAUTHORIZED
            );
        }

        if (!$user->email_verified_at) {
            return new JsonResponse(
                [
                    'message' => trans('messages.email.need-verify')
                ], Response::HTTP_UNAUTHORIZED
            );
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        return new JsonResponse(
            [
                'token' => $token,
            ], Response::HTTP_OK
        );

    }

}
