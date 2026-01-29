# 🏥 Mediconnect Booking Website Project

### Semester 1 - FPT Aptech

A medical appointment scheduling management system between patients and doctors.

## 👥 Team Members

* **Đào Nhuận Phát** - Student1685476 - *Project Lead*
* **Mai Trọng Tín** - Student1685518 - *Developer*
* **Huỳnh Thuận Đạt** - Student1685477 - *Developer*
* **Lê Trọng Hoàng** - Student1686150 - *Developer*

## 📁 Documents

* [Documents](./documents)

## 🧑‍💻 Tech used

* Laravel 10
* Tailwind CSS
* Vite
* MySQL
* HTML
* Blade Template Engine

## 📽️Video Demo

* [🔗Youtube](https://youtu.be/bmJeO7kdF3E)

## Video Script

Greeting to the eProject Team
This is the guide for group 4 website, MediConnect

1. Any user can access the homepage, the medical news page, the "Find doctor" page, MediConnect information and contact information
2. To book an appointment, the user need to log in as a patient, there will be a demo account provided at the end.
3. If the user don't have an account in MediConnect, the user need to register either as a patient or a doctor.



PATIENT SECTION

1. When logged in as a patient, the user will start at the patient dashboard.
2. The user can see their recent upcoming appointments and your appointment history in the dashboard.
3. The user has 4 quick action at the bottom of the page.
4. Go to "Find Doctors" tab and it will direct the user to the "Find Doctors" page. Press "Book Now" to make a booking.
5. In the "Book Appointment" page, select the avaliable date then select the avaliable time. The user can add their symptoms or notes to their doctor. They can press "Confirm booking" to complete the booking process, and wait for the doctor confirmation
6. In the "My Appointments" tab, the user can see the time of their booking, the doctor and their specialties, the patient additional notes, the doctor consultation fee, the payment required and the status of their appointments.
7. The user can cancel their appointment when it's still waiting for confirmation or rate their doctors when their appointment was completed.
8. In the "Update Profile" tab, the user can change their name, email and password.
9. The "Medical News" tab will redirect the user back to the "Medical News" page.



DOCTOR SECTION

When logged in as a doctor, the user will start at the doctor dashboard

2. The user can see their upcoming appointments in the dashboard.
3. In the "Manage Appointments" tab, the user can see the booking time, the patient who booked, the patient's note and the status of the appointment.
4. When a patient book with the user, their appointment will be in "pending" status. The user can "confirm" or "deny" in the action bar and change the appointment status into their respective action. The user can complete an appointment by pressing "confirm" again, changing the appointment status to "Completed".
5. In the "Schedule" tab, the user can see their weekly schedule, including date, start and end time and the status of that date.
6. In "My Profile" tab, the user can update their full name, avatar picture, their phone number, their  specialties, their occupated city or province, their medical license number, their consultation fee, their medical license or certification and their biography. Press "Save Changes" will save the newly editted profile.
7. At the top right, press your account to quickly access to "Dashboard", "Doctor Profile" and "Account Settings". "Dashboard" tab will direct the user back to the doctor dashboard. "Doctor Profile" tab will direct the user back to "My Profile" page. In "Account Settings", the user can change their name, email and password.



ADMIN SECTION

When logged in as an admin, the user will start at the homepage.

2. Press "Overview" in the Navigation bar to open the admin dashboard page.
3. The user can view the number of doctors, patients and number of appointments.
4. In the admin dashboard, the user can perform 4 quick action. "Add User" tab for adding new account, "Manage Appointments" tab to view and edit all appointments in the system, "User List" tab to view and delete account, "Manage Specializations" tab to add, edit or delete the system's medical specialization in the specialization list.
5. In the "Add User" page, the user can create new account using full name, login email, password, phone number, location and role
6. In the "Manage Doctor" page, the user can view and edit the doctor schedule and their profile. The user can also view and delete doctor account.
7. In the "Manage Patient" page, the user can view and edit patient profile. The user can also view and delete patient account.
8. In the "News and Diseases" page, the user can view and create new post and post them on the medical news page.
9. In the "Manage Cities" page, the user can view, edit, create and delete the name of cities that were registered in the system.
10. In the "Feedback" page, the user can view and delete the patient's comment about their doctor on their appointment.
11. Press the bell to view all the notification. The admin will be notified when a new doctor is registered or when a new appointment was made.



Note

Patients can create accounts without any approval from the admin

Doctors can create account, but patients can only book with the newly registered doctors after the admin approval



Demo Accounts:

Patient: khack1@mediconnect.com

Doctor:bacsiquang@mediconnect.com

Admin:admin@mediconnect.com

Password for all demo account: 12345678

