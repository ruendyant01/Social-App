<?php

namespace App\Http\Controllers;

use App\Http\Requests\FriendReqRequest;
use App\Models\FriendRequest;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class FriendRequestController extends Controller
{
    public function store(FriendReqRequest $req) {
        try {       
            $user1 = User::where("email", $req->requestor)->firstOrFail(); 
            $user = User::where("email", $req->to)->firstOrFail();
            if($user->blocks->contains(fn($val) => $val->email === $user1->email)) throw new Exception("You're Blocked");
            FriendRequest::create($req->all());
            return response(["success" => true], Response::HTTP_CREATED);
        } catch (Throwable $th) {
            report($th->getMessage());
        }
    }

    public function updateFriendRequest(FriendReqRequest $req) {
        try {
            $user = User::where("email", $req->requestor)->firstOrFail(); 
            if($req->requestor === $user->email) throw new Exception("Must accepted by the receiver");
            FriendRequest::where("to", $req->to)->where("requestor", $req->requestor)->firstOrFail()->update(["status" => $req->status]);
            return response(['success' => true], Response::HTTP_OK);
        } catch (\Throwable $th) {
            report($th->getMessage());
        }
    }

    public function getUserRequest(User $email) {
        try {
            $frq = $email->reqs->map->only("requestor", "status");
            return response(["requests" => $frq], Response::HTTP_OK);
        } catch (\Throwable $th) {
            report($th->getMessage());
        }
    }

    public function blockUserRequest(Request $req) {
        try {
            User::where("email", $req->block)->firstOrFail();
            $user = User::where("email", $req->requestor)->firstOrFail();
            $user->blocks()->create(["email" => $req->block]);
            return response(["success" => true], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            report($th->getMessage());
        }
    }
}
