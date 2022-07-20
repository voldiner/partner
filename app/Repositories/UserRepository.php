<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 18.07.2022
 * Time: 8:54
 */

namespace App\Repositories;


use Illuminate\Support\Facades\Storage;

class UserRepository
{

    public function moveToArchive($nameUserFile, $nameUserArchive, $loggingRepository)
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




}