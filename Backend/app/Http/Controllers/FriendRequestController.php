<?php

namespace App\Http\Controllers;

use App\Http\Requests\FriendReqRequest;
use App\Models\FriendRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FriendRequestController extends Controller
{
    public function store(FriendReqRequest $req) {
        FriendRequest::create($req->all());
        return response(["success" => true], Response::HTTP_CREATED);
    }

    public function updateFriendRequest(FriendReqRequest $req) {
        FriendRequest::where("to", $req->to)->where("requestor", $req->requestor)->firstOrFail()->update(["status" => $req->status]);
        return response(['success' => true], Response::HTTP_OK);
    }

    public function getUserRequest(User $email) {
        $frq = $email->reqs->map->only("requestor", "status");
        return response(["requests" => $frq], Response::HTTP_OK);
    }

    public function blockUserRequest(Request $req) {
        $user = User::where("email", $req->requestor)->firstOrFail();
        $user->blocks()->create(["email" => $req->block]);
        return response(["success" => true], Response::HTTP_CREATED);
    }
}
