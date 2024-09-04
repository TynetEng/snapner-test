<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeLogin extends Controller
{
    protected function authenticated(Request $request, $employee)
  {
    $employee->last_seen_at = Carbon::now()->format('Y-m-d H:i:s');
    $employee->save();
  }
}