<?php

namespace App\Controllers\API;

use App\Models\BlacklistedTokens;
use CodeIgniter\Shield\Validation\ValidationRules;
use CodeIgniter\Shield\Models\PermissionModel;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class AuthController extends BaseController
{
    protected $format = 'json';
    protected $modelName = 'App\Models\UserModel';
    protected $rules;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->rules = new ValidationRules();
        $this->blacklistModel = new BlacklistedTokens();
    }
    public function register()
    {
        $input = $this->request->getJSON(true);
        if (!$this->validateData($input, $this->rules->getRegistrationRules())) {
            return $this->fail($this->validator->getErrors(), 401);
        }
        $users = auth()->getProvider();
        $user = new User($input);
        if ($users->save($user)) {
            $user = $users->findById($users->getInsertID());
            $users->addToDefaultGroup($user);
            return $this->defaultRespSuccess('Registered successfully.', $user);
        } else {
            return $this->fail($this->model->errors());
        }
        //
    }

    public function login()
    {
        if (!$this->validateData($this->request->getJSON(true), $this->rules->getLoginRules())) {
            return $this->fail($this->validator->getErrors(), 401);
        }
        $password = $this->request->getJsonVar('password');
        $credentials = $this->request->getJsonVar(setting('Auth.validFields'));
        $credentials['password'] = $password;

        $authenticator = auth('session')->getAuthenticator();
        $result = $authenticator->check($credentials);
        if (!$result->isOK()) {
            return $this->failUnauthorized($result->reason());
        }
        $user = $result->extraInfo();
        $manager = service('jwtmanager');
        $jwt = $manager->generateToken($user);

        return $this->defaultRespSuccess("Login successfully", ['access_token' => $jwt]);
    }

    public function logout()
    {
        $this->blacklistModel->save([
            "user_id" => auth()->id(),
            "token" => auth()->getTokenFromRequest($this->request)
        ]);

        return $this->defaultRespSuccess("Logout successfully", [
            "logout" => auth('jwt')->logout()
        ]);
    }

    public function me()
    {
        $user = auth()->user();
        return $this->defaultRespSuccess("Auth Profile", $user);
    }

    public function meGroup()
    {
        $userGroup = auth()->user()->getGroups();
        return $this->defaultRespSuccess("Auth Profile Group", $userGroup);
    }

    public function finduser()
    {
        $id = $this->request->getJsonVar('user_id');
        if ($id !== null) {
            $user = $this->model->table('users')->select('users.id,users.username,auth_identities.secret email,auth_groups_users.group')->join('auth_groups_users', 'auth_groups_users.user_id = users.id')->join('auth_identities', 'auth_identities.user_id = users.id')->where('users.id', $id)->get()->getResult();
        } else {
            $user = $this->model->table('users')->select('users.id,users.username,auth_identities.secret email,auth_groups_users.group')->join('auth_groups_users', 'auth_groups_users.user_id = users.id')->join('auth_identities', 'auth_identities.user_id = users.id')->get()->getResult();
        }
        if ($user) {
            return $this->defaultRespSuccess("User shown successfully", $user);
        } else {
            return $this->failNotFound("User not found");
        }
    }

    public function registerUser()
    {
        $input = $this->request->getJSON(true);
        // if (!$this->validateData($input, $this->rules->getRegistrationRules())) {
        //     return $this->fail($this->validator->getErrors(), 401);
        // }
        $users = auth()->getProvider();
        $user = new User($input);
        if ($users->save($user)) {
            $user = $users->findById($users->getInsertID());
            $user->addGroup($this->request->getJsonVar('group'));
            return $this->defaultRespSuccess('Registered successfully.', $user);
        } else {
            return $this->fail($this->model->errors());
        }
    }

    public function deleteuser()
    {
        $users = auth()->getProvider();
        $users = $users->delete($this->request->getJsonVar('id'), true);
        if ($users) {
            return $this->defaultRespSuccess('User Deleted successfully.');
        } else {
            return $this->fail($this->model->errors());
        }
    }

    public function checkPermission()
    {
        $permission = $this->request->getJsonVar('permission');
        $checkPermission = auth()->user()->can($permission);
        if (!$checkPermission) {
            // return redirect()->back()->with('error', 'You do not have permissions to access that page.');
            return $this->defaultRespSuccess("Data requested successfully", ['isallowed' => false]);
        } else {
            return $this->defaultRespSuccess("Data requested successfully", ['isallowed' => true]);
        }
    }

    public function getAllPermission()
    {
        // $permissionModel = new PermissionModel();
        // $permissions = $permissionModel->getPermissionsForUser(auth()->user()->id);
        $permissions = auth()->user()->getPermissions();
        if ($permissions) {
            // return redirect()->back()->with('error', 'You do not have permissions to access that page.');
            return $this->defaultRespSuccess("Data requested successfully", ['permissions' => $permissions]);
        } else {
            return $this->fail($this->model->errors());
        }
    }

    public function test()
    {
        return $this->response->setJSON([
            'data' => 'middleware successful',
            'message' => 'API connected'
        ])->setStatusCode(ResponseInterface::HTTP_OK);
    }
}
