<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatabaseController extends Controller
{
    // Show as json all users in the database
    public function showUsers()
    {
        $users = DB::table('users')->get();
        return response()->json($users); // Return as JSON
    }

    // Show as json all problems in the database
    public function showProblems()
    {
        $problems = DB::table('problems')->get();
        return response()->json($problems); // Return as JSON
    }

    // Show as json all tags in the database
    public function showTags()
    {
        $tags = DB::table('tags')->get();
        return response()->json($tags); // Return as JSON
    }   

    // Show as json all problem tags in the database
    public function showProblemTags()
    {
        $problemTags = DB::table('problemtags')->get();
        return response()->json($problemTags); // Return as JSON
    }

    // Show as json all user problems in the database
    public function showUserProblems()
    {
        $userProblems = DB::table('userproblems')->get();
        return response()->json($userProblems); // Return as JSON
    }

    // Show as json all user friends in the database
    public function showFriends()
    {
        $friends = DB::table('friends')->get();
        return response()->json($friends); // Return as JSON
    }

    // Show as json all Editorials in the database
    public function showEditorials()
    {
        $editorials = DB::table('editorials')->get();
        return response()->json($editorials); // Return as JSON
    }



    // Show leaderboard view
    public function showLeaderboard()
    {
        $users = DB::table('users')
            ->orderBy('cf_max_rating', 'desc')
            ->get();
        return view('Users.leaderboard', ['users' => $users]);
    }

    // Show editorials list view
    public function showEditorialsList()
    {
        $editorials = DB::table('editorials')
            ->join('problems', 'editorials.problem_id', '=', 'problems.problem_id')
            ->join('users', 'editorials.author_id', '=', 'users.user_id')
            ->select(
                'editorials.*',
                'problems.title as problem_title',
                'users.name as author_name'
            )
            ->orderBy('editorials.created_at', 'desc')
            ->get();
        return view('Editorials.index', ['editorials' => $editorials]);
    }

    // Show single editorial details view
    public function showEditorialDetails($id)
    {
        $editorial = DB::table('editorials')
            ->join('problems', 'editorials.problem_id', '=', 'problems.problem_id')
            ->join('users', 'editorials.author_id', '=', 'users.user_id')
            ->select(
                'editorials.*',
                'problems.title as problem_title',
                'problems.rating as problem_rating',
                'problems.problem_link as problem_link',
                'users.name as author_name',
                'users.cf_handle as author_handle'
            )
            ->where('editorials.editorial_id', $id)
            ->first();
        
        if (!$editorial) {
            abort(404, 'Editorial not found');
        }
        return view('Editorials.details', ['editorial' => $editorial]);
    }

    // Show tags list view
    public function showTagsList()
    {
        $tags = DB::table('tags')
            ->leftJoin('problemtags', 'tags.tag_id', '=', 'problemtags.tag_id')
            ->select(
                'tags.*',
                DB::raw('COUNT(problemtags.problem_id) as problem_count')
            )
            ->groupBy('tags.tag_id', 'tags.tag_name')
            ->orderBy('problem_count', 'desc')
            ->get();
        return view('tags', ['tags' => $tags]);
    }

    // ==================== ADMIN METHODS ====================
    
    // Admin Dashboard
    public function adminDashboard()
    {
        $problemsCount = DB::table('problems')->count();
        $usersCount = DB::table('users')->count();
        $editorialsCount = DB::table('editorials')->count();
        $tagsCount = DB::table('tags')->count();
        
        $recentProblems = DB::table('problems')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        $recentUsers = DB::table('users')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('Admin.dashboard', [
            'problemsCount' => $problemsCount,
            'usersCount' => $usersCount,
            'editorialsCount' => $editorialsCount,
            'tagsCount' => $tagsCount,
            'recentProblems' => $recentProblems,
            'recentUsers' => $recentUsers
        ]);
    }
    

    
    // Admin Editorials List
    public function adminEditorialsList()
    {
        $editorials = DB::table('editorials')->get();
        return view('Admin.editorials_index', ['editorials' => $editorials]);
    }
    
    // Admin Editorials Create (placeholder for now)
    public function adminEditorialsCreate()
    {
        return view('Admin.editorial_edit', ['editorial' => null]);
    }
    
    // Admin Editorials Edit
    public function adminEditorialsEdit($id)
    {
        $editorial = DB::table('editorials')->where('editorial_id', $id)->first();
        return view('Admin.editorial_edit', ['editorial' => $editorial]);
    }
    
    // Admin Editorials Store (placeholder for controller logic later)
    public function adminEditorialsStore(Request $request)
    {
        // TODO: Add validation and store logic
        return redirect()->route('admin.editorials.index')->with('success', 'Editorial created successfully');
    }
    
    // Admin Editorials Update (placeholder for controller logic later)
    public function adminEditorialsUpdate(Request $request, $id)
    {
        // TODO: Add validation and update logic
        return redirect()->route('admin.editorials.index')->with('success', 'Editorial updated successfully');
    }
    
    // Admin Editorials Delete (placeholder for controller logic later)
    public function adminEditorialsDestroy($id)
    {
        // TODO: Add delete logic
        return redirect()->route('admin.editorials.index')->with('success', 'Editorial deleted successfully');
    }
    
    // Admin Tags List
    public function adminTagsList()
    {
        $tags = DB::table('tags')
            ->leftJoin('problemtags', 'tags.tag_id', '=', 'problemtags.tag_id')
            ->select(
                'tags.*',
                DB::raw('COUNT(problemtags.problem_id) as problems_count')
            )
            ->groupBy('tags.tag_id', 'tags.tag_name')
            ->get();
        return view('Admin.tags_index', ['tags' => $tags]);
    }
    
    // Admin Tags Create (placeholder for now)
    public function adminTagsCreate()
    {
        return view('Admin.tag_edit', ['tag' => null]);
    }
    
    // Admin Tags Edit
    public function adminTagsEdit($id)
    {
        $tag = DB::table('tags')->where('tag_id', $id)->first();
        return view('Admin.tag_edit', ['tag' => $tag]);
    }
    
    // Admin Tags Store (placeholder for controller logic later)
    public function adminTagsStore(Request $request)
    {
        // TODO: Add validation and store logic
        return redirect()->route('admin.tags.index')->with('success', 'Tag created successfully');
    }
    
    // Admin Tags Update (placeholder for controller logic later)
    public function adminTagsUpdate(Request $request, $id)
    {
        // TODO: Add validation and update logic
        return redirect()->route('admin.tags.index')->with('success', 'Tag updated successfully');
    }
    
    // Admin Tags Delete (placeholder for controller logic later)
    public function adminTagsDestroy($id)
    {
        // TODO: Add delete logic
        return redirect()->route('admin.tags.index')->with('success', 'Tag deleted successfully');
    }
}
