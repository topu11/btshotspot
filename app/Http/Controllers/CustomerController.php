<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use File;

class CustomerController extends Controller
{
    public function requestotp(Request $request)
    {
        $response = array();
        if ( $request->phone != NULL  && (strlen($request->phone)>10)) {
            $Customer = new Customer;
            $Customer->phone = $request->phone;
            $Customer->otp = rand(100000, 999999);

            $OtpsResponse = $Customer->sendSMS($Customer->otp,$Customer->phone);

            if($OtpsResponse['error']){
                // $response['error'] = 1;
                $response['status'] = 'failed';
                $response['message'] = $OtpsResponse['message'];
            }else{
                $OldCustomer = Customer::where('phone', $request->phone)->latest('created_at')->first();
                if($OldCustomer != NULL) {
                    $response['status'] = 'success';
                    $response['message'] = 'Your OTP is created.';
                    $response['phone'] = $Customer->phone;
                    $response['otp'] = $Customer->otp;
                    $response['id'] = $OldCustomer->id;
                    $OldCustomer->otp = $Customer->otp;
                    $OldCustomer->save();
                } else{
                    // $response['error'] = 0;
                    $response['status'] = 'success';
                    $response['message'] = 'Your OTP is created.';
                    $response['phone'] = $Customer->phone;
                    $response['otp'] = $Customer->otp;
                    $Customer->save();
                    $response['id'] = $Customer->id;
                }
            }            
        } else {
            // $response['error'] = 1; 
            $response['status'] = 'failed';
            $response['message'] = 'Invalid mobile number';
        }
        return response()->json(['response' => $response ]);
    }

    public function verifyotp(Request $request)
    {
        $response = array();
        $enteredOtp = $request->otp;
        $userId = Customer::where('id', $request->id)->latest('created_at')->first();

        if($userId == "" || $userId == null){
            $response['status'] = 'failed';
            $response['message'] = 'User id not found.';
        }else{
            $OTP = $userId->otp;
            if($OTP == $enteredOtp){
                $userId->isVerified = 1;
                $userId->otp = NULL;
                $userId->save();
                $response['status'] = 'success';
                $response['isVerified'] = 1;      
                $response['message'] = "Your Number is Verified.";              
            }else{
                $userId->isVerified = 0;
                $userId->save();
                $response['status'] = 'failed';
                $response['isVerified'] = 0;           
                $response['message'] = "OTP does not match.";   
            }
        }
        return response()->json(['response' => $response ]);
    }

