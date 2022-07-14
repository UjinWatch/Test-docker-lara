<?php

namespace App\Http\Controllers\Twitter\Update;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tweet;
use App\Services\TweetService;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, TweetService $tweetService)
    {
        $tweetId = (int) $request->route('tweetId');
        if (!$tweetService->checkOwnTweet($request->user()->id, $tweetId)) {
            throw new AccessDeniedHttpException();
        }

        $tweet = Tweet::where('id', $tweetId)->firstOrFail();
        return view('twitter.update')->with('tweet', $tweet);
        /*
         $tweet = Tweet::where('id', $tweetId)->first();
        if (is_null($tweet)) {
            throw new NotFoundHttpException('存在しないつぶやきです');
        }
        dd($tweetId);
        }*/
    }
}
