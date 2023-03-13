<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;    

    public function getUserFriends(User $email) {
        try {
            $friends = $email->reqs->where("status", "accepted")->map(fn($val) => $val->requestor);
            return response(["friends" => $friends], Response::HTTP_OK);
        } catch (\Throwable $th) {
            report($th->getMessage());
        }
    }

    public function getCommonFriendFromFriends(Request $req) {
        try {
            $user1 = User::where('email', $req->email1)->firstOrFail()->reqs->where("status", "accepted")->map(fn($val) => $val->requestor);
            $user2 = User::where('email', $req->email2)->firstOrFail()->reqs->where("status", "accepted")->map(fn($val) => $val->requestor);
            $commonFriends = $user1->merge($user2)->duplicates()->values();
        return response($commonFriends, Response::HTTP_OK);
        } catch (\Throwable $th) {
            report($th->getMessage());
        }
    }
}
