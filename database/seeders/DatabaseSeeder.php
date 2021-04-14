<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\University;
use App\Models\Faculty;
use App\Models\Department;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::firstOrCreate(['name' => 'create role']);
        Permission::firstOrCreate(['name' => 'manage role']);
        Permission::firstOrCreate(['name' => 'edit role']);
        Permission::firstOrCreate(['name' => 'delete role']);

        Permission::firstOrCreate(['name' => 'create permission']);
        Permission::firstOrCreate(['name' => 'manage permission']);
        Permission::firstOrCreate(['name' => 'edit permission']);
        Permission::firstOrCreate(['name' => 'delete permission']);

        Permission::firstOrCreate(['name' => 'create university']);
        Permission::firstOrCreate(['name' => 'edit university']);
        Permission::firstOrCreate(['name' => 'delete university']);

        Permission::firstOrCreate(['name' => 'create faculty']);
        Permission::firstOrCreate(['name' => 'edit faculty']);
        Permission::firstOrCreate(['name' => 'delete faculty']);

        Permission::firstOrCreate(['name' => 'create department']);
        Permission::firstOrCreate(['name' => 'edit department']);
        Permission::firstOrCreate(['name' => 'delete department']);

        Permission::firstOrCreate(['name' => 'create course']);
        Permission::firstOrCreate(['name' => 'edit course']);
        Permission::firstOrCreate(['name' => 'delete course']);

        Permission::firstOrCreate(['name' => 'create post']);
        Permission::firstOrCreate(['name' => 'edit post']);
        Permission::firstOrCreate(['name' => 'delete post']);

        Permission::firstOrCreate(['name' => 'add comment']);
        Permission::firstOrCreate(['name' => 'enroll']);
        Permission::firstOrCreate(['name' => 'upload file']);

        $admin_role = Role::firstOrCreate(['name' => 'admin'])->givePermissionTo([
            'create role', 'manage role', 'edit role', 'delete role',
            'create permission', 'manage permission', 'edit permission', 'delete permission', 
            'create university', 'edit university', 'delete university', 
            'create faculty', 'edit faculty', 'delete faculty', 
            'create department', 'edit department', 'delete department', 
            'create course', 'edit course', 'delete course', 
            'create post', 'edit post', 'delete post', 
            'add comment', 'upload file']);

        $moderator_role = Role::firstOrCreate(['name' => 'moderator'])->givePermissionTo([
            'create course', 'edit course', 'delete course',
            'create post', 'edit post', 'delete post', 
            'add comment', 'upload file']);

        $student_role = Role::firstOrCreate(['name' => 'student'])->givePermissionTo([
            'create course', 'edit course', 'delete course']);

        $tutor_role = Role::firstOrCreate(['name' => 'tutor'])->givePermissionTo(['upload file']);

        $university1 = University::firstOrCreate(['name' => 'university1']);
        $faculty1 = Faculty::firstOrCreate(['name' => 'faculty1', 'university_id' => 1]);
        $department1 = Department::firstOrCreate(['name' => 'department1', 'faculty_id' => 1]);
        $admin1 = User::firstOrCreate([
            'name' => 'saeed', 'username' => 'admin1', 
            'university_id' => 1, 'faculty_id' => 1, 'department_id' => 1, 
            'email' => 'saeed@admin.com', 'password' => 'admin12345']);
        $admin2 = User::firstOrCreate([
            'name' => 'malik', 'username' => 'admin2', 
            'university_id' => 1, 'faculty_id' => 1, 'department_id' => 1, 
            'email' => 'malik@admin.com', 'password' => 'admin12345']);
        $admin3 = User::firstOrCreate([
            'name' => 'osamah', 'username' => 'admin3', 
            'university_id' => 1, 'faculty_id' => 1, 'department_id' => 1, 
            'email' => 'osamah@admin.com', 'password' => 'admin12345']);
        $admin4 = User::firstOrCreate([
            'name' => 'makkawi', 'username' => 'admin4', 
            'university_id' => 1, 'faculty_id' => 1, 'department_id' => 1, 
            'email' => 'makkawi@admin.com', 'password' => 'admin12345']);
        $admin5 = User::firstOrCreate([
            'name' => 'kashgri', 'username' => 'admin5', 
            'university_id' => 1, 'faculty_id' => 1, 'department_id' => 1, 
            'email' => 'kashgri@admin.com', 'password' => 'admin12345']);

        $admin1->syncRoles([$admin_role]);
        $admin2->syncRoles([$admin_role]);
        $admin3->syncRoles([$admin_role]);
        $admin4->syncRoles([$admin_role]);
        $admin5->syncRoles([$admin_role]);
        
    }
}
