<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Employee;
use App\Models\Project;
use App\Mail\sendMail;
use App\Mail\ApprovalNotification;
use Illuminate\Support\Facades\Mail;
use Validator;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;
class EmployeeController extends Controller
{

    public function __construct(){
        $this->employee = new Employee;
    }

    // Email notification
    public function sendMail($to, $mailData, $which) {
        
        try {
            $mailer = Mail::to($to);
            if($which === 'project') {
                $mailer->send(new ProjectCreatedNotification($mailData));
            }
        } catch (\Exception $e) {
            dd($e);
            dd([
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }
    }

    // Employee registration
    public function registerEmployee(Request $request, Project $project){
       $email = $request->email;
       $password = $request->password;
       $confirm   = $request->confirm_password;
       $position   = $request->position;
       $name = $request->name;
      

       $inputValues['email'] = $email;
       $rules = array('email' => 'unique:employees,email');
       $validator = Validator::make($inputValues, $rules);

       if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => "Email exists already..",
            ],403);
        }else{
            
            $employee = $this->employee->create([
                'name' => $name,
                'email'=> $request->email,
                'password' => Hash::make($request->password),
                'position' => $position,
              
            ]);
            return($password);

            $employee = $project->employees()->create($request->all());

    
            Mail::to($employee->email)->send(new WelcomeEmployee($employee));

            $response['message'] = "Successful registration";
                return response()->json([
                    "success"=>true,
                    "message"=>$response,
                    'employee'=>$employee
                ],200);
        }

    }

    // Employee Login
    public function loginEmployee(Request $request){

        $validator = Validator::make($request->only('email','password'), [
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        if($validator->fails())
        {
            return response()->json([
                "success" => false,
                "message" => $validator->messages()->toArray(),
            ],405);
        }
        $jwt_token = null;

        $input = $request->only("email","password");

        if(!$jwt_token = auth('employee')->attempt($input))
        {
            return response()->json([
                'success'=>false,
                'message'=> 'Invalid Email / Password'
            ],403);
        }
        
        return response()->json([
            'success'=>true,
            'token'=> $jwt_token
        ],200);
    }

    // Employee logout
    public function logoutEmployee(Request $request){
        auth()->guard('employee')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success'=>true,
            'message'=> "You've successfully logout! Enter your details to login"
        ],200);
    }


    public function index(Project $project)
    {
        return $project->employees;
    }

    // To update employee
    public function updateEmployee(Request $request, Project $project, Employee $employee)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'position' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $employee->update($request->all());
        return response()->json($employee);
        
    }

    // To delete employee
    public function destroyEmployee(Project $project, Employee $employee)
    {
        $employee->delete();
        $response['message'] = "Employee deleted successfully";
        return response()->json([
            "success"=>true,
            "message"=>$response
        ],200);
}
}
