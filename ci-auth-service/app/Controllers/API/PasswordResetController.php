<?php

namespace App\Controllers\API;

use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class PasswordResetController extends ResourceController
{
    use ResponseTrait;
    public function requestReset()
    {
        $request = \Config\Services::request();
        $email = $request->getPost('email');
        if (!empty($email)) {
            $user = $this->checkEmailInUsers($email);

            if ($user) {
                $token = $this->encryptToken($email);
                $setToken = $this->saveTokenToUser($email, $token);
                if (!empty($setToken)) {
                    $kirimEmail = $this->sendResetEmail($email, $token);
                    if ($kirimEmail) {
                        $userModel = new UserModel();
                        $userModel->set('status_token', 'aktif')->where('email', $email)->update();
                        return $this->respond(['status' => 'success', 'message' => 'Check your ' . $email . ' for reset instructions.', 'token' => $token]);
                    } else {
                        return $this->fail('Failed to send email');
                    }
                } else {
                    return $this->fail('Failed to set token');
                }
            } else {
                return $this->failNotFound('Email not registered');
            }
        }
        return $this->failNotFound('Email not provided');
        //
    }

    public function encryptToken($email)
    {
        $secretKey = 'your_secret_key';
        $iv = openssl_random_pseudo_bytes(16);
        $encrypted = openssl_encrypt($email, 'aes-256-cbc', $secretKey, 0, $iv);
        $token = base64_encode($encrypted . '::' . $iv);
        $token = str_replace(array('+', '/'), array('-', '_'), $token); //URL SAFE slashes
        return $token;
    }

    public function decryptToken($token)
    {
        $token = str_replace(array('-', '_'), array('+', '/'), $token); //URL SAFE slashes
        $secretKey = 'your_secret_key';
        list($encrypted_data, $iv) = explode('::', base64_decode($token), 2);
        if (strlen($iv) !== 16) {
            throw new \Exception('Invalid IV length');
        }
        $email = openssl_decrypt($encrypted_data, 'aes-256-cbc', $secretKey, 0, $iv);
        return $email;
    }

    public function sendResetEmail($email, $token)
    {
        $emailService = \Config\Services::email();
        $emailService->setFrom('testfauzi2024@gmail.com', 'Hacktiv8 Training Program');
        $emailService->setTo($email);
        $emailService->setSubject('Password Reset Request');
        $emailService->setMessage("Please click on the following link to reset your password: " . site_url('password-reset/' . $token));

        if (!$emailService->send()) {
            $data = $emailService->printDebugger(['headers', 'subject', 'body']);
            log_message('error', 'Email failed to send: ' . print_r($data, true));
            return $this->fail('Failed to send email', 400, 'Failed to send email', $data);
        } else {
            return "success";
        }
    }

    public function passwordReset($token = null)
    {
        if ($token === null) {
            return $this->fail('No token provided', 400);
        }
        $email = $this->decryptToken($token);
        $defaultpassword = password_hash("Helloworld", PASSWORD_DEFAULT);

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if ($user !== null) {
            $data = ['password' => $defaultpassword];
            $userModel->update($user['id'], $data);
            return "password reset success";
        } else {
            return $this->failNotFound('User not found');
        }
        // return $this->respond($token);
    }

    public function resetPassword()
    {
        $request = \Config\Services::request();
        $token = $request->getPost('token');
        $newPassword = $request->getPost('password');

        try {
            $email = $this->decryptToken($token);
            if ($email) {
                $userModel = new UserModel();
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                if ($userModel->where('email', $email)->where('status_token', 'aktif')->first() !== null) {
                    $userModel->set('password', $hashedPassword)->set('status_token', null)->where('email', $email)->update();
                    return $this->respond(['status' => 'success', 'message' => 'Password successfully reset']);
                } else {
                    return $this->fail('Inactive token');
                }
            } else {
                return $this->fail('Invalid token or email');
            }
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }
    }

    public function checkEmailInUsers($email)
    {
        $userModel = new UserModel();
        return $userModel->where('email', $email)->first();
    }

    public function saveTokenToUser($email, $token)
    {
        $userModel = new UserModel();
        return $userModel->set([
            'token_reset_password' => $token,
            'status_token' => 'aktif'
        ])->where('email', $email)->update();
    }

    public function resetPasswordForm($token)
    {
        try {
            $email = $this->decryptToken($token);
            if ($email) {
                return view('user\reset_password_form', ['email' => $email, 'token' => $token]);
            } else {
                return $this->fail('Invalid token');
            }
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }
    }
}
