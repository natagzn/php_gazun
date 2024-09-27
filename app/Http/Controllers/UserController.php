<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());

       // Валідація даних
    $request->validate([
        'username' => 'required|string|max:50',
        'email' => 'required|string|email|max:100|unique:users',
        'password' => 'required|string|min:6',
    ]);

    // Створення нового користувача
    User::create([
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password), // Хешування пароля
    ]);

    // Перенаправлення на список користувачів
    return redirect()->route('users.index')->with('success', 'User created successfully.');
    //return response()->json(['message' => 'User created successfully']);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:50',
            'email' => 'required|email|max:100|unique:users,email,'.$id.',user_id',
            'password' => 'nullable|string|min:8',
        ]);

        $user = User::findOrFail($id);
        $user->username = $validated['username'];
        $user->email = $validated['email'];
        
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');

    }
}
