<?php

namespace App\Http\Controllers;

use App\Models\DonationModel;
use App\Models\GalleryModel;
use App\Models\InNeedsModel;
use App\Models\User;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;




class UserController extends Controller
{
    public function landingpageuser(){
        $auth = Auth::user();
        return view('landingpageuser',compact('auth'));
    }
public function donationuser(){
    $auth = Auth::user();
    $donations = Donation::where('user_id', $auth->id)->get(); // Get donations for the current user
    return view('donationuser', compact('auth', 'donations'));
}
    public function galleryuser(){
        $auth = Auth::user();
        $gallery = GalleryModel::all();
        return view('galleryuser',compact('auth','gallery'));
    }

    public function aboutususer(){
        $auth = Auth::user();
        return view('aboutususer',compact('auth'));
    }


    public function donatenow(Request $request){
        $user = Auth::user();
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'inneed_id' => 'required|exists:inneeds,id',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'status' => 'required|string',
            'item_status' => 'required|string|in:new,used,fair',
            'dropofflocation' => 'required|string|in:Dagupan,Urdaneta',
        ]);

        $existingdonation = DonationModel::where('user_id', $user->id)
            ->where('inneed_id', $request->inneed_id)
            ->first();
        if ($existingdonation) {
            return redirect()->back()->with('error', 'You have already donated to this.');
        }

        $imagePath = null;
        if ($request->has('image')) {
            $imagePath = $request->file('image')->store('donations', 'public');
        }

        $donate = DonationModel::create([
            'user_id' => auth::id(),
            'inneed_id' => $validatedData['inneed_id'],
            'image' => $imagePath,
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'status' => $validatedData['status'],
            'item_status' => $validatedData['item_status'],
            'dropofflocation' => $validatedData['dropofflocation'],
        ]);
        return redirect()->back()->with('success', 'Donation Request Submitted Successfully!');
        }

    public function updatedonation(Request $request, $id){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'status' => 'required|string',
            'item_status' => 'required|string|in:new,used,fair',
            'dropofflocation' => 'required|string|in:Dagupan,Urdaneta',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif',
        ]);

        $donation = DonationModel::findOrFail($request->donation_id);
        $donation->name = $validatedData['name'];
        $donation->description = $validatedData['description'];
        $donation->status = $validatedData['status'];
        $donation->item_status = $validatedData['item_status'];
        $donation->dropofflocation = $validatedData['dropofflocation'];
        if ($request->hasFile('image')) {
            $donation->image = $request->file('image')->store('donations', 'public');
        }
        $donation->save();

        return redirect()->back()->with('success', 'Donation updated successfully!');
    }

    public function destroyuserdonation($id){
        $destroyuserdonation = DonationModel::findOrFail($id);
        $destroyuserdonation -> delete();
        return redirect()->back()->with('success','Donation Deleted Successfully');
    }

    public function forgotpassword()
    {
        return view('forgotpassword');
    }

    // Handle the forgot password form submission
    public function forgotpasswordpost(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Email does not match our records',
        ]);

        $email = $request->input('email');
        $existingtoken = DB::table('password_reset_tokens')->where('email',$email)->first();
        if($existingtoken){
            return redirect()->back()->with('error','A Password Link Has Been Sent To This Email Already');
        }
        $token = Str::random(60);

        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => now(),
        ]);

        $resetLink = url("reset-password/{$token}?email={$email}");
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'uzukealucard@gmail.com';
            $mail->Password = 'aztttufargfnrhop';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('no-reply@yourdomain.com', 'CycleofGiving');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Link';
            $mail->Body = "
            <p>Hello,</p>
            <p>We received a request to reset your password for your account. If you made this request, please click on the link below to reset your password:</p>
            <p><a href='{$resetLink}'>Click here to reset your password</a></p>
            <p>If you did not request a password reset, please ignore this email. Your password will remain unchanged.</p>
            <p>If you have any questions or need further assistance, feel free to contact our support team.</p>
            <p>Best regards,<br>Cycle of Giving</p>
            ";


            $mail->send();
            return redirect()->back()->with('success','Please Check Your Email For Password Recovery');
        } catch (Exception $e) {
            return redirect()->back()->with('error','Please Try Again');
        }
    }

    public function showresetform($token)
    {
        return view('showresetform', ['token' => $token]);
    }

    // Handle the reset password form submission
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed',
            'token' => 'required',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');
        $token = $request->input('token');

        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('token', $token)
            ->first();

        if (!$resetRecord) {
            return back()->withErrors(['token' => 'The Email Address You Entered Does Not Belong To Any User.']);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No User Found With That Email Address.']);
        }

        $user->password = Hash::make($password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $email)->delete();

        return redirect()->route('login')->with('success', 'Your Password Has Been Successfully Reset!');
    }


}
