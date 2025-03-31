<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $user = new Client();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'status' => 'success',
            'data' => $user,
        ]);
    }

    public function index()
    {
        return response()->json(Client::paginate(10));
    }

    public function show($id)
    {
        $user = Client::find($id);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $user]);
    }

    public function update(Request $request, $id)
    {
        $user = Client::find($id);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return response()->json(['status' => 'success', 'data' => $user]);
    }

    public function destroy($id)
    {
        Client::findOrFail($id)->delete();

        return response()->json(['status' => 'success', 'message' => 'User deleted successfully'], 200);
    }
}
