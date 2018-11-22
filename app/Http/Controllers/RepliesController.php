<?php
//
//namespace App\Http\Controllers;
//
//use App\Reply;
//use App\Thread;
//use Illuminate\Http\Request;
//
//class RepliesController extends Controller
//{
//    public function __construct()
//    {
//        $this->middleware('auth', ['except' => 'index']);
//    }
//
//    /**
//     * @param $channelId
//     * @param Thread $thread
//     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
//     */
//    public function index($channelId, Thread $thread)
//    {
//        return $thread->replies()->paginate(20);
//    }
//
//    /**
//     * @param $channelId
//     * @param Thread $thread
//     * @return \Illuminate\Http\RedirectResponse
//     */
//    public function store($channelId, Thread $thread)
//    {
//        $this->validate(request(), ['body' => 'required']);
//
//        $reply = $thread->addReply([
//            'body' => request('body'),
//            'user_id' => auth()->id()
//        ]);
//
//        if (request()->expectsJson()) {
//            return $reply->load('owner');
//        }
//
//        return back()->with('flash', 'Your reply has been left');
//    }
//
//
//    /**
//     * @param Reply $reply
//     * @throws \Illuminate\Auth\Access\AuthorizationException
//     */
//    public function update(Reply $reply)
//    {
//        $this->authorize('update', $reply);
//        $reply->update(request(['body']));
//    }
//
//    public function destroy(Reply $reply)
//    {
//        $this->authorize('update', $reply);
//
//        $reply->delete();
//
//        if (request()->expectsJson()) {
//            return response(['status' => 'Reply deleted']);
//        }
//
//        return back();
//    }
//}
//



namespace App\Http\Controllers;
use App\Reply;
use App\Thread;
class RepliesController extends Controller
{
    /**
     * Create a new RepliesController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    /**
     * Fetch all relevant replies.
     *
     * @param int $channelId
     * @param Thread $thread
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }
    /**
     * Persist a new reply.
     *
     * @param  integer $channelId
     * @param  Thread  $thread
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($channelId, Thread $thread)
    {
        $this->validate(request(), ['body' => 'required']);
        $reply = $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);
        if (request()->expectsJson()) {
            return $reply->load('owner');
        }
        return back()->with('flash', 'Your reply has been left.');
    }

    /**
     * Update an existing reply.
     *
     * @param Reply $reply
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);
        $this->validate(request(), ['body' => 'required']);
        $reply->update(request(['body']));
    }

    /**
     * Delete the given reply.
     *
     * @param  Reply $reply
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);
        $reply->delete();
        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }
        return back();
    }
}