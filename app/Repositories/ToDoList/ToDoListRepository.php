<?php

namespace App\Repositories\ToDoList;

use App\Exceptions\ModelNotSaveException;
use App\Models\TodoList\Dto\SearchTodoListDto;
use App\Models\TodoList\TodoList;

class ToDoListRepository implements ToDoListRepositoryInterface
{

    /**
     * @param \App\Models\TodoList\TodoList $model
     * @return void
     * @throws \App\Exceptions\ModelNotSaveException
     */
    public function save(ToDoList $model): void
    {
        if (!$model->save()) {
            throw new ModelNotSaveException(trans('messages.TodoList.save_fail'));
        }
    }

    /**
     * @param int $id
     * @return \App\Models\TodoList\TodoList|null
     */
    public function findById(int $id): TodoList|null
    {
        return TodoList::whereId($id)->first();
    }

    /**
     * @param \App\Models\TodoList\TodoList $TodoList
     * @return bool
     */
    public function childTodoListExist(TodoList $TodoList): bool
    {
        return $TodoList->children()->where('status', TodoList::STATUS_TODO)->exists();
    }

    /**
     * @param \App\Models\TodoList\Dto\SearchTodoListDto $searchTodoListDto
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(SearchTodoListDto $searchTodoListDto): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = TodoList::whereUserId($searchTodoListDto->user->id)
            ->where(function ($query) use ($searchTodoListDto) {
                if (!empty($searchTodoListDto->title)) {
                    $query->where('title', 'like', '%' . $searchTodoListDto->title . '%');
                }
                if (!empty($searchTodoListDto->priority)) {
                    $query->wherePriority($searchTodoListDto->priority);
                }
                if (!empty($searchTodoListDto->status)) {
                    $query->whereStatus($searchTodoListDto->status);
                }
            });

        if (!empty($searchTodoListDto->sortBy) && !empty($searchTodoListDto->direction)) {
            $query->orderBy($searchTodoListDto->sortBy, $searchTodoListDto->direction);
        }

        return $query->paginate();

    }

}
