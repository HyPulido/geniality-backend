<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\BaseApp;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use BaseApp;

    public function create(Request $request)
    {
        $error_code = 'URCE200';
        $data = null;

        try {
            $email = $request->email;
            $userTable = new User;

            $user = $userTable->exists($email);

            if (!isset($user)) {
                $createUser = $userTable->createUser($email);

                if ($createUser) {
                    $data['id'] = $createUser->id;
                } else {
                    $error_code = 'URCE400';
                }
            } else {
                $data['id'] = $user->id;
            }
        } catch (Exception $e) {
            $error_code = "URCE500";
            $data[] = $this->getException($e);
        }

        return $this->setCustomizeResponse(array('error_code' => $error_code, 'data' => $data, 'function' => __FUNCTION__, 'class' => __CLASS__));
    }
}
