<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ToDoList\SearchRequest;
use App\Http\Requests\ToDoList\StoreRequest;
use App\Http\Requests\ToDoList\UpdateRequest;
use App\Http\Resources\ToDoList\ToDoListResource;
use App\Models\ToDoList\Dto\SearchToDoListDto;
use App\Models\ToDoList\ToDoList;
use App\Models\ToDoList\UseCase\Complete;
use App\Models\ToDoList\UseCase\Store;
use App\Models\ToDoList\UseCase\Update;
use App\Repositories\ToDoList\ToDoListRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ToDoListController extends Controller
{

    /**
     * @param \App\Repositories\ToDoList\ToDoListRepositoryInterface $toDoListRepository
     */
    public function __construct(protected ToDoListRepositoryInterface $toDoListRepository)
    {
    }

    /**
     * @param \App\Http\Requests\ToDoList\SearchRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(SearchRequest $request)
    {
        $searchDto = new SearchToDoListDto(
            Auth::user(),
            $request->title,
            $request->priority,
            $request->status,
            $request->sort_by,
            $request->direction,
        );

        $TodoLists = $this->toDoListRepository->search($searchDto);

        return ToDoListResource::collection($TodoLists);
    }

    /**
     * @param \App\Http\Requests\ToDoList\StoreRequest $request
     * @return \App\Http\Resources\ToDoList\ToDoListResource
     */
    public function store(StoreRequest $request): ToDoListResource
    {
        $store    = new Store(
            Auth::user(),
            $request->title,
            $request->description,
            $request->priority,
            $request->parent_id,
        );
        $toDoList = $store->handler();

        return new ToDoListResource($toDoList);

    }


    /**
     * @param \App\Models\ToDoList\ToDoList $todolist
     * @param \App\Http\Requests\ToDoList\UpdateRequest $request
     * @return \App\Http\Resources\ToDoList\ToDoListResource
     */
    public function update(ToDoList $todolist, UpdateRequest $request): ToDoListResource
    {
        if ($todolist->user_id != Auth::user()->id) {
            abort(404);
        }

        $update   = new Update(
            $todolist,
            $request->title,
            $request->description,
            $request->priority,
        );
        $todolist = $update->handler();

        return new ToDoListResource($todolist);
    }

    /**
     * @param \App\Models\ToDoList\ToDoList $toDoList
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ToDoList $todolist): JsonResponse
    {
        if ($todolist->user_id != Auth::user()->id) {
            abort(404);
        }

        if ($todolist->status == TodoList::STATUS_DONE) {

            return new JsonResponse(
                [
                    'message' => trans('messages.todoList.delete_fail')
                ], Response::HTTP_FORBIDDEN
            );
        }

        if ($this->toDoListRepository->childTodoListExist($todolist)) {

            return new JsonResponse(
                [
                    'message' => trans('messages.TodoList.delete_fail')
                ], Response::HTTP_FORBIDDEN
            );
        }

        $todolist->delete();

        return new JsonResponse(
            [
                'message' => trans('messages.todoList.deleted')
            ], Response::HTTP_OK
        );
    }

    /**
     * @param \App\Models\ToDoList\ToDoList $toDoList
     * @return \Illuminate\Http\JsonResponse
     */
    public function complete(ToDoList $todolist): JsonResponse
    {
        if ($todolist->user_id != Auth::user()->id) {
            abort(404);
        }

        if ($this->toDoListRepository->childTodoListExist($todolist) || $todolist->status == TodoList::STATUS_DONE) {

            return new JsonResponse(
                [
                    'message' => trans('messages.todoList.can_not_be_completed')
                ], Response::HTTP_FORBIDDEN
            );
        }

        $compete = new Complete($todolist);
        $compete->handler();

        return new JsonResponse(
            [
                'message' => trans('messages.todoList.deleted')
            ], Response::HTTP_OK
        );
    }
}