    public function registercustomer(Request $request)
    {
        //dd($request->all());
        // $validator = Validator::make($request->all(), [
        //     'photo' => 'mimes:jpeg,png,jpg,JPG',
        //     'nidfpp' => 'mimes:jpeg,png,jpg,JPG',
        //     'nidbpp' => 'mimes:jpeg,png,jpg,JPG',
        // ]);
        // if ($validator->fails()) {
        //     return response()->json(['response' => $validator->errors()], 422);
        // }
        
        $response = array();
        $customer = Customer::where('id', $request->id)->latest('created_at')->first();
        if($customer != NULL && $customer->isVerified != 0) {
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->dob = $request->dob;

            if ($request->photo != NULL) {
                // $full_path1=public_path() . '/storage/uploads/customers/'.$customer->photo;
                // if (file_exists($full_path1)) {
                //     unlink($full_path1);
                // }

                $image1 = $request->photo;  // your base64 encoded
                $image1 = str_replace('data:image/jpeg;base64,', '', $image1);
                $image1 = str_replace(' ', '+', $image1);
                $imageName1 = uniqid().'.'.'jpg';
                $decoded_image1 = base64_decode($image1);
                Storage::put('/public/uploads/customers/'.$customer->id.'/'.$imageName1, $decoded_image1);
                $customer->photo = $imageName1;
            }
            

            // if ($request->hasFile('photo')) {
            //     $full_path1=public_path() . '/uploads/customers/'.$customer->photo;
            //     if (file_exists($full_path1)) {
            //         unlink($full_path1);
            //     }

            //     $file1 = $request->file('photo');
            //     $original_name1 = $request->file('photo')->getClientOriginalName();
            //     $image1 = str_random(5) . '_' . $original_name1;
            //     $destinationPath1 = public_path() . '/uploads/customers/';
            //     $file1->move($destinationPath1, $image1);
            //     $customer->photo = $image1;
            // }
            if ($request->nidfpp != NULL) {
                // $full_path2=public_path() . '/storage/uploads/customers/'.$customer->nidfpp;
                // if (file_exists($full_path2)) {
                //     unlink($full_path2);
                // }

                $image2 = $request->nidfpp;  // your base64 encoded
                $image2 = str_replace('data:image/jpeg;base64,', '', $image2);
                $image2 = str_replace(' ', '+', $image2);
                $imageName2 = uniqid().'.'.'jpg';
                $decoded_image2 = base64_decode($image2);
                Storage::put('/public/uploads/customers/'.$customer->id.'/'.$imageName2, $decoded_image2);
                $customer->nidfpp = $imageName2;
            }
            // if ($request->hasFile('nidfpp')) {
            //     $full_path2=public_path() . '/uploads/customers/'.$customer->nidfpp;
            //     if (file_exists($full_path2)) {
            //         unlink($full_path2);
            //     }

            //     $file2 = $request->file('nidfpp');
            //     $original_name2=$request->file('nidfpp')->getClientOriginalName();
            //     $image2 = str_random(5) . '_' . $original_name2;
            //     $destinationPath2 = public_path() . '/uploads/customers/';
            //     $file2->move($destinationPath2, $image2);
            //     $customer->nidfpp = $image2;
            // }
            if ($request->nidbpp != NULL) {
                // $full_path3=public_path() . '/storage/uploads/customers/'.$customer->nidbpp;
                // if (file_exists($full_path3)) {
                //     unlink($full_path3);
                // }

                $image3 = $request->nidbpp;  // your base64 encoded
                $image3 = str_replace('data:image/jpeg;base64,', '', $image3);
                $image3 = str_replace(' ', '+', $image3);
                $imageName3 = uniqid().'.'.'jpg';
                $decoded_image3 = base64_decode($image3);
                Storage::put('/public/uploads/customers/'.$customer->id.'/'.$imageName3, $decoded_image3);
                $customer->nidbpp = $imageName3;
            }
            // if ($request->hasFile('nidbpp')) {
            //     $full_path3=public_path() . '/uploads/customers/'.$customer->nidbpp;
            //     if (file_exists($full_path3)) {
            //         unlink($full_path3);
            //     }

            //     $file3 = $request->file('nidbpp');
            //     $original_name3=$request->file('nidbpp')->getClientOriginalName();
            //     $image3 = str_random(5) . '_' . $original_name3;
            //     $destinationPath3 = public_path() . '/uploads/customers/';
            //     $file3->move($destinationPath3, $image3);
            //     $customer->nidbpp = $image3;
            // }
            $customer->password = $request->password;
            $customer->package = $request->package;
            $customer->validity = $request->validity;
            $customer->price = $request->price;
            $customer->fcmtoken = $request->fcmtoken;
            $customer->save();
            $response['status'] = 'success';
            $response['message'] = 'informations are saved successfully';
        } else{
            $response['status'] = 'failed';
            $response['message'] = 'id not found or otp is not verified';            
        }
        return response()->json(['response' => $response ]);
    }

    public function getcustomer(Request $request)
    {
        $response = array();
        $customer = Customer::where('id', $request->id)->first();
        if($customer != NULL) {
            $response['status'] = 'success';
            $response['customer']['id'] = $customer->id;
            $response['customer']['phone'] = $customer->phone;
            $response['customer']['isVerified'] = $customer->isVerified;
            $response['customer']['name'] = $customer->name;
            $response['customer']['email'] = $customer->email;
            $response['customer']['dob'] = $customer->dob;
            $response['customer']['photo'] = 'http://hotspot.bismillahwireless.com/storage/uploads/customers/'.$customer->id.'/'.$customer->photo;
            $response['customer']['package'] = $customer->package;
            $response['customer']['validity'] = $customer->validity;
            $response['customer']['price'] = $customer->price;
        } else{
            $response['status'] = 'failed';
            $response['message'] = 'id not found';            
        }
        return response()->json(['response' => $response ]);
    }

    public function concheck()
    {
        //dd($request->all());
        echo "hi";
    }
}
