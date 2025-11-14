<?php 
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
class UserController extends Controller {
    public function find (User $user){
        return $user;
    }
}