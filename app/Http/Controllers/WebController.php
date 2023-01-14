<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

use App\Models\Campus;
use App\Models\Course;
use App\Models\College;
use App\Models\Office;
use App\Models\Client;
use App\Models\Setting;
use App\Models\Question;
use App\Models\Answer;
use App\Models\SurveyAnswer;
use App\Models\Comment;
use App\Classes\AppHelper;
use App\Http\Requests\SendCodeRequest;
use App\Http\Requests\VerificationRequest;
use App\Http\Requests\ClientsRequest;
use Illuminate\Support\Facades\Session;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Log;

use Antoineaugusti\LaravelSentimentAnalysis\SentimentAnalysis;

class WebController extends Controller
{
    public function index(Request $request)
    {
        $request->session()->forget('campus_id');
        return view('front.index');
    }

    public function load()
    {
        $data = Campus::with('settings')
                    ->whereHas('questions')
                    ->where('id','<>','1')
                    ->orderBy('id', 'DESC')
                    ->get();

        $html = view('front.data')->with('data', $data)->render();

        return response()->json(['html' => $html]);
    }

    public function save(ClientsRequest $request) 
    {
        $id = request()->session()->has('id');
        $validated = $request->validated();

        $input = $request->safe()->only(['office_id']);

        try {
            if($id) {
                
                $campus_id = request()->session()->get('campus_id');
                $answer = SurveyAnswer::where('office_id', $input['office_id'])
                                ->where('client_id', $id)
                                ->get();

                if(count($answer) > 0){
                    return response()->json(['error' => 'It seems like you already submitted feedback for this office.']);
                }
                
                $client = ['id' => request()->session()->get('id')];
                Client::where('id', $client['id'])->update($validated);

            } else {
                $dataToMerge = [
                    'campus_id' => request()->session()->get('campus_id')
                ];

                $data = array_merge($validated, $dataToMerge);

                $client = Client::create($data);

                request()->session()->put('id', $client->id);
            }

            return response()->json([
                'success' => true,
            ]);

        } catch(QueryException $e) {
            return response()->json(['error' => $e->errorInfo[2]]);
        }
    }

    public function survey()
    {
        $campus_id = request()->session()->get('campus_id');
        $id = request()->session()->get('id');

        if(!request()->session()->has('campus_id')){
            return redirect('/unauthorized');
        }

        $data = [];
        $data['client'] = Client::with(['courses','colleges','offices'])->where('id', $id)->first();
        $data['questions'] = Question::where('campus_id', $campus_id)
                            ->whereNull('deleted_at')
                            ->orderBy('question_number','ASC')
                            ->get();
        $data['answers'] = Answer::where('campus_id', $campus_id)
                            ->whereNull('deleted_at')
                            ->orderBy('points','DESC')
                            ->get();
        return view('front.survey-window', compact('data'));
    }

    public function save_answers(Request $request)
    {
        if(!request()->session()->has('campus_id')){
            return response()->json(['error' => true]);
        }

        $client_id = request()->session()->get('id');
        $question_id = $request->input('question_id');
        $answer = $request->input('answer');
        $campus_id = request()->session()->get('campus_id');

        $client = Client::find($client_id);

        $questions = Question::where('campus_id', $campus_id)->whereNull('deleted_at')->get();
        $answers = SurveyAnswer::where('client_id', $client_id)
                            ->where('office_id', $client->office_id)->get();

        if(count($answers) == count($questions)) {
            return response()->json(['error' => 'completed']);
        }

        SurveyAnswer::create([
            'answer' => $answer,
            'question_id' => $question_id,
            'client_id' => $client_id,
            'campus_id' => $campus_id,
            'office_id' => $client->office_id,
            'college_id' => $client->college_id
        ]);

        return response()->json(['success' => true]);
    }

    public function save_comment(Request $request)
    {
        $client_id = request()->session()->get('id');
        $comment = $request->input('comment');
        $campus_id = request()->session()->get('campus_id');
        
        $client = Client::find($client_id);

        $check = Comment::where('client_id', $client)->where('office_id', $client->office_id)->get();
        
        if(count($check) > 0){
            return response()->json(['error' => true]);
        }

        $sentiment = new SentimentAnalysis(storage_path('custom_dictionary/'));
        $scores = $sentiment->scores($comment);
        
        //return response()->json(['success' => $scores['neutral']]);

        Comment::create([
            'comment' => $comment,
            'neutral' => $scores['neutral'],
            'positive' => $scores['positive'],
            'negative' => $scores['negative'],
            'client_id' => $client_id,
            'campus_id' => $campus_id,
            'office_id' => $client->office_id,
            'college_id' => $client->college_id
        ]);

        return response()->json(['success' => true]);
    }

    public function thank_you()
    {
        self::forgetSession();
        return view('front.thank-you');
    }

