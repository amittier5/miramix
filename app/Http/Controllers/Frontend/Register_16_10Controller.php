<?php namespace App\Http\Controllers\Frontend; /* path of this controller*/

use App\Model\Brandmember; /* Model name*/
use App\Model\Address; /* Model name*/
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Input; /* For input */
use Validator;
use Session;
use Imagine\Image\Box;
use Image\Image\ImageInterface;
use Illuminate\Pagination\Paginator;
use DB;
use Hash;
use Mail;
use App\Helper\helpers;


class RegisterController extends Controller {

    public function __construct() 
    {
       // view()->share('brand_class','active');
    }
   /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        //echo phpinfo();exit;
        $country = DB::table('countries')->orderBy('name','ASC')->get();
        // echo "<pre>";print_r($country); exit;
        $alldata = array();
        foreach($country as $key=>$value)
        {
            $alldata[$value->country_id] = $value->name;
        }
        //echo "<pre>";print_r($alldata); exit;
        return view('frontend.register.create',compact('alldata'));
    }

    public function brandRegister()
    {
        $country = DB::table('countries')->orderBy('name','ASC')->get();
        
        $alldata = array();
        foreach($country as $key=>$value)
        {
            $alldata[$value->country_id] = $value->name;
        }
		 //echo "<pre>";print_r($alldata); exit;
        return view('frontend.register.registerbrand',compact('alldata'));
       // return view('frontend.register.brandRegister',compact('alldata'));
    }
    

    public function create()
    {

        return view('frontend.register.create');
    }

    public function store(Request $request)
    {
        $register=Request::all();
        //print_r($register);
        $obj = new helpers();
        if(Input::hasFile('image'))
        {
            $destinationPath = 'uploads/img/'; // upload path
            $thumb_path = 'uploads/img/thumb/';
            $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
            $fileName = rand(111111111,999999999).'.'.$extension; // renameing image
            Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
            
            $obj->createThumbnail($fileName,300,200,$destinationPath,$thumb_path);
        }
        else
        {
            $fileName = '';
        }
        $hashpassword = Hash::make($register['password']);
        $address = New Address;

        $brandmember= Brandmember::create([
            'fname'             => $register['fname'],
            'lname'             => $register['lname'],
            'email'             => $register['email'],
            'password'          => $hashpassword,
            'phone_no'          => $register['phone_no'],
            'pro_image'         => $fileName,
            'role'              => 0,                   // for member role is "0"
            'admin_status'      => 1,                   // Admin status
            'updated_at'        => date('Y-m-d H:i:s'),
            'created_at'        => date('Y-m-d H:i:s')
        ]);

        $lastInsertedId = $brandmember->id;

        $address->mem_brand_id = $lastInsertedId;
        $address->address = $register['address'];
        $address->address2 = $register['address2'];
        $address->country_id = $register['country'];
        $address->zone_id = $register['state']; // State id
        $address->city = $register['city'];
        $address->postcode = $register['postcode'];
        
        if($address->save()) 
        {
            $addressId = $address->id;
            $dataUpdateAddress = DB::table('brandmembers')
                ->where('id', $lastInsertedId)
                ->update(['address' => $addressId]);

            $sitesettings = DB::table('sitesettings')->get();
            //exit;
            if(!empty($sitesettings))
            {
                foreach($sitesettings as $each_sitesetting)
                {
                  if($each_sitesetting->name == 'email')
                  {
                    $admin_users_email = $each_sitesetting->value;
                  }
                }
            }

            $user_name = $register['fname'].' '.$register['lname'];
            $user_email = $register['email'];
            $activateLink = url().'/activateLink/'.base64_encode($register['email']);
            $sent = Mail::send('frontend.register.activateLink', array('name'=>$user_name,'email'=>$user_email,'activate_link'=>$activateLink), 
            function($message) use ($admin_users_email, $user_email,$user_name)
            {
                $message->from($admin_users_email);
                $message->to($user_email, $user_name)->subject('Activate Profile Mail');
            });

            if( ! $sent) 
            {
                Session::flash('error', 'something went wrong!! Mail not sent.'); 
                return redirect('register');
            }
            else
            {
                Session::flash('success', 'Registration completed successfully.Please check your email to activate your account.'); 
                return redirect('register');
            }
        }
        
    }

    public function getState()
    {
        $country_id = Input::get('countryId');
        
        $state = DB::table('zones')
                    ->where('country_id', '=', $country_id)
                    ->get();
        //echo "<pre>";print_r($state); exit;
        $alldata = array();
        $str='';
        foreach($state as $key=>$value)
        {
            //$alldata[$value->zone_id] = $value->name;
            $str .= '<option value='.$value->zone_id.'>'.$value->name.'</option>';
        }

        echo $str;
        exit;
    }

    public function emailChecking()
    {
        $email_id = Input::get('email');
        
        $email_count = DB::table('brandmembers')
                    ->where('email', '=', $email_id)
                    ->count();
        if($email_count >0)
        {
            echo  1; // Email already exist.
        }
        else
        {
            echo 0 ; // New email for registration.
        }
    }
    

    /* for activate Register user */
    public function activateLink($email=false)
    {
        $useremail = base64_decode($email);
        //$useremail = 'sumitra1.unified@gmail.com';

        $active_count = DB::table('brandmembers')
                            ->where('email', '=', $useremail)
                            ->where('status', '=', 1)->count();

        //echo $active_count;   exit; 

        if($active_count > 0)
        {
            Session::flash('error', 'Your account has been already activated.Please login with your valid credentials.'); 
            return redirect('register');
        }
        else
        {
            $success = DB::table('brandmembers')
                ->where('email', $useremail)
                ->update(['status' => 1]);

            if($success)
            {
                Session::flash('success', 'Your account has been activated.Please login with your valid credentials.'); 
                return redirect('register');
            }
            else
            {
                Session::flash('error', 'Your account has not been activated.Please try again.'); 
                return redirect('register');
            }
        }
        
        
    }
    
}