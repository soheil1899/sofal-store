<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\Role;
use App\Store;
use App\User;
use App\Userinfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user');
    }

    public function getusers()
    {
        $roles = Role::orderBy('id','asc')->get();
        $users = User::with('roles.permissions')->get();

        foreach (auth()->user()->roles as $userrole){
            if($userrole['id'] == 1){
                $myrole = 'superadmin';
                foreach ($users as $key=>$user){
                    if($user['id'] == auth()->user()->id){
                        unset($users[$key]);
                    }
                }
                if(auth()->user()->id != 1){
                    foreach ($users as $key=>$user){
                        if($user['id'] == 1){
                            unset($users[$key]);
                        }
                    }
                }
            }
            if($userrole['id'] == 4){
                $myrole = 'useradmin';
                foreach ($users as $key=>$user){
                    if($user['roles'][0]['id'] != 2){
                        unset($users[$key]);
                    }
                }
            }
        }



        return [$users, $roles, $myrole];
    }



    public function saveuser(Request $request)
    {
        if($request->editflag != false){
            $this->validate($request,[
                'username' => 'required',
                'email' => 'required|email',
            ]);
            $save = User::where('id', $request->id)->first();
            if($request->passwordedit == true){
                $save->password = bcrypt($request->password);
            }

        }else{
            $this->validate($request,[
                'username' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:8',
            ]);
            $save = new User();
            $save->password = bcrypt($request->password);
        }

        $save->name = $request->username;
        $save->email = $request->email;
        $save->save();

        if ($request->editflag == false){
            $save->roles()->attach(2);
        }
    }

    public function deleteuser(Request $request)
    {
        User::where('id',$request->id)->delete();
    }

    public function saveuseraccess(Request $request)
    {

        $findnoseller = false;
        $accessids = array();
        foreach ($request->accessflag as $key=>$item){
            if($item == true){
                array_push($accessids, $key+1);
            }
            if($item == false){
                if($key == 2){
                    $findnoseller = true;
                }
            }
        }
        if($findnoseller == true){
            Store::where('user_id', $request->userid)->delete();
        }


        $user = User::where('id', $request->userid)->first();
        $user->roles()->sync($accessids);

    }


    public function userinfo($id)
    {
        return view('admin.userinfo', compact('id'));
    }

    public function getuserinfo(Request $request)
    {

        $user = User::where('id', $request->userid)->first();
        $userinfo = Userinfo::where('user_id', $request->userid)->first();

        $comments = Comment::where('user_id', $request->userid)->with('product')->orderBy('created_at', 'desc')->get();

        $user['act'] = 'user';
        $roles = $user->roles()->get();
        $permissions = array();
        foreach ($roles as $role){
            array_push($permissions, $role->permissions()->get());
        }
        for ($i=0; $i<count($permissions); $i++){
            for($j=0; $j<count($permissions[$i]);$j++){
                $per = $permissions[$i][$j]['permission'];

                if($per == 'add_product' or
                    $per == 'edit_product' or $per == 'delete_product'){
                    $user['act'] = 'seller';
                }
            }
        }

        $storeinfo = null;
        if($user['act'] == 'seller'){
            $storeinfo = Store::where('user_id', $request->userid)->first();
        }


        $city = file_get_contents("Province.json");
        $city = json_decode($city, true);

        return [$user, $userinfo, $comments, $storeinfo, $city];
    }

    public function saveuserinfo(Request $request)
    {

        $save = Userinfo::where('user_id', $request->userid)->first();
        if ($save == null){
            $save = new Userinfo();
            $save->user_id = $request->userid;
        }

        $save->firstname = $request->userinfo['firstname'];
        $save->lastname = $request->userinfo['lastname'];
        $save->mellicode = $request->userinfo['mellicode'];
        $save->telephone = $request->userinfo['telephone'];
        $save->mobile = $request->userinfo['mobile'];
        $save->birthday = $request->userinfo['birthday'];
        $save->state = $request->userinfo['state'];
        $save->city = $request->userinfo['city'];
        $save->address = $request->userinfo['address'];
        $save->postcode = $request->userinfo['postcode'];
        $save->newsflag = $request->userinfo['newsflag'];
        $save->save();
    }

    public function savestoreinfo(Request $request)
    {
        $save = Store::where('user_id', $request->userid)->first();
        if ($save == null){
            $save = new Store();
            $save->user_id = $request->userid;
        }

        $save->name = $request->storeinfo['name'];
        $save->state = $request->storeinfo['state'];
        $save->city = $request->storeinfo['city'];
        $save->address = $request->storeinfo['address'];
        $save->telephone = $request->storeinfo['telephone'];
        $save->economic_num = $request->storeinfo['economic_num'];
        $save->national_identity_num = $request->storeinfo['national_identity_num'];
        $save->postcode = $request->storeinfo['postcode'];
        $save->fax = $request->storeinfo['fax'];
        $save->save();
    }
































}