    public function answer()
    {
        $data = [];
        $data['campus_id'] = request()->session()->get('campus_id');
        $data['email_address'] = request()->session()->get('email_address');
        $data['hasEmail'] = request()->session()->get('email_address');

        $data['colleges'] = College::whereHas('offices')->whereHas('courses')
                                ->where('campus_id', $data['campus_id'])
                                ->whereNull('deleted_at')
                                ->get();

        if(empty($data['campus_id'])) {
            return redirect('/unauthorized');    
        }

        $settings = Setting::where('campus_id', $data['campus_id'])->first();

        if(!empty($settings) && $settings->require_email_verification && empty($data['email_address'])){
            
            self::forgetSession();
            return redirect('/unauthorized');

        }

        return view('front.answer-survey', compact('data'));
    }

    public function getFormData(Request $request) 
    {
        $college_id = $request->input('college_id');

        $data['offices'] = Office::where('college_id', $college_id)->whereNull('deleted_at')->get();
        $data['courses'] = Course::where('college_id', $college_id)->whereNull('deleted_at')->get();

        $html = view('front.partials._form-data', compact('data'))->render();

        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }

    public function verification()
    {
        $campus_id = request()->session()->get('campus_id');
        $campus = Campus::where('id', $campus_id)->first();
        $hasEmail = request()->session()->has('email_address');
        //dd(request()->session());

        if(isset($campus_id)) {
            return view('front.verification')->with(['data' => $campus, 'hasEmail' => $hasEmail]);
        } else {
            return redirect('/unauthorized');
        }
    }

    public function verify($id, Request $request)
    {
        self::forgetSession();

        if($id !== 1) {
            $campus = Campus::whereHas('questions')
                    ->where('id', $id)
                    ->first();
            if(empty($campus)){
                return redirect('/unauthorized');
            }

            $request->session()->put('campus_id', $campus->id);

            if($campus->settings->require_email_verification) {
                // if require email verification is true
                return redirect('/verification');
            } else {
                return redirect('/answer-survey');
            }

        } else {
            return redirect('/unauthorized');
        }
    }

    
    public function send_code(SendCodeRequest $request)
    {
        $data = $request->safe()->only(['email_address']);
        
        $code = self::code();
      
        $html = view('front.email-template')->with('code', $code)->render();

        $sendEmail = self::sendMail($data['email_address'], $html);

        if($sendEmail) {
            
            $email_address = $data['email_address'];
            $campus_id = request()->session()->get('campus_id');

            request()->session()->put('email_address', $email_address);

            $client = Client::where('email_address', $email_address)
                            ->where('campus_id', $campus_id)
                            ->first();
            if(empty($client)) {
                $client = Client::create([
                    'email_address' => $email_address,
                    'verification_code' => $code,
                    'campus_id' => $campus_id
                ]);
            } else {
                $client->update([
                    'verification_code' => $code,
                    'is_verified' => false
                ]);
            }

            return response()->json(['success' => true]);

        } else {
            return response()->json(['error' => $sendEmail]);
        }
    }

    public function verify_email(VerificationRequest $request)
    {
        $data = $request->validated();
        $email_address = request()->session()->get('email_address');
        $campus_id = request()->session()->get('campus_id');

        if($email_address !== $data['email_address']) {
            return response()->json(['error' => "You have sent an invalid request!"]);
        }

        $client = Client::where('email_address', $email_address)
                        ->where('campus_id', $campus_id)
                        ->first();

        if(empty($client)) {
            return response()->json(['error' => "Unauthorized request!"]);
        }

        if($data['verification_code'] !== $client->verification_code) {
            return response()->json(['error' => "Verification code is not recognized."]);
        }

        $client->update([
            'is_verified' => true
        ]);

        request()->session()->put('id', $client->id);

        return response()->json(['success' => true]);
    }

    
    public static function forgetSession()
    {
        request()->session()->forget('campus_id');
        request()->session()->forget('email_address');
        request()->session()->forget('id');
    }

    public static function code()
    {
        return rand(100000,999999);
    }

    public static function sendMail($email, $body)
    {
        try {

            $mail = new PHPMailer(true);
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host       = env('MAIL_HOST');
            $mail->SMTPAuth   = true;
            $mail->Username   = env('MAIL_USERNAME');
            $mail->Password   = env('MAIL_PASSWORD');
            //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = env('MAIL_PORT');

            $mail->setFrom(env('MAIL_FROM_ADDRESS', 'support@sentiment-analysis.com'));
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Email Verification Code';
            $mail->Body    = $body;
            $mail->Send();
            Log::info("Email has been sent!");
            return true;
        } catch (Exception $e) {
            Log::info("Message could not be sent. Mailer Error:{$mail->ErrorInfo}");
            return $mail->ErrorInfo;
        }
    }
}
