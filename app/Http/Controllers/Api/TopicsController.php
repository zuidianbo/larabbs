<?php

namespace App\Http\Controllers\Api;

use App\Models\Topic;
use Illuminate\Http\Request;

use App\Http\Queries\TopicQuery;

use App\Http\Resources\TopicResource;
use App\Http\Requests\Api\TopicRequest;

use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

use App\Models\User;

class TopicsController extends Controller
{
    public function store(TopicRequest $request, Topic $topic)
    {
//        dd($request->user()->id);

//        print_r($request->user());


        $topic->fill($request->all());
        $topic->user_id = $request->user()->id;
        $topic->save();

        return new TopicResource($topic);
    }



    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);

        $topic->fill($request->all());
//        die($topic->title);

        $topic->update($request->all());
        return new TopicResource($topic);
    }



    public function destroy(Topic $topic)
    {
        $this->authorize('destroy', $topic);

        $topic->delete();

        return response(null, 204);
    }

//列表

//    public function index(Request $request, Topic $topic)
//    {
//        $query = $topic->query();
//
//        if ($categoryId = $request->category_id) {
//            $query->where('category_id', $categoryId);
//        }
//
////        $topics = $query->withOrder($request->order)->paginate();
//
//        $topics = $query
//            ->with('user', 'category')
//            ->withOrder($request->order)
//            ->paginate();
//
//
//        return TopicResource::collection($topics);
//    }



    public function index(Request $request, TopicQuery $query)
    {
        $topics = $query->paginate();

        return TopicResource::collection($topics);
    }

    public function userIndex(Request $request, User $user, TopicQuery $query)
    {
        $topics = $query->where('user_id', $user->id)->paginate();

        return TopicResource::collection($topics);
    }

    public function show($topicId, TopicQuery $query)
    {
        $topic = $query->findOrFail($topicId);
        return new TopicResource($topic);
    }
}