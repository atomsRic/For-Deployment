<?php

namespace App\Http\Controllers;
 
use App\Models\User;
use Illuminate\Http\Request;
 
class StudentLookupController extends Controller
{
    /**
     * Lookup a student by their numeric ID.
     * Returns JSON: { found: bool, id: int, name: string }
     * Called via GET /api/students/{id}
     */
    public function lookup($id)
    {
        $user = User::where('id', $id)
                    ->where('role', 'student')
                    ->select('id', 'name', 'email')
                    ->first();
 
        if ($user) {
            return response()->json([
                'found' => true,
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
            ]);
        }
 
        return response()->json(['found' => false]);
    }
}