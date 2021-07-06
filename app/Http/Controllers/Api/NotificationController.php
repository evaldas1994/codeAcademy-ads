<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserNotification;
use App\Service\NotificationManager;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(UserNotification::all()->where('user_id', Auth::user()->id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $this->storeSync($request);

        return response()->json($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return UserNotification
     * @throws AuthorizationException
     */
    public function show($id): UserNotification
    {
        $this->authorize('show', UserNotification::find($id));

        return UserNotification::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $this->storeSync($request);

        return response()->json($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy($id): JsonResponse
    {
        $this->authorize('delete', UserNotification::find($id));

        UserNotification::find($id)->delete();

        return response()->json([], 204);
    }

    private function storeSync(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $notificationManager = new NotificationManager();

        $notificationManager->create($user, $request->all());
    }
}
