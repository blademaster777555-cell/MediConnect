<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminCityController;
use App\Http\Controllers\AdminSpecializationController;
use App\Http\Controllers\MedicalContentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\Api\DataController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/doctors', [HomeController::class, 'doctors'])->name('doctors.index');
Route::get('/doctors/{id}', [HomeController::class, 'show'])->name('doctors.show');
Route::get('/news', [HomeController::class, 'news'])->name('news');
Route::get('/bai-viet/{slug}', [HomeController::class, 'postDetail'])->name('posts.detail');
Route::get('/about-us', function() { return view('pages.about'); })->name('about');
Route::get('/contact-us', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact-us', [HomeController::class, 'sendContact'])->name('contact.send');

/*
|--------------------------------------------------------------------------
| Patient Routes (Authenticated)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Appointments
    Route::get('/my-appointments', [AppointmentController::class, 'myAppointments'])->name('my.appointments');
    Route::post('/appointment/book', [AppointmentController::class, 'store'])->name('appointment.store');
    Route::post('/appointment/cancel/{id}', [AppointmentController::class, 'cancel'])->name('appointment.cancel');
    
    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    
    // Feedback
    Route::get('/feedback/create/{appointment}', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    
    // Medical Records (Patient View)
    Route::get('/medical-records/{medicalRecord}', [MedicalRecordController::class, 'show'])->name('medical-records.show');
});

/*
|--------------------------------------------------------------------------
| Doctor Routes (Authenticated + Doctor Role)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->prefix('doctor')->group(function () {
    // 1.0 Login: Doctor account already verified via auth middleware
    
    // 2.0 Manage Profile
    Route::get('/profile', [DoctorController::class, 'profile'])->name('doctor.profile');
    Route::put('/profile', [DoctorController::class, 'updateProfile'])->name('doctor.profile.update');
    
    // 3.0 Manage Availability: Set available time slots
    Route::get('/schedule', [DoctorController::class, 'schedule'])->name('doctor.schedule');
    Route::post('/schedule', [DoctorController::class, 'storeSchedule'])->name('doctor.schedule.store');
    
    // 4.0 View Appointments: See the list of patients who have scheduled appointments
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
    Route::get('/appointments', [DoctorController::class, 'appointments'])->name('doctor.appointments');
    Route::post('/appointments/{id}/status', [DoctorController::class, 'updateStatus'])->name('doctor.appointment.status');
    
    // Medical Records
    Route::get('/medical-records', [MedicalRecordController::class, 'index'])->name('doctor.medical-records.index');
    Route::get('/medical-records/create/{appointment}', [MedicalRecordController::class, 'create'])->name('medical-records.create');
    Route::post('/medical-records', [MedicalRecordController::class, 'store'])->name('medical-records.store');
    Route::get('/medical-records/{medicalRecord}', [MedicalRecordController::class, 'show'])->name('medical-records.show');
    Route::get('/medical-records/{medicalRecord}/edit', [MedicalRecordController::class, 'edit'])->name('medical-records.edit');
    Route::put('/medical-records/{medicalRecord}', [MedicalRecordController::class, 'update'])->name('medical-records.update');
    Route::delete('/medical-records/{medicalRecord}', [MedicalRecordController::class, 'destroy'])->name('medical-records.destroy');
    
    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('doctor.notifications');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Authenticated + Admin Role)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'is_admin'])->prefix('admin')->group(function () {
    // 1.0 Login: Admin account already verified via auth middleware
    
    // 2.0 Manage Users: Add, Delete, Edit, Lock
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('users', AdminController::class); // Giữ lại resource này để dùng cho create/store/edit/update/destroy chung
    
    // Routes quản lý riêng
    Route::get('/doctors', [AdminController::class, 'doctors'])->name('admin.doctors.index');
    Route::get('/patients', [AdminController::class, 'patients'])->name('admin.patients.index');
    Route::post('/doctors/{id}/approve', [AdminController::class, 'approveDoctor'])->name('admin.doctors.approve');
    
    // Manage Doctor Schedule
    Route::get('/doctors/{id}/schedule', [AdminController::class, 'doctorSchedule'])->name('admin.doctors.schedule');
    Route::post('/doctors/{id}/schedule', [AdminController::class, 'updateDoctorSchedule'])->name('admin.doctors.schedule.update');
    
    // 3.0 Manage Cities/Specializations
    Route::resource('cities', AdminCityController::class);
    Route::resource('specializations', AdminSpecializationController::class);
    
    // 4.0 Manage Content: Publish and manage medical articles
    Route::resource('medical-content', MedicalContentController::class);
    
    // Appointments Management
    Route::get('/appointments', [AdminController::class, 'appointments'])->name('admin.appointments');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('admin.appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'storeAdmin'])->name('admin.appointments.store');
    Route::get('/appointments/{id}/edit', [AdminController::class, 'editAppointment'])->name('admin.appointments.edit');
    Route::put('/appointments/{id}', [AdminController::class, 'updateAppointment'])->name('admin.appointments.update');
    Route::delete('/appointments/{id}', [AdminController::class, 'destroyAppointment'])->name('admin.appointments.destroy');
    
    // Feedbacks
    Route::get('/feedbacks', [FeedbackController::class, 'index'])->name('admin.feedbacks.index');
    Route::get('/feedbacks/{feedback}', [FeedbackController::class, 'show'])->name('admin.feedbacks.show');
    Route::delete('/feedbacks/{feedback}', [FeedbackController::class, 'destroy'])->name('admin.feedbacks.destroy');
    
    // Contact Messages
    Route::get('/contact-messages', [ContactMessageController::class, 'index'])->name('admin.contact-messages.index');
    Route::get('/contact-messages/{contactMessage}', [ContactMessageController::class, 'show'])->name('admin.contact-messages.show');
    Route::post('/contact-messages/{contactMessage}/mark-read', [ContactMessageController::class, 'markAsRead'])->name('admin.contact-messages.mark-read');
    Route::delete('/contact-messages/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('admin.contact-messages.destroy');
    
    // Admin Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('admin.notifications.index');
    
    // Medical Records (Admin view all)
    Route::get('/medical-records', [MedicalRecordController::class, 'index'])->name('admin.medical-records.index');
    Route::get('/medical-records/{medicalRecord}', [MedicalRecordController::class, 'show'])->name('admin.medical-records.show');
});

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::prefix('api')->group(function () {
    Route::get('/cities', [DataController::class, 'cities'])->name('api.cities');
    Route::get('/specializations', [DataController::class, 'specializations'])->name('api.specializations');
    Route::get('/combobox-data', [DataController::class, 'comboboxData'])->name('api.combobox-data');
    
    Route::get('/doctor-availability', [DataController::class, 'getDoctorAvailability'])->name('api.doctor-availability');
    
    // Notifications API (Authenticated)
    Route::middleware('auth')->get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('api.notifications.unread-count');
});

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'vi'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('change_language');

require __DIR__.'/auth.php';