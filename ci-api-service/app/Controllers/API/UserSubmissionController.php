<?php

namespace App\Controllers\API;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use stdClass;

class UserSubmissionController extends BaseController
{
    protected $format = 'json';
    protected $authService;
    protected $submissionService;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->authService = service('AuthServiceApi');
        $this->submissionService = service('SubmissionServiceApi');
    }

    public function index()
    {
        try {
            $sessSubmission = $this->submissionService->getSessSubmissionMicroService([
                'user_id' => session()->get('user_id')
            ]);
            if (isset($sessSubmission['status'])) {
                $sessSubmission = null;
            } else {
                $sessSubmission = $sessSubmission['data'];
            }
            $lastSessSubmission = $this->submissionService->getLastSessSubmissionMicroService([
                'user_id' => session()->get('user_id')
            ]);
            if (isset($lastSessSubmission['status'])) {
                $lastSessSubmission = null;
            } else {
                $lastSessSubmission = $lastSessSubmission['data'];
            }
        } catch (\Exception $e) {
            $this->logger->error("Error from Service | " . $e->getMessage());

            return $this->response->setJSON([
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }

        return view('user\dashboard',  ['sessionData' => session()->get('token'), 'sessSubmission' => $sessSubmission, 'lastSessSubmission' => $lastSessSubmission]);
        //
    }

    public function submissionDetail()
    {
        // echo var_dump($this->authService->getCheckPermissionMicroService([
        //     'permission' => 'pegawai.detail',
        //     'token' => session()->get('token')
        // ]));
        try {
            if ($this->authService->getCheckPermissionMicroService([
                'permission' => 'pegawai.detail',
                'token' => session()->get('token')
            ])['data']['isallowed']) {
                $Submission = $this->submissionService->getSubmissionMicroService([
                    'id' => $_GET['id']
                ]);
                if (isset($Submission['status'])) {
                    $Submission = null;
                } else {
                    $Submission = $Submission['data'];

                    $dataUser = $this->authService->FindUserMicroService(['user_id' => $Submission[0]['request_user_id']]);
                    $Submission[0]['username_request'] = $dataUser['data'][0]['username'];
                }
                return view('user\submission_detail', ['Submission' => $Submission]);
            } else {
                return view('errors\Unauthorized');
            }
        } catch (\Exception $e) {
            $this->logger->error("Error from Service | " . $e->getMessage());

            return $this->response->setJSON([
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function submissionForm()
    {
        if ($this->authService->getCheckPermissionMicroService([
            'permission' => 'pegawai.submission',
            'token' => session()->get('token')
        ])['data']['isallowed']) {
            return view('user\submission_form');
        } else {
            return view('errors\Unauthorized');
        }
    }

    public function submissionTable()
    {
        try {
            if ($this->authService->getCheckPermissionMicroService([
                'permission' => 'hrd.monitor',
                'token' => session()->get('token')
            ])['data']['isallowed']) {
                $Submission = $this->submissionService->getSubmissionByGroupMicroService([
                    'group' => session()->get('group')
                ]);
                if (isset($Submission['status'])) {
                    $Submission = null;
                } else {
                    $Submission = $Submission['data'];
                    for ($i = 0; $i < count($Submission); $i++) {
                        $dataUser = $this->authService->FindUserMicroService(['user_id' => $Submission[$i]['request_user_id'] ?? 0]);
                        $dataSuperior = $this->authService->FindUserMicroService(['user_id' => $Submission[$i]['approval_one_user_id'] ?? 0]);
                        $dataHRD = $this->authService->FindUserMicroService(['user_id' => $Submission[$i]['approval_two_user_id'] ?? 0]);
                        $dataAuthenticator = $this->authService->FindUserMicroService(['user_id' => $Submission[$i]['authenticator_user_id'] ?? 0]);
                        if (isset($dataUser['data']) && !isset($dataUser['error'])) {
                            $Submission[$i]['username_request'] = $dataUser['data'][0]['username'];
                        } else {
                            $Submission[$i]['username_request'] = 'Data Unavailable';
                        }
                        if (isset($dataSuperior['data']) && !isset($dataSuperior['error'])) {
                            $Submission[$i]['approval_one_username'] = $dataSuperior['data'][0]['username'];
                        } else {
                            $Submission[$i]['approval_one_username'] = 'Data Unavailable';
                        }
                        if (isset($dataHRD['data']) && !isset($dataHRD['error'])) {
                            $Submission[$i]['approval_two_username'] = $dataHRD['data'][0]['username'];
                        } else {
                            $Submission[$i]['approval_two_username'] = 'Data Unavailable';
                        }
                        if (isset($dataAuthenticator['data']) && !isset($dataAuthenticator['error'])) {
                            $Submission[$i]['authenticator_username'] = $dataAuthenticator['data'][0]['username'];
                        } else {
                            $Submission[$i]['authenticator_username'] = 'Data Unavailable';
                        }
                    }
                }
                return view('user\submission_table', ['Submission' => $Submission]);
            } else {
                return view('errors\Unauthorized');
            }
        } catch (\Exception $e) {
            $this->logger->error("Error from Service | " . $e->getMessage());

            return $this->response->setJSON([
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function userManagement()
    {
        try {
            if ($this->authService->getCheckPermissionMicroService([
                'permission' => 'hrd.manage-users',
                'token' => session()->get('token')
            ])['data']['isallowed']) {

                $users = $this->authService->ShowUsersMicroService([
                    'id' => null
                ]);
                if (isset($users['status'])) {
                    $users = null;
                } else {
                    $users = $users['data'];
                }
                return view('admin\user_management', ['users' => $users]);
            } else {
                return view('errors\Unauthorized');
            }
        } catch (\Exception $e) {
            $this->logger->error("Error from Service | " . $e->getMessage());

            return $this->response->setJSON([
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function getUser($id = null)
    {
        try {
            $result = new stdClass();
            $result->user = [];

            $respUser = $this->authService->getUser($id);
            if (!isset($respUser['error'])) {
                $result->user = $respUser['data'];
            }
            return $this->defaultRespSuccess("Retrieved data successfully", $result);
        } catch (\Exception $e) {
            $this->logger->error("Error From AuthService: " . $e->getMessage());
            return $this->fail("Internal Server Error", 500);
        }
        //
    }

    public function getTest()
    {
        try {
            $result = new stdClass();
            $result->user = [];
            $respUser = $this->authService->getTest();
            if (!isset($respUser['error'])) {
                $result->user = $respUser['data'];
            }
            return $this->defaultRespSuccess("Retrieved data successfully", $result);
        } catch (\Exception $e) {
            $this->logger->error("Error From AuthService: " . $e->getMessage());
            return $this->fail("Internal Server Error", 500);
        }
    }

    public function getLogin()
    {
        try {
            $input = $this->request->getJSON(true);

            $data = $this->authService->LoginMicroService([
                'email' => $input['email'],
                'password' => $input['password'],
            ]);
            session()->set('token', $data['data']['access_token']);
            $profData = $this->authService->MeMicroService([
                'token' => session()->get('token')
            ]);
            $groupData = $this->authService->MeGroupMicroService([
                'token' => session()->get('token')
            ]);
            $tempG = [];
            foreach ($groupData['data'] as $row) {
                array_push($tempG, $row);
            }
            $permissionData = [];
            foreach ([
                'pegawai.submission',
                'pegawai.edit',
                'pegawai.delete',
                'pegawai.detail',
                'pegawai.dashboard',
                'pegawai.upload',
                'atasan.approve-1',
                'atasan.reject-1',
                'atasan.revise-1',
                'hrd.monitor',
                'hrd.manage-users',
                'hrd.approve-2',
                'hrd.reject-2',
                'hrd.revision-2',
                'pengesah.finalize'
            ] as $permission) {
                if ($this->authService->getCheckPermissionMicroService(['token' => session()->get('token'), 'permission' => $permission])['data']['isallowed']) {
                    array_push($permissionData, $permission);
                }
            }
            session()->set('group', $tempG);
            session()->set('user_id', $profData['data']['id']);
            session()->set('username', $profData['data']['username']);
            session()->set('isLoggedIn', true);
            session()->set('permissions', $permissionData);
            session()->set('active_group', $tempG[0]);
            return $this->response->setJSON($data)->setStatusCode(201);
        } catch (\Exception $e) {
            $this->logger->error("Error from Auth Service | " . $e->getMessage());

            return $this->response->setJSON([
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function getLogout()
    {
        try {
            $input = $this->request->getJSON(true);

            $data = $this->authService->LogoutMicroService([
                'token' => session()->get('token')
            ]);
            session()->destroy();
            return $this->response->setJSON($data)->setStatusCode(201);
        } catch (\Exception $e) {
            $this->logger->error("Error from Auth Service | " . $e->getMessage());

            return $this->response->setJSON([
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function getUsers()
    {
        try {
            $input = $this->request->getJSON(true);
            if ($input !== null) {
                $data = $this->authService->ShowUsersMicroService([
                    'id' => $input['id']
                ]);
                return $this->response->setJSON($data)->setStatusCode(201);
            } else {
                $data = $this->authService->ShowUsersMicroService([
                    'id' => null
                ]);

                return $this->response->setJSON($data)->setStatusCode(201);
            }
        } catch (\Exception $e) {
            $this->logger->error("Error from Auth Service | " . $e->getMessage());

            return $this->response->setJSON([
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function findUser()
    {
        try {
            $input = $this->request->getJSON(true);
            $data = $this->authService->FindUserMicroService([
                'user_id' => $input['user_id']
            ]);
            return $this->response->setJSON($data)->setStatusCode(201);
        } catch (\Exception $e) {
            $this->logger->error("Error from Auth Service | " . $e->getMessage());

            return $this->response->setJSON([
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function postRegister()
    {
        try {
            $input = $this->request->getJSON(true);
            $data = $this->authService->RegisterUserMicroService([
                'username' => $input['username'],
                'email' => $input['email'],
                'password' => $input['password'],
                'password_confirm' => $input['password_confirm'],
                'group' => $input['role']
            ]);
            return $this->response->setJSON($data)->setStatusCode(201);
        } catch (\Exception $e) {
            $this->logger->error("Error from Auth Service | " . $e->getMessage());
            return $this->response->setJSON([
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function postDeleteUser()
    {
        try {
            $input = $this->request->getJSON(true);
            $data = $this->authService->DeleteUserMicroService([
                'id' => $input['id']
            ]);
            return $this->response->setJSON($data)->setStatusCode(201);
        } catch (\Exception $e) {
            $this->logger->error("Error from Auth Service | " . $e->getMessage());
            return $this->response->setJSON([
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function postAddSubmission()
    {
        try {
            $input = $this->request->getJSON(true);
            $data = $this->submissionService->addSubmissionMicroService($input);
            return $this->response->setJSON($data)->setStatusCode(201);
        } catch (\Exception $e) {
            $this->logger->error("Error from Submission Service | " . $e->getMessage());
            return $this->response->setJSON([
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function getSessSubmission()
    {
        try {
            $input = $this->request->getJSON(true);
            $data = $this->submissionService->getSessSubmissionMicroService($input);
            return $this->response->setJSON($data)->setStatusCode(201);
        } catch (\Exception $e) {
            $this->logger->error("Error from Submission Service | " . $e->getMessage());
            return $this->response->setJSON([
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function postCheckPermission()
    {
        try {
            $input = $this->request->getJSON(true);
            $data = $this->authService->getCheckPermissionMicroService($input);
            return $this->response->setJSON($data)->setStatusCode(201);
        } catch (\Exception $e) {
            $this->logger->error("Error from Auth Service | " . $e->getMessage());
            return $this->response->setJSON([
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function getSubmission()
    {
        try {
            $input = $this->request->getJSON(true);
            $data = $this->submissionService->getSubmissionMicroService($input);
            return $this->response->setJSON($data)->setStatusCode(201);
        } catch (\Exception $e) {
            $this->logger->error("Error from Submission Service | " . $e->getMessage());
            return $this->response->setJSON([
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function getSubmissionByGroup()
    {
        try {
            $input = $this->request->getJSON(true);
            $data = $this->submissionService->getSubmissionByGroupMicroService($input);
            return $this->response->setJSON($data)->setStatusCode(201);
        } catch (\Exception $e) {
            $this->logger->error("Error from Submission Service | " . $e->getMessage());
            return $this->response->setJSON([
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function postUpdateSubmission()
    {
        try {
            $input = $this->request->getJSON(true);
            $data = $this->submissionService->updateSubmissionMicroService($input);
            return $this->response->setJSON($data)->setStatusCode(201);
        } catch (\Exception $e) {
            $this->logger->error("Error from Submission Service | " . $e->getMessage());
            return $this->response->setJSON([
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function postUploadSubmission()
    {
        try {
            $file = $this->request->getFile('file');
            if ($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(WRITEPATH . 'uploads', $newName);
                $filepath = WRITEPATH . 'uploads\\' . $newName;
                return $this->defaultRespSuccess("File Uploaded successfully", $filepath);
            } else {
                return redirect()->back()->with('error', 'File upload failed.');
            }
        } catch (\Exception $e) {
            $this->logger->error("Error from Upload Service | " . $e->getMessage());
            return $this->response->setJSON([
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function postUploadStatusSubmission()
    {
        try {
            $input = $this->request->getJSON(true);
            $data = $this->submissionService->uploadSubmissionMicroService(['id' => $input['id'], 'invoice_dir' => $input['invoice_dir']]);
            return $this->response->setJSON($data)->setStatusCode(201);
        } catch (\Exception $e) {
            $this->logger->error("Error from Submission Service | " . $e->getMessage());
            return $this->response->setJSON([
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function serveFile($fileName)
    {
        $filePath = WRITEPATH . 'uploads/' . $fileName;

        if (file_exists($filePath)) {
            return $this->response->download($filePath, null)->setFileName($fileName);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File not found');
        }
    }

    public function postChangeSubmission()
    {
        try {
            $input = $this->request->getJSON(true);
            $data = $this->submissionService->changeSubmissionMicroService($input);
            return $this->response->setJSON($data)->setStatusCode(201);
        } catch (\Exception $e) {
            $this->logger->error("Error from Submission Service | " . $e->getMessage());
            return $this->response->setJSON([
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
        return $this->defaultRespSuccess("Data changed successfully");
    }

    public function postResubmitSubmission()
    {
        try {
            $input = $this->request->getJSON(true);
            $data = $this->submissionService->resubmitSubmissionMicroService($input);
            return $this->response->setJSON($data)->setStatusCode(201);
        } catch (\Exception $e) {
            $this->logger->error("Error from Submission Service | " . $e->getMessage());
            return $this->response->setJSON([
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
        return $this->defaultRespSuccess("Data resubmitted successfully");
    }
}
