<?php

namespace App\Models\TodoList\Dto;

use App\Models\User;

class SearchToDoListDto
{
    /**
     * @param \App\Models\User $user
     * @param string|null $title
     * @param int|null $priority
     * @param string|null $status
     * @param string|null $sortBy
     * @param string|null $direction
     */
    public function __construct(
        public User    $user,
        public ?string $title,
        public ?int    $priority,
        public ?string $status,
        public ?string $sortBy,
        public ?string $direction
    ) {
    }

}
