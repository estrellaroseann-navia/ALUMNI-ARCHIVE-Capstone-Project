<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Program;
use App\Models\Campus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    use Importable;

    /**
     * Map the Excel row to the User and Profile models.
     *
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     * @throws \Throwable
     */
    public function model(array $row)
    {
        return DB::transaction(function () use ($row) {
            // Lookup program and campus foreign keys
            $program = Program::where('name', $row['program_name'] ?? '')->first();
            $campus = Campus::where('name', $row['campus'] ?? '')->first();
            // dd($campus);
            // Validate required fields
            if (empty($row['first_name']) || empty($row['last_name'])) {
                throw new \Exception("First Name and Last Name are required fields. Row: " . json_encode($row));
            }

            $firstName = trim($row['first_name']);
            $lastName = trim($row['last_name']);
            $name = "$firstName" . "_" . " $lastName";

            // Handle email and password
            $email = $row['email'] ?? $firstName . '@placeholder.com';
            $password = !empty($row['password'])
                ? Hash::make($row['password']) : Hash::make("$firstName@PSU");

            // Check if the user exists (by email) and update or create
            $user = User::updateOrCreate(
                ['email' => $email], // Unique field for checking existing users
                [
                    'name' => $name,
                    'email' => $email,
                    'password' => $password,
                ]
            );

            // Update or create the related profile
            $user->profile()->updateOrCreate(
                [], // No unique constraints in this example
                [
                    'first_name' => $firstName,
                    'middle_name' => $row['middle_name'] ?? null,
                    'last_name' => $lastName,
                    'employment_status' => $row['employment_status'] ?? null,
                    'complete_address' => $row['complete_address'] ?? null,
                    'city' => $row['city'] ?? null,
                    'province' => $row['province'] ?? null,
                    'postal_code' => $row['post_code'] ?? null,
                    'country' => $row['country'] ?? null,
                    'graduate_year' => $row['graduate_year'],
                    'program_id' => $program?->id,
                    'campus_id' => $campus?->id,
                ]
            );

            return $user;
        });
    }
}
