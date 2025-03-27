<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\DataParams;
use App\Models\UserEcommerceModel;
use Config\Roles;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Models\UserModel;
use TCPDF;



class UsersController extends BaseController
{
    protected $userModel;
    protected $userEcommerceModel;

    protected $groupModel;
    protected $db;
    protected $config;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->groupModel = new GroupModel();
        $this->db = \Config\Database::connect();
        $this->config = config('Auth');
        $this->userEcommerceModel = new UserEcommerceModel();

        helper(['auth']);
        if (!in_groups(Roles::ADMIN)) {
            return redirect()->to('/');
        }
    }
    public function index()
    {
        $params = new DataParams([
            "search" => $this->request->getGet("search"),

            "status" => $this->request->getGet("status"),
            "role" => $this->request->getGet("role"),

            "sort" => $this->request->getGet("sort"),
            "order" => $this->request->getGet("order"),
            "perPage" => $this->request->getGet("perPage"),
            "page" => $this->request->getGet("page_users"),
        ]);

        $result = $this->userModel->getFilteredUser($params);

        $data = [
            'users' => $result['users'],
            'pager' => $result['pager'],
            'total' => $result['total'],
            'groups' => $this->groupModel->findAll(),
            'params' => $params,
            'baseUrl' => base_url('admin/users'),
        ];
        // dd($data['groups']);  // Debug output


        return view('user/v_user_list', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Add New User',
            'groups' => $this->groupModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('user/v_user_create', $data);
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit User',
            'user' => $this->userModel->getUserWithFullName()->find($id),
            'groups' => $this->groupModel->findAll(),
            'userGroups' => $this->groupModel->getGroupsForUser($id),
            'validation' => \Config\Services::validation()
        ];

        if (empty($data['user'])) {
            return redirect()->to('/users')->with('error', 'User Not Found');
        }

        return view('user/v_user_edit', $data);
    }

    public function store()
    {
        $user = new \Myth\Auth\Entities\User();
        $user->username = $this->request->getVar('username');
        $user->email = $this->request->getVar('email');
        $user->password = $this->request->getVar('password');
        $user->active = 1;

        $checkExistingEmail = $this->userModel->where('email', $user->email)->first();
        $checkExistingEmailSoftDelete = $this->userModel->withDeleted()->where('email', $user->email)->first();
        if ($checkExistingEmail) {
            return redirect()->to('admin/users')->with('error', 'Email already exists');
        } elseif ($checkExistingEmailSoftDelete) {
            return redirect()->to('admin/users')->with('error', 'Email already exists as deleted user');
        }


        $checkExistingUsername = $this->userModel->where('username', $user->username)->first();
        $checkExistingUsernameSoftDelete = $this->userModel->withDeleted()->where('username', $user->username)->first();
        if ($checkExistingUsername) {
            return redirect()->to('admin/users')->with('error', 'Username already exists');
        } elseif ($checkExistingUsernameSoftDelete) {
            return redirect()->to('admin/users')->with('error', 'Username already exists as deleted user');
        }

        $this->userModel->save($user);

        $newUser = $this->userModel->where('email', $user->email)->first();
        $userId = $newUser->id;

        $groupId = $this->request->getVar('group');
        $this->groupModel->addUserToGroup($userId, $groupId);


        //Save data to user_ecommerce
        $data = [
            'username' => $user->username,
            'email' => $user->email,
            'password' => $user->password,
            'full_name' => $this->request->getPost('full_name'),
            'role' => $user->getRoles()[0],
            'status' => 'Active',
            'last_login' => null
        ];
        $this->userEcommerceModel->save($data);

        return redirect()->to('admin/users')->with('message', 'User Created Successfully');
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('admin/users')->with('error', 'User Not Found');
        }

        $newUsername = $this->request->getVar('username');
        if ($user->username != $newUsername) {
            $existingUser = $this->userModel->where('username', $newUsername)->first();
            $existingUserWithSoftDelete = $this->userModel->withDeleted()->where('username', $newUsername)->first();
            if ($existingUser) {
                return redirect()->to('admin/users')->with('error', 'Username already exists');
            } elseif ($existingUserWithSoftDelete) {
                return redirect()->to('admin/users')->with('error', 'Username already exists as deleted user');
            }
        }

        $newEmail = $this->request->getVar('email');
        if ($user->email != $newEmail) {
            $existingEmail = $this->userModel->where('email', $newEmail)->first();
            $existingEmailWithSoftDelete = $this->userModel->withDeleted()->where('email', $newEmail)->first();
            if ($existingEmail) {
                return redirect()->to('admin/users')->with('error', 'Email already exists');
            } else if ($existingEmailWithSoftDelete) {
                return redirect()->to('admin/users')->with('error', 'Email already exists as deleted user');
            }
        }

        $password = $this->request->getVar('password');
        $passConfirm = $this->request->getVar('pass_confirm');
        if (!empty($password)) {
            if ($password != $passConfirm) {
                return redirect()->to('admin/users')->with('error', 'Passwords do not match');
            }
        }

        $user->username = $newUsername;
        $user->email = $newEmail;
        $user->active = $this->request->getVar('status') ? 1 : 0;

        if (!empty($password)) {
            $user->password = $password;
        }

        if (!$this->userModel->save($user)) {
            return redirect()
                ->back()
                ->with('error', $this->userModel->errors())
                ->withInput();
        }

        $groupId = $this->request->getVar('group');
        if (!empty($groupId)) {
            $currentGroups = $this->groupModel->getGroupsForUser($id);

            foreach ($currentGroups as $group) {
                $this->groupModel->removeUserFromGroup($id, $group['group_id']);
            }

            $this->groupModel->addUserToGroup($id, $groupId);
        }

        //Save data to user_ecommerce
        $userEcommerceId = $this->userEcommerceModel->getUserByUsername($user->username)->id;
        $roles = $user->getRoles();
        $roleString = implode(', ', $roles);
        $data = [
            'id' => $userEcommerceId,
            'username' => $user->username,
            'email' => $user->email,
            'full_name' => $this->request->getPost('full_name'),
            'role' => $roleString,
            'status' => $user->active ? 'Active' : 'Inactive',
        ];
        if (!empty($password)) {
            $data['password'] = $password;
        }

        if (!$this->userEcommerceModel->save($data)) {
            // dd($this->userEcommerceModel->errors());
            return redirect()
                ->back()
                ->with('error', $this->userEcommerceModel->errors())
                ->withInput();
        }
        return redirect()->to('admin/users')->with('message', 'User Updated Successfully');
    }

    public function delete($id)
    {
        $user = $this->userModel->find($id);

        if (empty($user)) {
            return redirect()->to('admin/users')->with('error', 'User Not Found');
        }

        $userEcommerce = $this->userEcommerceModel->getUserByUsername($user->username);

        $this->userModel->delete($id);
        $this->userEcommerceModel->delete($userEcommerce->id);

        return redirect()->to('admin/users')->with('message', 'User Deleted Successfully');
    }

    public function getReportUserPdf()
    {
        $params = new DataParams([
            "role" => $this->request->getGet("role"),

            "page" => $this->request->getGet("page_users"),
        ]);

        $result = $this->userModel->getFilteredUser($params);

        $data = [
            'users' => $result['users'],
            'pager' => $result['pager'],
            'total' => $result['total'],
            'groups' => $this->groupModel->findAll(),
            'params' => $params,
            'baseUrl' => base_url('admin/users/reports'),
        ];
        return view('reports/v_report_user', $data);
    }

    public function reportUserPdf()
    {
        $role = $this->request->getGet("role");

        $user = $this->userEcommerceModel->getUserByUsername(user()->username);
        $pdf = $this->initTcpdf($user->full_name, $user->full_name, "User Reports", "User Reports", );

        $datas = $this->userModel->getFullUserInfo($role);
        // dd($datas);
        $roleName = 'All';
        if (!empty($role)) {
            $roleName = $this->groupModel->find($role)->name;
        }
        $this->generatePdfHtmlContent($pdf, $datas, "User Reports", $roleName);

        // Output PDF
        $filename = 'User_Reports_' . $roleName . '_' . date('Y-m-d') . '.pdf';
        $pdf->Output($filename, 'I');
        exit;
    }

    private function initTcpdf($creator, $author, $title, $subject, )
    {
        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

        $pdf->SetCreator($creator ?? 'User');
        $pdf->SetAuthor($author ?? 'Administrator');
        $pdf->SetTitle($title ?? 'User Reports');
        $pdf->SetSubject($subject ?? 'User Reports');

        //To set the image in pdf, 
        //set this : define ('K_PATH_IMAGES', FCPATH. '/');
        //in this path : vendor/tecnickcom/tcpdf/config/tcpdf_config:
        $pdf->SetHeaderData('iconOrang.png', 10, 'E-Commerce', 'Shopping Online', [0, 0, 0], [0, 64, 128]);
        $pdf->setFooterData([0, 64, 0], [0, 64, 128]);

        $pdf->setHeaderFont(['helvetica', '', 12]);
        $pdf->setFooterFont(['helvetica', '', 8]);

        $pdf->SetMargins(15, 20, 15);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);

        $pdf->SetAutoPageBreak(true, 25);

        $pdf->SetFont('helvetica', '', 10);

        $pdf->AddPage();

        return $pdf;
    }

    private function generatePdfHtmlContent($pdf, $datas, $title, $subject)
    {
        // $image_file = K_PATH_IMAGES . 'iconOrang.png';
        // $pdf->Image($image_file, 10, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $titleReports = $title ?? 'USER REPORTS';
        $subjectReports = $subject ?? '';

        $html = '<h2 style="text-align:center;">' . $titleReports . '</h2>
        <h4 style="text-align:center;">' . $subjectReports . '</h2>
      <table border="1" cellpadding="5" cellspacing="0" style="width:100%;">
        <thead>
          <tr style="background-color:#CCCCCC; font-weight:bold; text-align:center;">
            <th>No</th>
            <th>Username</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Registration Date</th>
            <th>Last Login</th>
          </tr>
         </thead>
         <tbody>';

        $no = 1;
        foreach ($datas as $data) {
            $html .= '
           <tr>
            <td style="text-align:center;">' . $no . '</td>
            <td>' . $data->username . '</td>
            <td>' . $data->full_name . '</td>
            <td>' . $data->email . '</td>
            <td>' . $data->role . '</td>
            <td>' . $data->status . '</td>
            <td>' . $data->created_at . '</td>
            <td>' . ($data->last_login ?? 'N/A') . '</td>
           </tr>';
            $no++;
        }

        $html .= '
               </tbody>
           </table>
           
           <p style="margin-top:30px; text-align:left;">      
               Total Users: ' . count($datas) . ' 
           </p>
   
           <p style="margin-top:30px; text-align:right;">    
               Print Date: ' . date('d-m-Y H:i:s') . '<br> 
           </p>';
        $pdf->writeHTML($html, true, false, true, false, '');
    }

}