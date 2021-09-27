<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return view('profile',compact('user',$user));
    }

    public function updateAvatar(Request $request){
        try {
            $request->validate([
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
    
            $user = Auth::user();
            if ($user->avatar != null) {
                $avatarExist = $user->avatar;
                File::delete('assets/avatars/'.$avatarExist);
            }
    
            $avatarName = $user->id.'_avatar'.time().'.'.$request->avatar->extension();
            $request->avatar->move("assets/avatars", $avatarName);
            $user->avatar = $avatarName;
            $user->save();
            return response()->json(['status' => 'true', 'avatar' => $avatarName]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'false', 'avatar' => $request->avatar->extension()]);
        }
    }

}