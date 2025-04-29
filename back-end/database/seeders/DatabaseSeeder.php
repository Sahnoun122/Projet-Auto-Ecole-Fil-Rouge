<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
            /**
             * Run the database seeds.
             *
             * @return void
             */
            public function run(): void
            {
                // Créer un utilisateur admin
                User::create([
                    'nom' => 'khadija',
                    'prenom' => 'sahnoun',
                    'email' => 'khadijasahnoun46@gmail.com',
                    'adresse' => 'Admin Address',
                    'telephone' => '0612345678',
                    'photo_profile' => 'default.jpg',
                    'photo_identite' => 'identite.jpg',
                    'type_permis' => 'A',
                    'certifications' => 'Certificat Admin',
                    'Qualifications' => 'Qualification Admin',
                    'role' => 'admin',
                    'password' => Hash::make('adminpassword'), 
                ]);
        
                User::create([
                    'nom' => 'Moniteur',
                    'prenom' => 'User',
                    'email' => 'khadijasahnoun70@gmail.com',
                    'adresse' => 'Moniteur Address',
                    'telephone' => '0698765432',
                    'photo_profile' => 'default.jpg',
                    'photo_identite' => 'identite.jpg',
                    'type_permis' => 'B',
                    'certifications' => 'Certificat Moniteur',
                    'Qualifications' => 'Qualification Moniteur',
                    'role' => 'moniteur',
                    'password' => Hash::make('moniteurpassword'),
                ]);
        

                User::create([
                    'nom' => 'Candidat',
                    'prenom' => 'User',
                    'email' => 'khadijasahnoun610@gmail.com',
                    'adresse' => 'Candidat Address',
                    'telephone' => '0676543210',
                    'photo_profile' => 'default.jpg',
                    'photo_identite' => 'identite.jpg',
                    'type_permis' => 'C',
                    'certifications' => 'Certificat Candidat',
                    'Qualifications' => 'Qualification Candidat',
                    'role' => 'candidat',
                    'password' => Hash::make('candidatpassword'),
                ]);
            }
        }
        
