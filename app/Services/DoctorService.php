<?php

namespace App\Services;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DoctorService
{
    public function getFilteredDoctors(?string $search, int $perPage = 10)
    {
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

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function createDoctor(array $data): array
    {
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

        if (isset($data['photo'])) {
            $userData['photo'] = $data['photo']->store('photos/doctors', 'public');
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

        return [$doctor, $password];
    }

    public function updateDoctor(Doctor $doctor, array $data): void
    {
        $userData = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'date_of_birth' => $data['date_of_birth'],
            'gender' => $data['gender'] ?? null,
            'address' => $data['address'],
            'phone_number' => $data['phone_number'],
        ];

        if (isset($data['photo'])) {
            $existingPhoto = $doctor->user->getAttributes()['photo'];

            if ($existingPhoto && Storage::disk('public')->exists($existingPhoto)) {
                Storage::disk('public')->delete($existingPhoto);
            }

            $userData['photo'] = $data['photo']->store('photos/doctors', 'public');
        }

        $doctor->user->update($userData);

        $doctor->update([
            'clinic_id' => $data['clinic_id'],
            'position' => $data['position'],
            'bio' => $data['bio'],
            'appointment_duration' => $data['appointment_duration'],
        ]);

        $doctor->specializations()->sync($data['specializations'] ?? []);
    }

    public function deleteDoctor(Doctor $doctor): void
    {
        $existingPhoto = $doctor->user->getAttributes()['photo'];

        if ($existingPhoto && Storage::disk('public')->exists($existingPhoto)) {
            Storage::disk('public')->delete($existingPhoto);
        }

        $doctor->user->delete();
        $doctor->delete();
    }
}
