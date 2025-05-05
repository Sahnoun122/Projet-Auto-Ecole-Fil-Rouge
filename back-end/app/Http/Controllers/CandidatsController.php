<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; // Add this line
use App\Models\Quiz; // Add this line
use App\Models\Title; // Add this line
use App\Models\Course; // Add this line
use App\Models\CourseView; // Add this line

class CandidatsController extends Controller
{
    public function dashboard()
    {
        /** @var \App\Models\User $candidat */
        $candidat = Auth::user();

        // --- Progress Summary ---
        // Assuming 'type_permis' on User determines relevant titles
        // Adjust this logic if your application assigns courses differently
        $relevantTitleIds = Title::where('type_permis', $candidat->type_permis)->pluck('id'); // Corrected column name

        $totalCourses = Course::whereIn('title_id', $relevantTitleIds)->count();

        $completedCoursesCount = 0;
        if ($totalCourses > 0) {
             $completedCoursesCount = CourseView::where('user_id', $candidat->id)
                                       ->whereIn('course_id', function($query) use ($relevantTitleIds) {
                                           $query->select('id')
                                                 ->from('courses')
                                                 ->whereIn('title_id', $relevantTitleIds);
                                       })
                                       ->distinct('course_id') // Ensure we count each course only once
                                       ->count();
        }


        $progressPercentage = $totalCourses > 0 ? round(($completedCoursesCount / $totalCourses) * 100) : 0;
        $remainingCourses = $totalCourses - $completedCoursesCount;

        // --- Notifications ---
        // Fetch latest 5 unread notifications
        $notifications = $candidat->unreadNotifications()->latest()->take(5)->get();

        // --- Quizzes ---
        // Fetch latest 3 quizzes (adjust query if quizzes are specific to candidate/permis)
        $quizzes = Quiz::orderBy('created_at', 'desc')->take(3)->get();

        return view('candidats.dashboard', compact(
            'candidat',
            'progressPercentage',
            'remainingCourses',
            'totalCourses',
            'notifications',
            'quizzes'
        ));
    }
    
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $candidats = User::where('role', 'candidat')
            ->when($search, function($query) use ($search) {
                return $query->where('nom', 'like', "%$search%")
                             ->orWhere('prenom', 'like', "%$search%")
                             ->orWhere('email', 'like', "%$search%")
                             ->orWhere('telephone', 'like', "%$search%")
                             ->orWhere('type_permis', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    
        return view('admin.candidats', compact('candidats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'photo_profile' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'photo_identite' => 'required|file|mimes:pdf|max:2048', 
            'type_permis' => 'required|string|max:255',
            'password' => ['required','string','min:8','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/'],
        ]);

        $validated['photo_profile'] = $request->file('photo_profile')->store('candidats/profile', 'public');
        $validated['photo_identite'] = $request->file('photo_identite')->store('candidats/identite', 'public');
        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'candidat';

        User::create($validated);

        return redirect()->route('admin.candidats')->with('success', 'Candidat ajouté avec succès');
    }

    public function update(Request $request, $id)
    {
        $candidat = User::findOrFail($id);

        $rules = [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $candidat->id,
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'type_permis' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/',
        ];

        if ($request->hasFile('photo_profile')) {
            $rules['photo_profile'] = 'image|mimes:jpeg,png,jpg|max:2048';
        }
        if ($request->hasFile('photo_identite')) {
            $rules['photo_identite'] = 'file|mimes:pdf|max:2048';
        }

        $data = $request->validate($rules);

        if ($request->hasFile('photo_profile')) {
            Storage::disk('public')->delete($candidat->photo_profile);
            $data['photo_profile'] = $request->file('photo_profile')->store('candidats/profile', 'public');
        }
        if ($request->hasFile('photo_identite')) {
            Storage::disk('public')->delete($candidat->photo_identite);
            $data['photo_identite'] = $request->file('photo_identite')->store('candidats/identite', 'public');
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $candidat->update($data);

        return redirect()->route('admin.candidats')->with('success', 'Candidat mis à jour avec succès');
    }

    public function show($id)
    {
        $candidat = User::findOrFail($id);
        return response()->json($candidat);
    }

    public function edit($id)
    {
        $candidat = User::findOrFail($id);
        return response()->json($candidat);
    }

    public function destroy($id)
    {
        $candidat = User::findOrFail($id);
        
        Storage::disk('public')->delete([
            $candidat->photo_profile,
            $candidat->photo_identite
        ]);
        
        $candidat->delete();

        return redirect()->route('admin.candidats')->with('success', 'Candidat supprimé avec succès');
    }
}