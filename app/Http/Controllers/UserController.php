<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeUserEmailRequest;
use App\Http\Requests\ChangeUserPasswordRequest;
use App\Http\Requests\UserEditRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Str;
use XBase\TableReader;

class UserController extends Controller
{

    public function index()
    {

    }

    public function show($id)
    {

    }
    public function edit(Request $request)
    {
        $user = auth()->user();
        if (!$user){
            return redirect()->route('welcome');
        }
        $user->pdv_checkbox = $user->is_pdv ? 'checked' : '';
        $tab = $request->get('tab')?? '1';
        if (!in_array($tab, ['1','2','3'])){
            $tab = '1';
        }
        return view('profile', compact('user', 'tab'));
    }

    public function update(UserEditRequest $request)
    {
        dd($request->all());
    }

    public function changeEmail(ChangeUserEmailRequest $request)
    {
        $user = auth()->user();
        $user->email = $request->email;
        $user->email_verified_at = null;
        $result = $user->save();
        if ($result){
            Log::channel('edit_users')->debug("Change email {$user->name} to {$user->mail}");
            auth()->logout();
            return redirect()->route('welcome');
        }

        return redirect()->back()->with(['error' => 'Помилка зміни email']);
    }

    public function changePassword(ChangeUserPasswordRequest $request)
    {
        $user = auth()->user();
        $user->password = bcrypt($request->new_password);
        $result = $user->save();
        if ($result){
            Log::channel('edit_users')->debug("Change password {$user->name}");
            auth()->logout();
            return redirect()->route('welcome');
        }
        return redirect()->back()->with(['error' => 'Помилка зміни пароля']);
    }

    public function createUsers()
    {
        $namefile = config('partner.download_users_file');

        if (!file_exists($namefile)) {
            Log::channel('download_users')->debug($namefile . ' not exist');
            return response()->json(['error' => $namefile . ' not exist'], 404);
        }

        try{
            $table = new TableReader(
                $namefile,
                [
                    'encoding' => 'cp866'
                ]
            );

            //throw new \Exception('Testing exception!!!');
            $countUsers = 0;
            $countNoCod = 0;
            while ($record = $table->nextRecord()) {
                if (User::where('kod_fxp', $record->get('kod'))->first()){
                    continue;
                }

                if (!is_numeric($record->get('kod')) || $record->get('kod') == 0){
                    $countNoCod++;
                    continue;
                }
                $user = new User();

                $user->name = str_replace(['i','I'], ['і', 'І'], $record->get('nazva'));

                $user->user_type = 1 ;  // перевізник
                $user->is_active = true;
                $user->password_fxp = Str::random(20);
                $user->kod_fxp = $record->get('kod');
                $user->full_name = str_replace(['i','I'], ['і', 'І'], $record->get('nazva'));
                $user->short_name = str_replace(['i','I'], ['і', 'І'], $record->get('nazva_k'));
                $user->percent_retention_tariff = $record->get('proc');
                $user->percent_retention__insurance = $record->get('procself');
                $user->percent_retention__insurer = $record->get('procgarn');
                $user->percent_retention__baggage = $record->get('proc_bag');
                $user->attribute = $record->get('prz');
                $user->collection = $record->get('dog') == 1 ? true : false;
                $user->insurer = $record->get('name_strax');
                $user->surname = $record->get('fio');
                $user->identifier = $record->get('inkod');
                $user->address = $record->get('adress');
                $user->is_pdv = $record->get('pdv') == 1 ? true : false;
                $user->certificate = $record->get('n_svid');
                $user->certificate_tax = $record->get('ind_pod_n');
                $user->num_contract = $record->get('nomer_d');
                $user->date_contract = $record->get('data_d');
                $user->telephone = $record->get('telefon');
                $user->edrpou = $record->get('inkod');

                $user->save();
                $countUsers++;

            }

            Log::channel('download_users')->debug("Create {$countUsers} users");
            return response()->json(['success' => "Create {$countUsers} users"], 200);

        }catch (\Exception $e){
            Log::channel('download_users')->debug($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
}
