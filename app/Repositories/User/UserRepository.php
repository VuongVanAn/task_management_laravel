<?php


namespace App\Repositories\User;


use App\Repositories\BaseRepository;
use App\User;

class UserRepository extends BaseRepository implements IUserRepository
{

    public function getModel()
    {
        return User::class;
    }
}