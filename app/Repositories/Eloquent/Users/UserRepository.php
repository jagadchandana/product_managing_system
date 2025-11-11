<?php

namespace App\Repositories\Eloquent\Users;

use App\Enums\DefaultStatusEnum;
use App\Models\User;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Eloquent\Users\UserInterface;
use Illuminate\Support\Facades\DB;


class UserRepository extends BaseRepository implements UserInterface
{
    /**
     * @var User
     */
    protected $model;

    /**
     * BaseRepository constructor.
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }
}
