<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 18.07.2022
 * Time: 8:54
 */

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use XBase\TableReader;
use App\Models\User;
use Str;
class UserRepository
{
    public  $countUsers,$countNoCod;

    public function __construct()
    {
        $this->countUsers = 0;
        $this->countNoCod = 0;
    }

    public function moveToArchive($nameUserFile, $nameUserArchive, LoggingRepository $loggingRepository)
    {
        $nameUserArchive = 'users/' . date("Y_m_d_H_i_s_") . $nameUserArchive;

        try {
            //throw new \Exception('Testing exception!!!');
            Storage::move($nameUserFile, $nameUserArchive);
            return false;
        } catch (\Exception $e) {
            $loggingRepository->createUsersLoggingMessage($e->getMessage());
            return $e->getMessage();
        }
    }

    public function setUserValueCheckBox($user)
    {
        $user->pdv_checkbox = $user->is_pdv ? 'checked' : '';
    }

    public function setNumberTab(Request $request)
    {
        $tab = $request->get('tab')?? '1';
        if (!in_array($tab, ['1','2','3'])){
            $tab = '1';
        }
        return $tab;
    }

    public function updateUser($user, Request $request)
    {
        $user->full_name = $request->get('full_name');
        $user->short_name = $request->get('short_name');
        $user->insurer = $request->get('insurer');
        $user->surname = $request->get('surname');
        $user->identifier = $request->get('identifier');
        $user->address = $request->get('address');
        $user->is_pdv = $request->get('is_pdv') === 'checked' ? 1 : 0;
        $user->certificate = $request->get('certificate');
        $user->certificate_tax = $request->get('certificate_tax');
        $user->telephone = $request->get('telephone');
        $user->edrpou = $request->get('edrpou');

        $result = $user->save();

        return $result;
    }

    public function changeUserEmail($user, $email)
    {
        $user->email = $email;
        $user->email_verified_at = null;
        $result = $user->save();
        return $result;
    }

    public  function changeUserPassword($user, $newPassword)
    {
        $user->password = bcrypt($newPassword);
        $result = $user->save();
        return $result;
    }

    public function createUsers($namefile)
    {
        $table = new TableReader(
            storage_path('app/' . $namefile),
            [
                'encoding' => 'cp866'
            ]
        );

        //throw new \Exception('Testing exception!!!');

        while ($record = $table->nextRecord()) {
            $oldUser = User::where('kod_fxp', $record->get('kod'))->first();
            if ($oldUser) {
                //  у існуючого перевізника може змінитися список дочірніх
                $children = [];
                for ($x = 1; $x <= 10; $x++) {
                    $name_field = "child{$x}";
                    $value_child = $record->get($name_field);
                    if ($value_child > 0) {
                        $children[] = $value_child;
                    }
                }
                if (count($children) > 0) {
                    $oldUser->children_id = $children;
                } else {
                    $oldUser->children_id = null;
                }
                $oldUser->save();
                continue;
            }

            if (!is_numeric($record->get('kod')) || $record->get('kod') == 0) {
                $this->countNoCod++;
                continue;
            }
            $user = new User();

            $user->name = str_replace(['i', 'I'], ['і', 'І'], $record->get('nazva'));

            $user->user_type = 1;  // перевізник
            $user->is_active = true;
            $user->password_fxp = Str::random(20);
            $user->kod_fxp = $record->get('kod');
            $user->full_name = str_replace(['i', 'I'], ['і', 'І'], $record->get('nazva'));
            $user->short_name = str_replace(['i', 'I'], ['і', 'І'], $record->get('nazva_k'));
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
            $children = [];
            for ($x = 1; $x <= 10; $x++) {
                $name_field = "child{$x}";
                $value_child = $record->get($name_field);
                if ($value_child > 0) {
                    $children[] = $value_child;
                }
            }
            if (count($children) > 0) {
                $user->children_id = $children;
            }

            $user->save();
            $this->countUsers++;
        }

    }

}