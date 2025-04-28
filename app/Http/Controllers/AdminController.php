<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;

class AdminController extends Controller
{
    public function users()
    {
        return User::all();
    }

    public function orders()
    {
        return Order::all();
    }
}
