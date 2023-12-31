<?php

namespace App\Moneypenny\Home\Contracts;

use App\Moneypenny\User\Models\User;
use Illuminate\Support\Collection;

interface HomePageServiceInterface
{
    public function getHomeData(User $user): Collection;
}
