<?php

namespace App\Http\Controllers\MainSiteController;

use App\Mail\SendMail;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('mainsite.pages.contact');
    }

    public function createmessage(Request $request)
    {
        if ($request->isMethod('post')) {
            try {
                // Validate input
                $validatedData = $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|max:255',
                    'subject' => 'required|string|max:255',
                    'message' => 'required|string'
                ]);

                // Define banned words
                $bannedWords = [
                    'fuck',
                    'die',
                    'pussy',
                    'shit',
                    'bitch',
                    'whore',
                    'asshole',
                    'tanga',
                    'gago',
                    'nigger',
                    'nigga',
                    'penis',
                    'vagina',
                    'stfu',
                    'kantutan',
                    'titi'
                ]; // Add more words as necessary

                // Check for banned words
                foreach ($bannedWords as $word) {
                    if (stripos($validatedData['message'], $word) !== false) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Please avoid using inappropriate words in your message.',
                        ], 400);
                    }
                }

                // Save the message
                $message = Message::create($validatedData);

                // Send an email
                $emailAddress = 'senyahan192@gmail.com';
                Mail::to($emailAddress)->send(new SendMail($validatedData));

                return response()->json([
                    'success' => true,
                    'message' => 'Message sent successfully.',
                    'data' => $message
                ], 200);
            } catch (\Illuminate\Validation\ValidationException $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error.',
                    'errors' => $e->errors(),
                ], 422);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'An unexpected error occurred. Please try again later.',
                    'error' => $e->getMessage(),
                ], 500);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid request method.',
        ], 405);
    }
}
