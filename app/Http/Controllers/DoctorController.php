<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorRequest;
use App\Jobs\Doctor\SendPasswordMail;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($request->has('search') && $search === null) {
            return redirect()->route('doctors.index');
        }

        $query = Doctor::with(['user', 'clinic', 'specializations']);

        if (!empty($search)) {
            $query->whereHas('user', function ($q) use ($search) {
                $terms = explode(' ', $search);

                if (count($terms) === 2) {
                    $q->where(function ($subQuery) use ($terms) {
                        $subQuery->where('first_name', 'like', "%{$terms[0]}%")
                            ->where('last_name', 'like', "%{$terms[1]}%");
                    });
                } else {
                    $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                }
            });
        }

        $doctors = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clinics = Clinic::all();
        $specializations = Specialization::all();
        return view('doctors.create', compact('clinics', 'specializations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DoctorRequest $request)
    {
        $data = $request->validated();
        $password = Str::random(16);

        $userData = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($password),
            'date_of_birth' => $data['date_of_birth'],
            'gender' => $data['gender'] ?? null,
            'address' => $data['address'],
            'phone_number' => $data['phone_number'],
            'role_id' => 2,
        ];

        if ($request->hasFile('photo')) {
            $userData['photo'] = $request->file('photo')->store('photos/doctors', 'public');
        }

        $user = User::create($userData);

        $doctor = Doctor::create([
            'user_id' => $user->id,
            'clinic_id' => $data['clinic_id'],
            'position' => $data['position'],
            'bio' => $data['bio'],
            'appointment_duration' => $data['appointment_duration'],
        ]);

        $doctor->specializations()->sync($data['specializations'] ?? []);

        SendPasswordMail::dispatch($user, $password);

        return redirect()->route('doctors.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        $doctor->load(['user', 'clinic', 'specializations']);
        return view('doctors.show', compact('doctor'));


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        $clinics = Clinic::all();
        $specializations = Specialization::all();
        $selectedSpecializations = $doctor->specializations()->pluck('specializations.id')->toArray();

        return view('doctors.edit', compact('doctor', 'clinics', 'specializations', 'selectedSpecializations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DoctorRequest $request, Doctor $doctor)
    {
        $data = $request->validated();

        $userData = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'date_of_birth' => $data['date_of_birth'],
            'gender' => $data['gender'] ?? null,
            'address' => $data['address'],
            'phone_number' => $data['phone_number'],
        ];

        if ($request->hasFile('photo')) {
            $existingPhoto = $doctor->user->getAttributes()['photo'];

            if ($existingPhoto && Storage::disk('public')->exists($existingPhoto)) {
                Storage::disk('public')->delete($existingPhoto);
            }

            $userData['photo'] = $request->file('photo')->store('photos/doctors', 'public');
        }

        $doctor->user->update($userData);

        $doctor->update([
            'clinic_id' => $data['clinic_id'],
            'position' => $data['position'],
            'bio' => $data['bio'],
            'appointment_duration' => $data['appointment_duration'],
        ]);

        $doctor->specializations()->sync($data['specializations'] ?? []);

        return redirect()->route('doctors.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        $existingPhoto = $doctor->user->getAttributes()['photo'];

        if ($existingPhoto && Storage::disk('public')->exists($existingPhoto)) {
            Storage::disk('public')->delete($existingPhoto);
        }

        $doctor->user->delete();
        $doctor->delete();

        return redirect()->route('doctors.index');
    }
}
