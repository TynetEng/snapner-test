<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use App\Models\project;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;
use App\Mail\sendMail;
use App\Mail\ApprovalNotification;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Hash;

class ProjectController extends Controller
{
    public function index()
    {
        return Project::all();
    }

    // To create project
    public function createProject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:projects,name|max:255',
            'description' => 'nullable',
            'status' => 'required|in:pending,in progress,completed',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 401);
        }

        $project = Project::create($request->all());
        return response()->json($project, 200);
    }

    // To display Poject created
    public function showProject(Project $project)
    {
        return $project;
    }

    // To update project
    public function updateProject(Request $request, Project $project)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:projects,name,' . $project->id . '|max:255',
            'description' => 'nullable',
            'status' => 'required|in:pending,in progress,completed',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 401);
        }

        $project->update($request->all());
        return response()->json($project);
    }

    // To delete project
    public function destroyProject(Project $project)
    {
        $project->delete();

        $message = 'project deleted sucessfully';
        return response()->json([
            'success'=> true,
            'message'=> $message
        ],200);
    }

    // Dashboard
    public function dashboard()
    {
        $totalProjects = Project::count();
        $totalEmployees = Employee::count();
        $projectsByStatus = Project::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        return response()->json([
            'total_projects' => $totalProjects,
            'total_employees' => $totalEmployees,
            'projects_by_status' => $projectsByStatus
        ]);
    }

    // search API
    public function search(Request $request)
    {
        $query = Project::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        return $query->get();
    }


}
