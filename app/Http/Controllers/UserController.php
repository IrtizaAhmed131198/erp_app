<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::where('role', 2)->get();
        return view('users.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = User::find($id);
        return view('users.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'email' => 'required|email|max:250|unique:users,email,' . $request->id,
            'password' => 'nullable|min:6',
            'department' => 'required',
            'phone' => 'required',
            'user_img' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Find the user by ID
        $user = User::findOrFail($request->id);

        // Handle file upload if a new image is provided
        if ($request->hasFile('user_img')) {
            // Delete the old image if it exists
            if ($user->user_img && file_exists(public_path('images/' . $user->user_img))) {
                unlink(public_path('images/' . $user->user_img));
            }

            $image = $request->file('user_img');
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imagename);
            $user->user_img = $imagename;
        }

        // Update the user attributes
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->department = $request->input('department');
        $user->phone = $request->input('phone');
        $user->status_column = $request->filled('status_column') ? 1 : 0;
        $user->stock_finished_column = $request->filled('stock_finished_column') ? 1 : 0;
        $user->part_number_column = $request->filled('part_number_column') ? 1 : 0;
        $user->calendar_column = $request->filled('calendar_column') ? 1 : 0;
        $user->create_order = $request->filled('create_order') ? 1 : 0;
        $user->user_maintenance = $request->filled('user_maintenance') ? 1 : 0;
        $user->visual_input_screen = $request->filled('visual_input_screen') ? 1 : 0;
        $user->View_1 = $request->filled('View_1') ? 1 : 0;
        $user->View_2 = $request->filled('View_2') ? 1 : 0;
        $user->View_3 = $request->filled('View_3') ? 1 : 0;

        // Save the updated user
        $user->save();

        return redirect()->back()->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = User::find($id);
        $data->delete();

        return redirect()->back();
    }
}
