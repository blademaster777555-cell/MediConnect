<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\City;
use App\Models\Specialization;
use App\Models\Appointment;
use App\Models\MedicalContent;
use App\Models\User;
use App\Models\DoctorProfile;
use App\Models\PatientProfile;
use App\Models\ContactMessage;
use App\Services\DashboardService;
use App\Services\DoctorService;

class HomeController extends Controller
{
    protected $dashboardService;
    protected $doctorService;

    public function __construct(DashboardService $dashboardService, DoctorService $doctorService)
    {
        $this->dashboardService = $dashboardService;
        $this->doctorService = $doctorService;
    }

    /**
     * 1. Homepage - Display featured content
     */
    public function index()
    {
        // Expert optimization: Join users to sort by name, Eager load relationships
        $featured_doctors = DoctorProfile::join('users', 'doctor_profiles.user_id', '=', 'users.id')
            ->where('doctor_profiles.is_approved', true)
            ->orderBy('users.name', 'asc')
            ->select('doctor_profiles.*')
            ->with('user', 'specialization')
            ->get();

        $diseases = MedicalContent::where('category', 'disease')->latest()->take(3)->get();
        $news = MedicalContent::where('category', 'news')->latest()->take(3)->get();
        $inventions = MedicalContent::where('category', 'invention')->latest()->take(3)->get();

        return view('home', compact('featured_doctors', 'diseases', 'news', 'inventions'));
    }

    /**
     * 2. TRANG TÌM KIẾM BÁC SĨ
     */
    public function doctors(Request $request)
    {
        $user = Auth::user();
        $userCityId = $user ? $user->city_id : null;

        $filters = $request->only(['city_id', 'specialization_id']);
        if ($request->has('near_me') && $userCityId) {
            $filters['near_me_city_id'] = $userCityId;
        }

        $doctors = $this->doctorService->search($filters);
        $lookup = $this->doctorService->getSearchLookupData();

        return view('doctors.index', [
            'doctors' => $doctors,
            'cities' => $lookup['cities'],
            'specializations' => $lookup['specializations'],
            'userCityId' => $userCityId
        ]);
    }

    /**
     * 3. Doctor Details
     */
    public function show($id)
    {
        $doctor = DoctorProfile::with(['user', 'specialization', 'availabilities' => function($q) {
            $q->where('is_available', 1);
        }])->findOrFail($id);

        return view('doctors.show', compact('doctor'));
    }

    /**
     * 4. Dashboard (ĐÃ GỘP CHUNG XỬ LÝ CHO CẢ 3 VAI TRÒ)
     */
    public function dashboard()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'doctor') {
            return redirect()->route('doctor.dashboard');
        }

        $data = $this->dashboardService->getDashboardData($user);
        return view('dashboard', array_merge($data, ['user' => $user]));
    }
    
    /**
     * 5. News Page
     */
    public function news()
    {
        $news = MedicalContent::where('category', 'news')->latest()->paginate(12);
        return view('news', compact('news'));
    }

    /**
     * 6. Medical Content Detail
     */
    public function postDetail($slug)
    {
        $post = MedicalContent::findOrFail($slug);

        $related = MedicalContent::where('category', $post->category)
                    ->where('id', '!=', $post->id)
                    ->latest()
                    ->take(3)
                    ->get();

        return view('posts.show', compact('post', 'related'));
    }

    /**
     * 7. Contact Form
     */
    public function contact()
    {
        return view('pages.contact');
    }

    /**
     * 8. Send Contact Message
     */
    public function sendContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:191',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', __('Thank you for contacting us! We will respond soon.'));
    }
}