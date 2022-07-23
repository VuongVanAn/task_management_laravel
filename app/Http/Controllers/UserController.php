<?php

namespace App\Http\Controllers;

use App\Repositories\User\IUserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UserController extends BaseController
{
    public function __construct(IUserRepository $userRepository)
    {
        parent::__construct($userRepository);
    }

    public function index()
    {
        return parent::findAll('is_deleted', null);
    }

    public function profile()
    {
        $user = Auth::user();
        return view('profile', compact('user', $user));
    }

    public function updateAvatar(Request $request)
    {
        try {
            $request->validate([
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $user = Auth::user();
            if ($user->avatar != null) {
                $avatarExist = $user->avatar;
                File::delete('assets/avatars/' . $avatarExist);
            }

            $avatarName = $user->id . '_avatar' . time() . '.' . $request->avatar->extension();
            $request->avatar->move("assets/avatars", $avatarName);
            $user->avatar = $avatarName;
            $user->save();
            return response()->json(['status' => 'true', 'avatar' => $avatarName]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'false', 'avatar' => $request->avatar->extension()]);
        }
    }

    protected function beforeSave(Request $request, $fieldValue)
    {

    }
}