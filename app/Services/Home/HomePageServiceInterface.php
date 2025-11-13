<?php

namespace App\Services\Home;

use App\Models\User;
use Illuminate\Support\Collection;

interface HomePageServiceInterface
{
    public function getHomeData(User $user): Collection;
}
