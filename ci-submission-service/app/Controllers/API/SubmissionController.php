<?php

namespace App\Controllers\API;

use App\Models\SubmissionModel;
use App\Models\SubmissionItemModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;

class SubmissionController extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->submissionModel = new SubmissionModel();
        $this->submissionItemModel = new SubmissionItemModel();
    }
    public function addSubmission()
    {
        $input = $this->request->getJSON(true); // Get JSON data as an associative array
        $data1 = [
            'name' => $input['invoice_name'],
            'year' => $input['year'],
            'status' => 'pending_approval_one',
            'request_user_id' => $input['id'],
            'semester' => $input['semester'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $q1 = $this->submissionModel->insert($data1);
        $submissionId = $this->submissionModel->insertID();
        $data2 = [];
        $temptqty = 0;
        $temptprice = 0;
        $temptitem = 0;
        if ($input['multipleItem']) {
            for ($i = 0; $i < count($input['item_name']); $i++) {

                $temp = ['submission_id' => $submissionId, 'name' => $input['item_name'][$i], 'qty' => $input['item_quantity'][$i], 'price' => $input['item_price'][$i], 'total_price' => $input['item_price'][$i] * $input['item_quantity'][$i], 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')];
                $temptitem = $temptitem + 1;
                $temptprice = $temptprice + $temp['total_price'];
                $temptqty = $temptqty + $input['item_quantity'][$i];
                $data2[] = $temp;
            }

            foreach ($data2 as $item) {
                log_message('debug', 'Inserting new item: ' . json_encode($item));
                $q2 = $this->submissionItemModel->insert($item);
            };
        } else {
            $data2 = ['submission_id' => $submissionId, 'name' => $input['item_name'], 'qty' => $input['item_quantity'], 'price' => $input['item_price'], 'total_price' => $input['item_price'] * $input['item_quantity'], 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')];
            $q2 = $this->submissionItemModel->insert($data2);
        }
        $data3 = ['total_qty' => $temptqty, 'total_item' => $temptitem, 'total_price' => $temptprice];
        $q3 = $this->submissionModel->update($submissionId, $data3);

        if ($q1 && $q2 && $q3) {
            return $this->defaultRespSuccess('Submission submitted successfully.');
        } else {
            if (!$q1 || !$q3) {
                return $this->fail($this->submissionModel->errors());
            } elseif (!$q2) {
                return $this->fail($this->submissionItemModel->errors());
            }
        }
    }

    public function getSessSubmission()
    {
        $input = $this->request->getJSON(true);
        $user_id = $input['user_id'];
        $q = $this->submissionModel->select('*')->where('request_user_id', $user_id)->get()->getResult();
        if ($q) {
            return $this->defaultRespSuccess("Data shown successfully", $q);
        } else {
            return $this->failNotFound("Data not found");
        }
    }

    public function getLastSessSubmission()
    {
        $input = $this->request->getJSON(true);
        $user_id = $input['user_id'];
        $q = $this->submissionModel->select('*')->where('request_user_id', $user_id)->orderBy('created_at', 'DESC')
            ->limit(10)->get()->getResult();
        if ($q) {
            return $this->defaultRespSuccess("Data shown successfully", $q);
        } else {
            return $this->failNotFound("Data not found");
        }
    }

    public function getSubmission()
    {
        $input = $this->request->getJSON(true);
        $id = $input['id'];
        $q = $this->submissionModel->select('submissions.*,submission_item.id submission_item_id,submission_item.name item_name,submission_item.price,submission_item.qty,submission_item.total_price total_item_price,submission_item.created_at,submission_item.updated_at')->join('submission_item', 'submissions.id=submission_item.submission_id')->where('submissions.id', $id)->orderBy('submission_item.id')->get()->getResult();
        if ($q) {
            return $this->defaultRespSuccess("Data shown successfully", $q);
        } else {
            return $this->failNotFound("Data not found");
        }
    }

    public function getSubmissionByGroup()
    {
        $input = $this->request->getJSON(true);
        $where = "1=1 AND (";
        $i = 0;
        foreach ($input['group'] as $row) {
            if ($row == 'atasan') {
                $status_group = 'pending_approval_one';
            } elseif ($row == 'hrd') {
                $status_group = 'pending_approval_two';
            } elseif ($row == 'pegawai') {
                $status_group = 'wait_document';
            } elseif ($row == 'pengesah') {
                $status_group = 'pending_approval_authenticator';
            } else {
                $status_group = 'null';
            }
            if ($i != 0) {
                $where = $where . " OR ";
            }
            $where = $where . "status='{$status_group}'";
            $i += 1;
        }
        $where = $where . ")";
        $q = $this->submissionModel->select('submissions.*')->where($where)->get()->getResult();
        if ($q) {
            return $this->defaultRespSuccess("Data shown successfully", $q);
        } else {
            return $this->failNotFound("Data not found");
        }
    }

    public function postSubmissionStatusByGroup()
    { //fungsi hanya untuk atasan,hrd dan pengesah. bukan fungsi untuk pegawai saat revisi
        $input = $this->request->getJSON(true);
        $data = [
            'status' => $input['status']
        ];
        if ($input['status'] == 0) {
            $data['reason_rejected'] = $input['reason_rejected'];
            $data['status'] = 'rejected';
        } elseif ($input['status'] == 1) {
            if ($input['group'] == 'atasan') {
                $data['status'] = 'pending_approval_two';
                $data['approval_one_user_id'] = $input['user_id'];
            } elseif ($input['group'] == 'hrd') {
                $data['status'] = 'wait_document';
                $data['approval_two_user_id'] = $input['user_id'];
            } elseif ($input['group'] == 'pengesah') {
                $data['status'] = 'done';
                $data['authenticator_user_id'] = $input['user_id'];
            } elseif ($input['group'] == 'pegawai') {
                $data['status'] = 'pending_approval_one';
            }
        } elseif ($input['status'] == 2) {
            $data['reason_need_revision'] = $input['reason_need_revision'];
            $data['need_revision_user_id'] = $input['user_id'];
            if ($input['group'] == 'atasan') {
                $data['status'] = 'need_revision';
            } elseif ($input['group'] == 'hrd') {
                $data['status'] = 'need_revision';
            }
        }
        $q = $this->submissionModel->update($input['id'], $data);
        if ($q) {
            return $this->defaultRespSuccess('Submission updated successfully.');
        } else {
            return $this->fail($this->submissionItemModel->errors());
        }
    }

    public function uploadSubmission()
    {
        $input = $this->request->getJSON(true);
        $data = [
            'status' => 'pending_approval_authenticator',
            'invoice_dir' => $input['invoice_dir']
        ];
        $q = $this->submissionModel->update($input['id'], $data);
        if ($q) {
            return $this->defaultRespSuccess('Submission updated successfully.');
        } else {
            return $this->fail($this->submissionItemModel->errors());
        }
    }

    public function changeSubmission()
    {
        try {
            $input = $this->request->getJSON(true);
            $temptprice = 0;
            $temptqty = 0;
            $temptitem = 0;
            foreach ($input['details'] as &$row) {
                $temptitem = $temptitem + 1;
                $temptprice = $temptprice + (int)$row["price"] * (int)$row["qty"];
                $temptqty = $temptqty + (int)+$row["qty"];
                $temp = $this->submissionItemModel->find($row["id"]);
                if ($temp !== null) {
                    $update1 = $this->submissionItemModel->update($row["id"], ["name" => $row["item_name"], "qty" => $row["qty"], "price" => $row["price"], "total_price" => (int)$row["price"] * (int)$row["qty"]]);
                } else {
                    $insert = $this->submissionItemModel->insert([
                        'submission_id' => (int)$input["id"], 'name' => $row["item_name"], 'qty' => $row["qty"], 'price' => $row["price"], 'total_price' => (int)$row["price"] * (int)$row["qty"],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    $row["id"] = $insert;
                }
            }
            $exist = $this->submissionItemModel->where('submission_id', $input['id'])->findall();
            foreach ($exist as $row1) {
                $temp = 0;
                foreach ($input['details'] as $row2) {
                    if ($row1['id'] == $row2['id']) {
                        $temp = 1;
                        break;
                    }
                }
                if ($temp != 1) {
                    $delete = $this->submissionItemModel->delete($row1["id"]);
                }
            }
            $data = [
                'name' => $input['name'],
                'semester' => $input['semester'],
                'total_price' => $temptprice,
                'total_qty' => $temptqty,
                'year' => $input['year'],
                'total_item' => $temptitem
            ];
            $update2 = $this->submissionModel->update($input['id'], $data);
            return $this->defaultRespSuccess('Submission changed successfully.');
        } catch (\Exception $e) {
            return $this->fail($this->submissionItemModel->errors());
        }
    }

    public function resubmitSubmission()
    {
        $input = $this->request->getJSON(true);
        $data = [
            'status' => 'pending_approval_one'
        ];
        $q = $this->submissionModel->update($input['id'], $data);
        if ($q) {
            return $this->defaultRespSuccess('Submission updated successfully.');
        } else {
            return $this->fail($this->submissionItemModel->errors());
        }
    }
}
