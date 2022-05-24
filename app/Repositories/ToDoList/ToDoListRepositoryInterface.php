<?php

namespace App\Repositories\ToDoList;


use App\Models\TodoList\Dto\SearchToDoListDto;
use App\Models\TodoList\ToDoList;

interface ToDoListRepositoryInterface
{

    /**
     * @param \App\Models\TodoList\ToDoList $model
     * @return void
     */
    public function save(ToDoList $model): void;

    /**
     * @param int $id
     * @return \App\Models\TodoList\ToDoList|null
     */
    public function findById(int $id): ToDoList|null;

    /**
     * @param \App\Models\TodoList\ToDoList $TodoList
     * @return bool
     */
    public function childTodoListExist(ToDoList $TodoList): bool;

    /**
     * @param \App\Models\TodoList\Dto\SearchToDoListDto $searchTodoListDto
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(SearchToDoListDto $searchTodoListDto): \Illuminate\Contracts\Pagination\LengthAwarePaginator;


}
