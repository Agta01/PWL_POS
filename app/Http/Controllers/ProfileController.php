<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => '',
            'list' => ['Home', 'Profile']
        ];
        $activeMenu = 'profile';
        return view('profile', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }

    public function upload_foto(Request $request)
    {
        // Validate file extension
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        // Set the folder path for uploaded images
        $folderPath = 'uploads/profile_pictures/' . auth()->user()->username . '/';
        
        // Delete old profile picture if it exists
        $extensions = ['jpg', 'jpeg', 'png'];
        foreach ($extensions as $ext) {
            $oldFileName = $folderPath . auth()->user()->username . '_profile.' . $ext;
            if (Storage::disk('public')->exists($oldFileName)) {
                Storage::disk('public')->delete($oldFileName);
                break; // Exit the loop once the old file is found and deleted
            }
        }

        // Get the uploaded file
        $file = $request->file('foto');
        // Create a unique filename
        $filename = auth()->user()->username . '_profile.' . $file->getClientOriginalExtension();
        // Store the file in the specified path
        $file->storeAs($folderPath, $filename, 'public');

        return back()->with('success', 'Foto berhasil diupload.');
    }

    public function updateProfile(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:m_user,username,' . auth()->user()->user_id . ',user_id', // Add user_id to unique constraint
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update user data using user_id
        $user = UserModel::find(auth()->user()->user_id); // Fetch user by user_id
        $user->nama = $request->input('nama');
        $user->username = $request->input('username');

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return back()->with('success', 'Data diri berhasil diperbarui.');
    }
}
