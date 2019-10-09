<?php


namespace App\Repositories\User;


use App\Repositories\EloquentRepository;
use App\User;

class UserRepository extends EloquentRepository
{
    protected $userModel;

    public function __construct(User $userModel)
    {
        parent::__construct($userModel);
    }
}