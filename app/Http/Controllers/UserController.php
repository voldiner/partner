<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeUserEmailRequest;
use App\Http\Requests\ChangeUserPasswordRequest;
use App\Http\Requests\UserEditRequest;
use App\Repositories\LoggingRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;



class UserController extends Controller
{

    public function edit(Request $request, UserRepository $userRepository)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('welcome');
        }

        $userRepository->setUserValueCheckBox($user);

        $tab = $userRepository->setNumberTab($request);

        return view('profile', compact('user', 'tab'));
    }

    public function update(
        UserEditRequest $request,
        UserRepository $userRepository,
        LoggingRepository $loggingRepository
    )
    {
        $user = auth()->user();

        $result = $userRepository->updateUser($user, $request);

        if ($result) {
            $loggingRepository->EditUserLoggingMessage("Change fields {$user->name} success");
            return back()->with(['success' => 'Реквізити успішно оновлено']);
        }

        return redirect()->back()->with(['error' => 'Помилка зміни реквізитів']);
    }

    public function changeEmail(
        ChangeUserEmailRequest $request,
        UserRepository $userRepository,
        LoggingRepository $loggingRepository
    )
    {
        $user = auth()->user();

        $result = $userRepository->changeUserEmail($user, $request->email);
        if ($result) {
            $loggingRepository->EditUserLoggingMessage("Change email {$user->name} to {$user->mail}");
            auth()->logout();
            return redirect()->route('welcome');
        }

        return redirect()->back()->with(['error' => 'Помилка зміни email']);
    }

    public function changePassword(
        ChangeUserPasswordRequest $request,
        UserRepository $userRepository,
        LoggingRepository $loggingRepository
    )
    {
        $user = auth()->user();

        $result = $userRepository->changeUserPassword($user, $request->new_password);

        if ($result) {
            $loggingRepository->EditUserLoggingMessage("Change password {$user->name}");
            auth()->logout();
            return redirect()->route('welcome');
        }
        return redirect()->back()->with(['error' => 'Помилка зміни пароля']);
    }

    public function createUsers(UserRepository $userRepository, LoggingRepository $loggingRepository)
    {
        $usersFile = config('partner.download_users_file', 'USERS.DBF');
        $namefile = 'downloads/' . $usersFile;

        if (Storage::missing($namefile)) {
            $loggingRepository->createUsersLoggingMessage($namefile . ' not exist');
            return response()->json(['error' => $namefile . ' not exist'], 404);
        }

        try {

            $userRepository->createUsers($namefile);

            $loggingRepository->createUsersLoggingMessage("Create {$userRepository->countUsers} users. Wrong kod {$userRepository->countNoCod } users.");

            $archiveMessage = $userRepository->moveToArchive(
                $namefile,
                $usersFile,
                $loggingRepository
            );
            $returnMessage = "Create {$userRepository->countUsers} users. Wrong kod {$userRepository->countNoCod } users. " . ($archiveMessage ? $archiveMessage : '');
            return response()->json(['success' => $returnMessage], 200);

        } catch (\Exception $e) {
            $loggingRepository->createUsersLoggingMessage($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
}
