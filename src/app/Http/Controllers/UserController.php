<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Relationship;
use Exception;
use vierbergenlars\SemVer\expression;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $loginUser = Auth::user();
        // $selectedUser = User::find($id);
        $selectedUser = User::with(['followingUser','followedUser', 'posts'])->find($id);
        // dd($selectedUser->followingUser->count());
        $isIndex = true;
        $isSelf = $loginUser->id == $id;
        $isFollowing = $loginUser->isfollowingOrNot($selectedUser);

        return view('user.detail', compact(
                                    'selectedUser',
                                    'loginUser',
                                    'isIndex',
                                    'isFollowing',
                                    'isSelf'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        return view('user.edit', ['user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);
    
            $input = $request->input();
            unset($input['_method'], $input['_token']);
            $input = array_diff($input, array(null));
            $user->fill($input);

            if(!($request->file('image') * $input)){
                throw new Exception();
            }

            if($request->file('image')) {
                
                if($user->icon_image) {
                    Storage::dist('s3')->delete($user->icon_image);
                }
    
                $imageName = Storage::disk('s3')
                            ->putFile('icon_images', $request->file('image'));
                
                // dd($imageName);
                
                $iconUrl = Storage::disk('s3')->url($imageName);
                // dd($iconUrl);
                $user->icon_image = $iconUrl;
            
            }
            $user->save();
            DB::commit();
            return redirect("/user/{$id}");
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
