<?php
namespace App\Http\Controllers\API;
use App\Mail\Product;
use DeepCopy\f001\A;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use PhpParser\Error;
use Validator;


class UserController extends Controller
{
    public $successStatus = 200;

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $user_info = User::with('usertype','country','company','branch','office')->where('email', '=', request('email'))->first();
            $success['info'] = $user_info;
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            return response()->json(['success' => $success], $this-> successStatus);
        }
        else{
            if(empty( request('email'))){
                return response()->json(['error'=>trans('messages.email_required')], 401);
            }else{
                $result = filter_var( request('email'), FILTER_VALIDATE_EMAIL );
                if ($result == false){
                    return response()->json(['error'=>trans('messages.email_valid')], 401);
                }

                $user = User::where('email', '=', request('email'))->first();
                if (!$user){
                    return response()->json(['error'=>trans('messages.email_exist')], 401);
                }

            }
            if(empty( request('password'))){
                return response()->json(['error'=>trans('messages.password_required')], 401);
            }
            $user = User::where('email', '=', request('email'))->first();
            $hasher = app('hash');
            if ($user && !$hasher->check(request('password'), $user->password)) {
                return response()->json(['error'=>trans('messages.wrong_password')], 401);

            }

        }
    }
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $user = User::where('email', '=', request('email'))->first();
        if ($user){
            return response()->json(['error'=>trans('messages.email_duplicate')], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $user->verfied_code = str_random(4);
        $user->save();

        Mail::to($user)->send(new Product($user));
            return response()->json(['success'=>trans('messages.need_to_verify')], $this-> successStatus);

    }
    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this-> successStatus);
    }

    public function verfiy()
    {
        if(empty( request('email'))){
            return response()->json(['error'=>trans('messages.email_required')], 401);
        }elseif(empty( request('code'))){
            return response()->json(['error'=>trans('messages.code_required')], 401);
        }else{
            $user = User::where('email', '=', request('email'))->first();
            if ($user && $user->verfied_code == request('code') ){
                $user->status = 1;
                $user->verified	 = 1;
                $user->save();

                $user_info = User::with('usertype','country','company','branch','office')->where('email', '=', request('email'))->first();

                $success['info'] = $user_info;
                $success['token'] =  $user->createToken('MyApp')-> accessToken;
                return response()->json(['success'=>$success], $this-> successStatus);
            }else{
                return response()->json(['error'=>trans('messages.code_wrong')], 401);

            }

        }

    }

    public function resend(){
        if(empty( request('email'))) {
            return response()->json(['error' => trans('messages.email_required')], 401);
        }else{
            $user = User::where('email', '=', request('email'))->first();
            if ($user){
                $user->verfied_code = str_random(4);
                $user->save();
                Mail::to($user)->send(new Product($user));
                    return response()->json(['success'=>trans('messages.need_to_verify')], $this-> successStatus);
            }else{
                return response()->json(['error'=>trans('messages.email_exist')], 401);

            }
        }

    }

    public function staff_list(){
        $user = User::where('typeId', '=', 2)->get();
        return response()->json(['success' => $user], $this-> successStatus);
    }

    public function edit_profile(Request $request){
        $user = Auth::guard('api')->user();

        $user->update($request->all());
        if($file = $request->hasFile('image')) {
            $file = $request->file('image') ;
            $fileName = $file->getClientOriginalName() ;
            $destinationPath = public_path().'/uploads/profile/' ;
            $file->move($destinationPath,$fileName);
            $user->image = $fileName ;
        }
        $user->save() ;
        return response()->json($user, 200);
    }

    public function changePassword(Request $request) {
        $data = $request->all();
        $user = Auth::guard('api')->user();


        //Changing the password only if is different of null
        if( isset($data['oldPassword']) && !empty($data['oldPassword']) && $data['oldPassword'] !== "" && $data['oldPassword'] !=='undefined') {
            //checking the old password first
            $check  = Auth::guard('web')->attempt([
                'username' => $user->username,
                'password' => $data['oldPassword']
            ]);
            if($check && isset($data['newPassword']) && !empty($data['newPassword']) && $data['newPassword'] !== "" && $data['newPassword'] !=='undefined') {
                $user->password = bcrypt($data['newPassword']);
                $user->token()->revoke();
                $token = $user->createToken('newToken')->accessToken;

                //Changing the type
                $user->save();

                $user_info = User::with('usertype','country','company','branch','office')->where('id', '=', $user->id)->first();
                $success['info'] = $user_info;
                $success['token'] =  $token;
                return response()->json(['success' => $success], $this-> successStatus);

            }
            else {
                return response()->json(['error'=>trans('messages.Wrong_password_information')], 401);

            }
        }
        return response()->json(['error'=>trans('messages.Wrong_password_information')], 401);

    }

}