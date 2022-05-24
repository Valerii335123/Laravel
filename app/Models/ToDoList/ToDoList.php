<?php

namespace App\Models\ToDoList;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\TodoListList\TodoListList
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $priority
 * @property mixed $status
 * @property int $user_id
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|TodoList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TodoList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TodoList query()
 * @method static \Illuminate\Database\Eloquent\Builder|TodoList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TodoList whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TodoList whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TodoList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TodoList whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TodoList wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TodoList whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TodoList whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TodoList whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TodoList whereUserId($value)
 * @mixin \Eloquent
 * @property string $complete_at
 * @property-read TodoList|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder|TodoList whereCompleteAt($value)
 */
class ToDoList extends Model
{
    use HasFactory;
    use SoftDeletes;

    const STATUS_TODO = 'todo';
    const STATUS_DONE     = 'done';


    /**
     * @var string[]
     */
    protected $dates = [
        'complete_at',
    ];

    /**
     * @return string[]
     */
    public static function getAvailableSortField()
    {
        return [
            'created_at',
            'complete_at',
            'priority',
        ];
    }

    /**
     * @return string[]
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_TODO => self::STATUS_TODO,
            self::STATUS_DONE     => self::STATUS_DONE,
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * @param int|null $priority
     * @return void
     */
    public function setPriority(?int $priority): void
    {
        if (!empty($priority) && $priority >= 1 && $priority <= 5) {
            $this->priority = $priority;
        }
        else $this->priority = 1;
    }
}
