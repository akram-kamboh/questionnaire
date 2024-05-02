<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $user = User::create([ "name" => $request->name]);
            return $this->successResponse("", $user->id);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function saveAnswer(Request $request)
    {
        try {
            $userAnswer = UserAnswer::create($request->only(["user_id", "question_id", "answer_id", "is_skipped"]));
            return $this->successResponse("", $userAnswer);
        } catch (\Exception $e) {
            return $this->errorResponse("Something wrong, please try again");
        }
    }

    public function showResults($id)
    {
        $result = UserAnswer::leftJoin("answers As ans", function ($query) {
                $query->where("ans.id",  \DB::raw('user_answers.answer_id'));
            })
            ->select(\DB::raw("COUNT(*) as total"), \DB::raw('SUM(is_skipped) as skipped'), \DB::raw('SUM(CASE WHEN ans.is_correct = 0 THEN 1 ELSE 0 END) as wrong'))
            ->where("user_id", $id)->first();
        return $this->successResponse("", $result);
    }
}
