<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Webservice extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('mailer');
        $this->load->library(array('customlib', 'enc_lib'));
	
        $this->load->model(array('auth_model', 'route_model', 'student_model', 'setting_model', 'attendencetype_model', 'studentfeemaster_model', 'feediscount_model', 'teachersubject_model', 'timetable_model', 'user_model', 'examgroup_model', 'webservice_model', 'grade_model', 'librarymember_model', 'bookissue_model', 'homework_model', 'event_model', 'vehroute_model', 'timeline_model', 'module_model', 'paymentsetting_model', 'customfield_model', 'subjecttimetable_model', 'onlineexam_model', 'leave_model', 'chatuser_model', 'conference_model', 'syllabus_model', 'gmeet_model', 'category_model', 'student_edit_field_model', 'filetype_model', 'course_model' ));
    }

    public function getApplyLeave()
    {
        $method = $this->input->server('REQUEST_METHOD');

        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    //$data       = array();
                    $data                   = array(
                        'status' => 200, 'message' => 'Leave Found.'
                        
                        );
                    $params     = json_decode(file_get_contents('php://input'), true);
                    $student_id = $params['student_id'];
                    $student    = $this->student_model->get($student_id);

                    $result               = $this->leave_model->get($student->student_session_id);
                    $data['result_array'] = $result;

                    json_output($response['status'], $data);
                }
            }
        }
    }

    public function addLeave()
    {

        $method = $this->input->server('REQUEST_METHOD');

        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $data = $this->input->POST();

                    $this->form_validation->set_data($data);
                    $this->form_validation->set_error_delimiters('', '');
                    $this->form_validation->set_rules('from_date', 'From', 'required|trim');
                    $this->form_validation->set_rules('to_date', 'To', 'required|trim');
                    $this->form_validation->set_rules('apply_date', 'Apply Date', 'required|trim');
                    $this->form_validation->set_rules('student_id', 'Student ID', 'required|trim');
                    $this->form_validation->set_rules('reason', 'Reason', 'required|trim');
                    $this->form_validation->set_rules('file', 'File', 'callback_handle_upload_file');
                    if ($this->form_validation->run() == false) {

                        $sss = array(
                            'from_date'  => form_error('from_date'),
                            'to_date'    => form_error('to_date'),
                            'apply_date' => form_error('apply_date'),
                            'student_id' => form_error('student_id'),
                            'reason'     => form_error('reason'),
                            'file'       => form_error('file'),
                        );
                        $array = array('status' => 400, 'error' => $sss);
                    } else {
                        //==================
                        $student = $this->student_model->get($this->input->post('student_id'));

                        $data = array(
                            'from_date'          => $this->input->post('from_date'),
                            'to_date'            => $this->input->post('to_date'),
                            'apply_date'         => $this->input->post('apply_date'),
                            'reason'             => $this->input->post('reason'),
                            'student_session_id' => $student->student_session_id,
                        ); 

                        $leave_id    = $this->leave_model->add($data);
                        $upload_path = $this->config->item('upload_path') . "/student_leavedocuments/";

                        if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                            $fileInfo = pathinfo($_FILES["file"]["name"]);
                            $img_name = $leave_id . '.' . $fileInfo['extension'];
                            move_uploaded_file($_FILES["file"]["tmp_name"], $upload_path . $img_name);
                            $data = array('id' => $leave_id, 'docs' => $img_name);
                            $this->leave_model->add($data);
                        }

                        $array = array('status' => 200, 'msg' => 'Success');
                    }
                    json_output(200, $array);
                }
            }
        }
    }

    public function handle_upload_file()
    {

        $image_validate = $this->config->item('file_validate');
        $result         = $this->filetype_model->get();
        if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {

            $file_type         = $_FILES["file"]['type'];
            $file_size         = $_FILES["file"]["size"];
            $file_name         = $_FILES["file"]["name"];
            $allowed_extension = array_map('trim', array_map('strtolower', explode(',', $result->file_extension)));
            $allowed_mime_type = array_map('trim', array_map('strtolower', explode(',', $result->file_mime)));
            $ext               = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            if ($files = filesize($_FILES['file']['tmp_name'])) {

                if (!in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload_file', 'File Type Not Allowed');
                    return false;
                }
                if (!in_array($ext, $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload_file', 'Extension Not Allowed');
                    return false;
                }
                if ($file_size > $result->file_size) {
                    $this->form_validation->set_message('handle_upload_file', $this->lang->line('file_size_shoud_be_less_than') . number_format($result->file_size / 1048576, 2) . " MB");
                    return false;
                }
            } else {
                $this->form_validation->set_message('handle_upload_file', "File Type / Extension Error Uploading  Image");
                return false;
            }

            return true;
        }
        return true;
    }

    public function handle_upload_file_compulsory()
    {

        $image_validate = $this->config->item('file_validate');
        $result         = $this->filetype_model->get();
        if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {

            $file_type         = $_FILES["file"]['type'];
            $file_size         = $_FILES["file"]["size"];
            $file_name         = $_FILES["file"]["name"];
            $allowed_extension = array_map('trim', array_map('strtolower', explode(',', $result->file_extension)));
            $allowed_mime_type = array_map('trim', array_map('strtolower', explode(',', $result->file_mime)));
            $ext               = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            if ($files = filesize($_FILES['file']['tmp_name'])) {

                if (!in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload_file_compulsory', 'File Type Not Allowed');
                    return false;
                }

                if (!in_array($ext, $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload_file_compulsory', 'Extension Not Allowed');
                    return false;
                }
                if ($file_size > $result->file_size) {
                    $this->form_validation->set_message('handle_upload_file_compulsory', $this->lang->line('file_size_shoud_be_less_than') . number_format($result->file_size / 1048576, 2) . " MB");
                    return false;
                }
            } else {
                $this->form_validation->set_message('handle_upload_file_compulsory', "File Type / Extension Error Uploading  Image");
                return false;
            }

            return true;
        } else {

            $this->form_validation->set_message('handle_upload_file_compulsory', "The File Field is required");
            return false;
        }
        return true;
    }

    public function updateLeave()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {

                    $data = $this->input->POST();
                    $this->form_validation->set_data($data);
                    $this->form_validation->set_error_delimiters('', '');
                    $this->form_validation->set_rules('id', 'From', 'required|trim');
                    $this->form_validation->set_rules('from_date', 'From', 'required|trim');
                    $this->form_validation->set_rules('to_date', 'To', 'required|trim');
                    $this->form_validation->set_rules('apply_date', 'Apply Date', 'required|trim');

                    if ($this->form_validation->run() == false) {

                        $sss = array(
                            'id'         => form_error('id'),
                            'from_date'  => form_error('from_date'),
                            'to_date'    => form_error('to_date'),
                            'apply_date' => form_error('apply_date'),
                        );
                        $array = array('status' => 400, 'error' => $sss);
                    } else {
                        //==================
                        $leave_id = $this->input->post('id');
                        $data     = array(
                            'id'         => $this->input->post('id'),
                            'from_date'  => $this->input->post('from_date'),
                            'to_date'    => $this->input->post('to_date'),
                            'apply_date' => $this->input->post('apply_date'),
                            'reason'     => $this->input->post('reason'),
                        );
                        $upload_path = $this->config->item('upload_path') . "/student_leavedocuments/";

                        $this->leave_model->add($data);
                        if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                            $fileInfo = pathinfo($_FILES["file"]["name"]);
                            $img_name = $leave_id . '.' . $fileInfo['extension'];
                            move_uploaded_file($_FILES["file"]["tmp_name"], $upload_path . $img_name);
                            $data = array('id' => $leave_id, 'docs' => $img_name);
                            $this->leave_model->add($data);
                        }

                        $array = array('status' => 200, 'msg' => 'Success');
                    }
                    json_output(200, $array);
                }
            }
        }
    }

    public function deleteLeave()
    {
        $method = $this->input->server('REQUEST_METHOD');

        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $params   = json_decode(file_get_contents('php://input'), true);
                    $leave_id = $params['leave_id'];
                    $this->leave_model->delete($leave_id);

                    json_output($response['status'], array('result' => 'Success'));
                }
            }
        }
    }

    public function getSchoolDetails()
    {
        $method = $this->input->server('REQUEST_METHOD');

        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {

                    $result                   = $this->setting_model->getSchoolDisplay();
                    $result->start_month_name = ucfirst($this->customlib->getMonthList($result->start_month));

                    json_output($response['status'], $result);
                }
            }
        }
    }

    public function getStudentProfile()
    {
        
      
        
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                
                
                
                if ($response['status'] == 200) {
                    
                    
                    
                    $params    = json_decode(file_get_contents('php://input'), true);
                    $studentId = $params['student_id'];

                    $student_fields = $this->setting_model->student_fields();
                    $custom_fields  = $this->customfield_model->student_fields();

                    $student_array                   = array(
                        'status' => 200, 'message' => 'Profile Found.'
                        
                        );
                    $student_result                  = $this->student_model->get($studentId);
                    $student_array['student_result'] = $student_result;
                    $student_array['student_fields'] = $student_fields;

                    if (!empty($custom_fields)) {
                        foreach ($custom_fields as $custom_key => $custom_value) {

                            $custom_fields[$custom_key] = $student_result->{$custom_key};
                        }
                    }
                    $student_array['custom_fields'] = $custom_fields;
                    json_output($response['status'], $student_array);
                    
                }
            }
        }
    }

    public function addTask()
    {

        $method = $this->input->server('REQUEST_METHOD');

        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {

                $_POST = json_decode(file_get_contents("php://input"), true);
                $this->form_validation->set_data($_POST);
                $this->form_validation->set_error_delimiters('', '');
                $this->form_validation->set_rules('event_title', 'Title', 'required|trim');
                $this->form_validation->set_rules('date', 'Date', 'required|trim');
                $this->form_validation->set_rules('user_id', 'user login id', 'required|trim');

                if ($this->form_validation->run() == false) {

                    $sss = array(
                        'event_title' => form_error('event_title'),
                        'date'        => form_error('date'),
                        'user_id'     => form_error('user_id'),
                    );
                    $array = array('status' => 400, 'error' => $sss);
                } else {
                    //==================
                    $data = array(
                        'event_title' => $this->input->post('event_title'),
                        'start_date'  => $this->input->post('date'),
                        'end_date'    => $this->input->post('date'),
                        'event_type'  => 'task',
                        'is_active'   => 'no',
                        'event_for'   => $this->input->post('user_id'),
                        'event_color' => '#000',
                    );
                    $this->event_model->saveEvent($data);
                    $array = array('status' => 200, 'msg' => 'Success');
                }
                json_output(200, $array);
            }
        }
    }

    public function updatetask()
    {

        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {

                $_POST = json_decode(file_get_contents("php://input"), true);
                $this->form_validation->set_data($_POST);
                $this->form_validation->set_error_delimiters('', '');
                $this->form_validation->set_rules('task_id', 'Task ID', 'required|trim');
                $this->form_validation->set_rules('status', 'Status', 'required|trim');

                if ($this->form_validation->run() == false) {
                    $errors = array(
                        'task_id' => form_error('task_id'),
                        'status'  => form_error('status'),
                    );
                    $array = array('status' => 400, 'error' => $errors);
                } else {
                    //==================
                    $data = array(
                        'id'        => $this->input->post('task_id'),
                        'is_active' => $this->input->post('status'),
                    );
                    $this->event_model->saveEvent($data);
                    $array = array('status' => 200, 'msg' => 'Success');
                }
                json_output(200, $array);
            }
        }
    }

    public function deletetask()
    {

        $method = $this->input->server('REQUEST_METHOD');

        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {

                $_POST = json_decode(file_get_contents("php://input"), true);
                $this->form_validation->set_data($_POST);
                $this->form_validation->set_error_delimiters('', '');
                $this->form_validation->set_rules('task_id', 'Task ID', 'required|trim');

                if ($this->form_validation->run() == false) {

                    $errors = array(
                        'task_id' => form_error('task_id'),
                    );
                    $array = array('status' => 400, 'error' => $errors);
                } else {
                    //==================

                    $id = $this->input->post('task_id');
                    $this->event_model->deleteEvent($id);
                    $array = array('status' => 200, 'msg' => 'Success');
                }
                json_output(200, $array);
            }
        }
    }

    public function logout()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {

                $_POST = json_decode(file_get_contents("php://input"), true);
                $this->form_validation->set_data($_POST);
                $this->form_validation->set_error_delimiters('', '');
                $this->form_validation->set_rules('deviceToken', 'deviceToken', 'required|trim');

                if ($this->form_validation->run() == false) {

                    $errors = array(
                        'deviceToken' => form_error('deviceToken'),
                    );
                    $array = array('status' => 400, 'error' => $errors);
                } else {
                    //==================
                    $deviceToken = $this->input->post('deviceToken');
                    $response    = $this->auth_model->logout($deviceToken);

                    $array = array('status' => 200, 'msg' => 'Success');
                }
                json_output(200, $array);
            }
        }
    }

    public function forgot_password()
    {

        $method = $this->input->server('REQUEST_METHOD');

        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {

            $_POST = json_decode(file_get_contents("php://input"), true);
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_data($_POST);
            $this->form_validation->set_rules('site_url', 'URL', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required');
            $this->form_validation->set_rules('usertype', 'User Type', 'trim|required');
            if ($this->form_validation->run() == false) {
                $errors = validation_errors();
            }

            if (isset($errors)) {
                $respStatus = 400;
                $errors     = array(
                    'email'    => form_error('email'),
                    'usertype' => form_error('usertype'),
                    'site_url' => form_error('site_url'),
                );
                $resp = array('status' => 400, 'message' => $errors);
            } else {
                $email    = $this->input->post('email');
                $usertype = $this->input->post('usertype');
                $site_url = $this->input->post('site_url');
                $result   = $this->user_model->forgotPassword($usertype, $email);

                if ($result && $result->email != "") {
                    $template = $this->setting_model->getTemplate('forgot_password');
                    if (!empty($template) && $template->is_mail && $template->template != "") {
                        $verification_code = $this->enc_lib->encrypt(uniqid(mt_rand()));
                        $update_record     = array('id' => $result->user_tbl_id, 'verification_code' => $verification_code);
                        $this->user_model->updateVerCode($update_record);
                        if ($usertype == "student") {
                            $name = $result->firstname . " " . $result->lastname;
                        } else {
                            $name = $result->guardian_email;
                        }
                        $resetPassLink = $site_url . '/user/resetpassword' . '/' . $usertype . "/" . $verification_code;

                        $body       = $this->forgotPasswordBody($name, $resetPassLink, $template->template);
                        $body_array = json_decode($body);

                        if (!empty($this->mail_config)) {
                            $result = $this->mailer->send_mail($email, $body_array->subject, $body_array->body);
                            if ($result) {
                                $respStatus = 200;
                                $resp       = array('status' => 200, 'message' => "Please check your email to recover your password");
                            } else {
                                $respStatus = 200;
                                $resp       = array('status' => 200, 'message' => "Sending of message failed, Please contact to Admin.");
                            }
                        }
                    } else {
                        $respStatus = 200;
                        $resp       = array('status' => 200, 'message' => "Sending of message failed, Please contact to Admin.");
                    }

                } else {
                    $respStatus = 401;
                    $resp       = array('status' => 401, 'message' => "Invalid Email or User Type");
                }
            }
            json_output($respStatus, $resp);
        }
    }

    public function forgotPasswordBody($name, $resetPassLink, $template)
    {

        $mail_detail['name']          = $name;
        $mail_detail['school_name']   = $this->customlib->getSchoolName();
        $mail_detail['resetPassLink'] = $resetPassLink;
        foreach ($mail_detail as $key => $value) {
            $template = str_replace('{{' . $key . '}}', $value, $template);
        }
        //===============
        $subject = "Password Update Request";
        $body    = $template;
        //======================
        return json_encode(array('subject' => $subject, 'body' => $body));
    }

    public function dashboard()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $date_list  = array();
                    $params     = json_decode(file_get_contents('php://input'), true);
                    $student_id = $params['student_id'];
                    $date_from  = $params['date_from'];
                    $date_to    = $params['date_to'];
                    $role       = $params['role'];

                    $student       = $this->student_model->get($student_id);
                    $student_login = $this->user_model->getUserLoginDetails($student_id);

                    $user_role_id = $student_login['id'];
                    if ($role == "parent") {
                        $user_role_id = $params['user_id'];
                    }
                    $attendence_percentage = 0;
                    $resp                  = array('status' => 200, 'error' => '', 'message' => 'detail found');
                    $student_session_id    = $student->student_session_id;
                    $student_attendence    = $this->attendencetype_model->getAttendencePercentage($date_from, $date_to, $student_session_id);
                    $student_homework      = $this->homework_model->getStudentHomeworkPercentage($student_session_id, $student->class_id, $student->section_id);
                    if ($student_attendence->present_attendance > 0 && $student_attendence->total_count > 0) {

                        $attendence_percentage = $student_attendence->present_attendance / $student_attendence->total_count * 100;
                    }

                    $school_setting                        = $this->setting_model->getSchoolDetail();
                    $resp['attendence_type']               = $school_setting->attendence_type;
                    $resp['class_id']                      = $student->class_id;
                    $resp['section_id']                    = $student->section_id;
                    $resp['student_attendence_percentage'] = round($attendence_percentage);
                    $resp['student_homework_incomplete']   = round($student_homework->total_homework - $student_homework->completed);
                    $eventcount     =   $this->event_model->incompleteStudentTaskCounter($user_role_id);
                   
                    if(!empty($eventcount)){
                        $resp['student_incomplete_task']       = count($eventcount);
                    }else{
                        $resp['student_incomplete_task']       = 0;
                    }
                    $resp['public_events']                 = $this->event_model->getPublicEvents($user_role_id, $date_from, $date_to);

                    foreach ($resp['public_events'] as &$ev_tsk_value) {
                        $evt_array = array();
                        if ($ev_tsk_value->event_type == "public") {
                            $start = strtotime($ev_tsk_value->start_date);
                            $end   = strtotime($ev_tsk_value->end_date);

                            for ($st = $start; $st <= $end; $st += 86400) {
                                if ($st >= strtotime($date_from) && $st <= strtotime($date_to)) {

                                    $date_list[date('Y-m-d', $st)] = date('Y-m-d', $st);
                                    $evt_array[]                   = date('Y-m-d', $st);
                                }
                            }

                            $ev_tsk_value->events_lists = implode(",", $evt_array);
                        } elseif ($ev_tsk_value->event_type == "task") {

                            $date_list[date('Y-m-d', strtotime($ev_tsk_value->start_date))] = date('Y-m-d', strtotime($ev_tsk_value->start_date));
                            $evt_array[]                                                    = date('Y-m-d', strtotime($ev_tsk_value->start_date));
                            $ev_tsk_value->events_lists                                     = implode(",", $evt_array);
                        }
                    }
                    $resp['date_lists'] = implode(",", $date_list);

                    json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getTask()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $params  = json_decode(file_get_contents('php://input'), true);
                    $user_id = $params['user_id'];
                    $resp    = array('status' => 200, 'error' => '', 'message' => 'detail found');

                    $resp['tasks'] = $this->event_model->getTask($user_id);
                    json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getDocument()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $_POST       = json_decode(file_get_contents("php://input"), true);
                    $student_id  = $this->input->post('student_id');
                    $student_doc = array('status' => 200, 'error' => '', 'message' => 'detail found');
                    $student_doc = $this->student_model->getstudentdoc($student_id);
                    json_output($response['status'], $student_doc);
                }
            }
        }
    }

    public function getHomework()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $_POST                = json_decode(file_get_contents("php://input"), true);
                    $student_id           = $this->input->post('student_id');
                    $result               = $this->student_model->get($student_id);
                    $class_id             = $result->class_id;
                    $section_id           = $result->section_id;
                    $section_id           = $result->section_id;
                    $homeworklist         = $this->homework_model->getStudentHomework($class_id, $section_id, $result->student_session_id);
                    $data                   = array(
                        'status' => 200, 'message' => 'HomeWork Details.'
                        
                        );
                    $data["homeworklist"] = $homeworklist;
                    $data["class_id"]     = $class_id;
                    $data["section_id"]   = $section_id;
                    $data["subject_id"]   = "";

                    json_output($response['status'], $data);
                }
            }
        }
    }

    public function addaa()
    {

        $method = $this->input->server('REQUEST_METHOD');

        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $data = $this->input->POST();

                    $this->form_validation->set_data($data);
                    $this->form_validation->set_error_delimiters('', '');
                    $this->form_validation->set_rules('student_id', 'Student', 'required|trim');
                    $this->form_validation->set_rules('homework_id', 'Homework', 'required|trim');
                    $this->form_validation->set_rules('message', 'Message', 'required|trim');

                    if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                        $this->form_validation->set_rules('file', 'File', 'callback_handle_upload_file');
                    }

                    if ($this->form_validation->run() == false) {

                        $sss = array(
                            'student_id'  => form_error('student_id'),
                            'homework_id' => form_error('homework_id'),
                            'message'     => form_error('message'),
                            'file'        => form_error('file'),
                        );
                        $array = array('status' => 200, 'error' => $sss);
                    } else {
                        //==================
                        $upload_path = $this->config->item('upload_path') . "/homework/assignment/";

                        if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                            $time     = md5($_FILES["file"]['name'] . microtime());
                            $fileInfo = pathinfo($_FILES["file"]["name"]);
                            $img_name = $time . '.' . $fileInfo['extension'];
                            move_uploaded_file($_FILES["file"]["tmp_name"], $upload_path . $img_name);
                            $data_insert = array(
                                'homework_id' => $this->input->post('homework_id'),
                                'student_id'  => $this->input->post('student_id'),
                                'message'     => $this->input->post('message'),
                                'docs'        => $img_name,
                                'file_name'   => $_FILES['file']['name'],
                            );
                            $this->homework_model->add($data_insert);
                        }

                        $array = array('status' => 200, 'msg' => 'Success');
                    }
                    json_output(200, $array);
                }
            }
        }
    }

    public function getTimeline()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $params     = json_decode(file_get_contents('php://input'), true);
                    $student_id = $params['studentId'];
                    $timeline = array('status' => 200, 'error' => '', 'message' => 'detail found');
                    $timeline   = $this->timeline_model->getTimeline($student_id);
                    json_output($response['status'], $timeline);
                }
            }
        }
    }

    public function getOnlineExam()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $params     = json_decode(file_get_contents('php://input'), true);
                    $student_id = $params['student_id'];
                    $result     = $this->student_model->get($student_id);
                    $respdata   = $this->onlineexam_model->getStudentexam($result->student_session_id);

                    $question = array();
                    foreach ($respdata as $key => $value) {

                        $question = $this->onlineexam_model->getquestiondetails($value->id);
                        if (!empty($question)) {
                            $value->total_question    = $question->total_question;
                            $value->total_descriptive = $question->total_descriptive;
                        } else {
                            $value->total_question    = "0";
                            $value->total_descriptive = "0";
                        }
                        $resp = array('status' => 200, 'error' => '', 'message' => 'detail found');
                        $resp['onlineexam'][] = $value;
                    }

                    json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getOnlineExamQuestion()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $params                        = json_decode(file_get_contents('php://input'), true);
                    $student_id                    = $params['student_id'];
                    $recordid                      = $params['online_exam_id'];
                    $result                        = $this->student_model->get($student_id);
                    $onlineexam                    = array();
                    $exam                          = $this->onlineexam_model->get($recordid);
                    $onlineexam_student            = $this->onlineexam_model->examstudentsID($result->student_session_id, $exam['id']);
                    $exam['onlineexam_student_id'] = $onlineexam_student->id;
                    $exam['student_session_id']    = $onlineexam_student->student_session_id;
                    $exam['is_submitted']          = $onlineexam_student->is_submitted;

                    $exam['questions']                        = $this->onlineexam_model->getExamQuestions($exam['id'], $exam['is_random_question']);
                    $getStudentAttemts                        = $this->onlineexam_model->getStudentAttemts($onlineexam_student->id);
                    $onlineexam['exam_result_publish_status'] = $exam['publish_result'];
                    $onlineexam['exam_attempt_status']        = 0;

                    if (($exam['auto_publish_date'] != "0000-00-00" && $exam['auto_publish_date'] != null) && strtotime(date('Y-m-d')) >= strtotime($exam['auto_publish_date'])) {
                        $question_status                          = 1;
                        $onlineexam['exam_result_publish_status'] = 1;

                    } else if (strtotime(date('Y-m-d H:i:s')) >= strtotime(date($exam['exam_to']))) {

                        $question_status                   = 1;
                        $onlineexam['exam_attempt_status'] = 1;
                    } else if ($exam['attempt'] > $getStudentAttemts) {

                        $this->onlineexam_model->addStudentAttemts(array('onlineexam_student_id' => $onlineexam_student->id));
                    } else {

                        $question_status                   = 1;
                        $onlineexam['exam_attempt_status'] = 1;
                    }

                    $exam['status']             = $onlineexam;
                    $total_remaining_seconds    = round((strtotime($exam['exam_to']) - strtotime(date('Y-m-d H:i:s'))) / 3600 * 60 * 60, 1);
                    $exam_duration              = ($total_remaining_seconds < getSecondsFromHMS($exam['duration'])) ? getHMSFromSeconds($total_remaining_seconds) : $exam['duration'];
                    $exam['remaining_duration'] = $exam_duration;					
					$total_descriptive=0;
					$question = $this->onlineexam_model->getquestiondetails($exam['id']);
                        if (!empty($question)) {
                            $total_descriptive = $question->total_descriptive;
                        } else {
                            $total_descriptive = "0";
                        }
                        $exam['descriptive'] =$total_descriptive;				
					
                    json_output($response['status'], array('exam' => $exam));
                }
            }
        }
    }

    public function getOnlineExamResult()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $params                = json_decode(file_get_contents('php://input'), true);
                    $onlineexam_student_id = $params['onlineexam_student_id'];
                    $exam_id               = $params['exam_id'];

                    $exam = $this->onlineexam_model->get($exam_id);
                    
                   // print_r($exam);exit;

                    $resp['question_result'] = $this->onlineexam_model->getResultByStudent($onlineexam_student_id, $exam_id);

                    $onlineexamStudent      = $this->onlineexam_model->getExamByOnlineexamStudent($onlineexam_student_id);
                    $dispaly_negative_marks = $exam['is_neg_marking'];
                    $exam_total_scored      = 0;
                    $exam_total_marks       = 0;
                    $exam_total_neg_marks   = 0;

                    $correct_ans       = 0;
                    $wrong_ans         = 0;
                    $not_attempted     = 0;
                    $total_question    = 0;
                    $total_descriptive = 0;
                    if (!empty($resp['question_result'])) {
                        $total_question = count($resp['question_result']);

                        foreach ($resp['question_result'] as $result_key => $question_value) {

                            $total_marks_json  = $this->getMarks($question_value);
                            $total_marks_array = (json_decode($total_marks_json));
                            $exam_total_marks  = $exam_total_marks + $total_marks_array->get_marks;
                            $exam_total_scored = $exam_total_scored + $total_marks_array->scr_marks;
                            if ($question_value->question_type == "descriptive") {
                                $total_descriptive++;
                            }

                            if ($question_value->select_option != null) {
                                if ($question_value->question_type == "singlechoice" || $question_value->question_type == "true_false") {
                                    if ($question_value->select_option == $question_value->correct) {
                                        $correct_ans++;
                                    } else {
                                        $exam_total_neg_marks = $exam_total_neg_marks + $question_value->neg_marks;
                                        $wrong_ans++;
                                    }
                                } elseif ($question_value->question_type == "multichoice") {

                                    if ($this->array_equal(json_decode($question_value->correct), json_decode($question_value->select_option))) {
                                        $correct_ans++;
                                    } else {
                                        $exam_total_neg_marks = $exam_total_neg_marks + $question_value->neg_marks;
                                        $wrong_ans++;
                                    }

                                }
                            } else {
                                $not_attempted++;
                            }

                        }
                    }
                    if (!$dispaly_negative_marks) {
                        $exam_total_neg_marks = 0;
                    }
					if($exam_total_marks > 0){
                        $score   =  number_format(((($exam_total_scored - $exam_total_neg_marks) * 100) / $exam_total_marks), 2, '.', '');
                    }else{
                        $score   =  0;
                    }
                    $exam['rank']                 = $onlineexamStudent->rank;
                    $exam['correct_ans']          = $correct_ans;
                    $exam['wrong_ans']            = $wrong_ans;
                    $exam['not_attempted']        = $not_attempted;
                    $exam['total_question']       = $total_question;
                    $exam['total_descriptive']    = $total_descriptive;
                    $exam['exam_total_marks']     = $exam_total_marks;
                    $exam['exam_total_neg_marks'] = $exam_total_neg_marks;
                    $exam['exam_total_scored']    = $exam_total_scored - $exam_total_neg_marks;
                    $exam['score']                = $score;
                    $resp['exam']                 = $exam;
                    
               //     print_r($exam);exit;
                    
               //    $resp = array('status' => 200, 'error' => '', 'message' => 'detail found');
                    json_output($response['status'], array('status' => 200, 'error' => '', 'message' => 'detail found','result' => $resp));
                }
            }
        }
    }

    public function saveOnlineExam()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $question_rows = (json_decode($this->input->post('rows')));
                    foreach ($question_rows as $question_key => $question_value) {
                        if ($question_value->question_type == "descriptive") {
                            $qid = $question_value->onlineexam_question_id;
             if ((isset($_FILES["attachment_" . $qid]) && !empty($_FILES["attachment_" . $qid]['name']))) {
//===============
                $file_name        = $_FILES["attachment_" . $qid]["name"];
                $fileInfo         = pathinfo($_FILES["attachment_" . $qid]["name"]);
                $upload_file_name = time() . uniqid(rand()) . '.' . $fileInfo['extension'];
                 $upload_path = $this->config->item('upload_path') . "/onlinexam_images/";

               move_uploaded_file($_FILES["attachment_" . $qid]["tmp_name"], $upload_path.$upload_file_name);
                $question_value->attachment_name        = $file_name;
                $question_value->attachment_upload_name = $upload_file_name;
                                //================
                            }else{
                                    $question_value->attachment_name        = "";
                $question_value->attachment_upload_name = "";    
                            }
                        }else{
                            $question_value->attachment_name        = "";
                $question_value->attachment_upload_name = "";
                        }

                         unset($question_value->question_type);
                    }

                    $onlineexam_student_id = $this->input->post('onlineexam_student_id');
                    
                    $resp = array();
                    if (!empty($question_rows)) {
                        $save_result = array();

                        $insert_result = $this->onlineexam_model->add($question_rows, $onlineexam_student_id);
                        $this->onlineexam_model->updateExamSubmitted($onlineexam_student_id);
                        if ($insert_result == 1) {
                            $resp = array('status' => 1, 'msg' => 'record inserted');
                        } else if ($insert_result == 2) {
                            $resp = array('status' => 2, 'msg' => 'record already submitted');
                        } else if ($insert_result == 0) {
                            $resp = array('status' => 2, 'msg' => 'something wrong');
                        }
                    } else {
                        $this->onlineexam_model->updateExamSubmitted($onlineexam_student_id);
                        $resp = array('status' => 200, 'msg' => 'record inserted');
                    }

                    json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getExamList()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $data = array('status' => 200, 'error' => '', 'message' => 'detail found');
                    $params               = json_decode(file_get_contents('php://input'), true);
                    $student_id           = $params['student_id'];
                    $result               = $this->student_model->get($student_id);
                    $examSchedule         = $this->examgroup_model->studentExams($result->student_session_id);
                    $data['examSchedule'] = $examSchedule;
                    json_output($response['status'], $data);
                }
            }
        }
    }

    public function getExamSchedule()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $params                = json_decode(file_get_contents('php://input'), true);
                    $exam_id               = $params['exam_group_class_batch_exam_id'];
                    $exam_subjects         = $this->examgroup_model->getExamSubjects($exam_id);
                    $data = array('status' => 200, 'error' => '', 'message' => 'detail found');
                    $data['exam_subjects'] = $exam_subjects;
                    json_output($response['status'], $data);
                }
            }
        }
    }

    public function getNotifications()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $params = json_decode(file_get_contents('php://input'), true);
                    $type   = $params['type'];
                    $resp = array('status' => 200, 'error' => '', 'message' => 'detail found');
                    $resp   = $this->webservice_model->getNotifications($type);
                    json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getSubjectList()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $params     = json_decode(file_get_contents('php://input'), true);
                    $class_id   = $params['class_id'];
                    $section_id = $params['section_id'];
                    $resp       = $this->subjecttimetable_model->getSubjects($class_id, $section_id);
                    $subjects   = array();
                    if (!empty($resp)) {

                        foreach ($resp as $res_key => $res_value) {

                            $subjects[] = array(
                                'subject_id' => $res_value->subject_id,
                                'subject'    => $res_value->subject_name,
                                'code'       => $res_value->code,
                                'type'       => $res_value->type,
                            );
                        }
                    }

                    json_output($response['status'], array('result_list' => $subjects));
                }
            }
        }
    }

    public function getSubjectTimetable()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $params     = json_decode(file_get_contents('php://input'), true);
                    $class_id   = $params['class_id'];
                    $section_id = $params['section_id'];
                    $subject_id = $params['subject_id'];
                    $resp       = $this->subjecttimetable_model->getSubjectTimetable($class_id, $section_id, $subject_id);
                    $subjects   = array();

                    json_output($response['status'], array('result_list' => $resp));
                }
            }
        }
    }

    public function getTeachersList()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $params     = json_decode(file_get_contents('php://input'), true);
                    $user_id    = $params['user_id'];
                    $class_id   = $params['class_id'];
                    $section_id = $params['section_id'];
                    $resp       = $this->subjecttimetable_model->getTeachers($class_id, $section_id);

                    $class_teacher = array();
                    if (!empty($resp)) {

                        foreach ($resp as $res_key => $res_value) {
                            $is_duplicate = false;
                            $rating       = $this->subjecttimetable_model->user_rating($user_id, $res_value->staff_id);
                            $rate         = 0;
                            if ($rating) {
                                $rate = $rating->rate;
                            }

                            if (is_null($res_value->day)) {
                                $total_row = checkDuplicateTeacher($resp, $res_value->staff_id);
                                if ($total_row > 1) {
                                    $is_duplicate = true;
                                }
                            }
                            if (!$is_duplicate) {
                                if (array_key_exists($res_value->staff_id, $class_teacher)) {

                                    $class_teacher[$res_value->staff_id]['subjects'][] = array(
                                        'subject_id'   => $res_value->subject_id,
                                        'subject_name' => $res_value->subject_name,
                                        'code'         => $res_value->code,
                                        'type'         => $res_value->type,
                                        'day'          => $res_value->day,
                                        'time_from'    => $res_value->time_from,
                                        'time_to'      => $res_value->time_to,
                                        'room_no'      => $res_value->room_no,
                                    );
                                } else {

                                    $class_teacher[$res_value->staff_id] = array(
                                        'employee_id'      => $res_value->employee_id,
                                        'staff_id'         => $res_value->staff_id,
                                        'staff_name'       => $res_value->staff_name,
                                        'staff_surname'    => $res_value->staff_surname,
                                        'contact_no'       => $res_value->contact_no,
                                        'email'            => $res_value->email,
                                        'class_teacher_id' => $res_value->class_teacher_id,
                                        'rate'             => $rate,
                                        'subjects'         => array(),
                                    );
                                    if (!is_null($res_value->day)) {
                                        $class_teacher[$res_value->staff_id]['subjects'][] = array(
                                            'subject_id'   => $res_value->subject_id,
                                            'subject_name' => $res_value->subject_name,
                                            'code'         => $res_value->code,
                                            'type'         => $res_value->type,
                                            'day'          => $res_value->day,
                                            'time_from'    => $res_value->time_from,
                                            'time_to'      => $res_value->time_to,
                                            'room_no'      => $res_value->room_no,
                                        );
                                    }
                                }
                            }
                        }
                    }
                    json_output($response['status'], array('status' => 200, 'message' => 'Teacher List Found.','result_list' => $class_teacher));
                }
            }
        }
    }

    public function getClassTimetable()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $params     = json_decode(file_get_contents('php://input'), true);
                    $user_id    = $params['user_id'];
                    $class_id   = $params['class_id'];
                    $section_id = $params['section_id'];
                    $resp       = $this->subjecttimetable_model->getTeachers($class_id, $section_id);

                    $class_teacher = array();
                    if (!empty($resp)) {

                        foreach ($resp as $res_key => $res_value) {
                            $is_duplicate = false;
                            $rating       = $this->subjecttimetable_model->user_rating($user_id, $res_value->staff_id);
                            $rate         = 0;
                            if ($rating) {
                                $rate = $rating->rate;
                            }

                            if (is_null($res_value->day)) {
                                $total_row = checkDuplicateTeacher($resp, $res_value->staff_id);
                                if ($total_row > 1) {
                                    $is_duplicate = true;
                                }
                            }
                            if (!$is_duplicate) {

                                $class_teacher[] = array(
                                    'staff_id'         => $res_value->staff_id,
                                    'staff_name'       => $res_value->staff_name,
                                    'staff_surname'    => $res_value->staff_surname,
                                    'contact_no'       => $res_value->contact_no,
                                    'class_teacher_id' => $res_value->class_teacher_id,
                                    'subject_id'       => $res_value->subject_id,
                                    'subject_name'     => $res_value->subject_name,
                                    'code'             => $res_value->code,
                                    'type'             => $res_value->type,
                                    'day'              => $res_value->day,
                                    'time_from'        => $res_value->time_from,
                                    'time_to'          => $res_value->time_to,
                                    'room_no'          => $res_value->room_no,
                                    'rate'             => $rate,
                                );
                            }
                        }
                    }

                    json_output($response['status'], array('result_list' => $class_teacher));
                }
            }
        }
    }

    public function getTeacherSubject()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $params = json_decode(file_get_contents('php://input'), true);

                    $staff_id   = $params['staff_id'];
                    $class_id   = $params['class_id'];
                    $section_id = $params['section_id'];
                    $resp       = $this->subjecttimetable_model->getTeacherSubject($class_id, $section_id, $staff_id);

                    json_output($response['status'], array('status' => 200, 'message' => 'Teacher Subject Found.','result_list' => $resp));
                }
            }
        }
    }

    public function addStaffRating()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {

                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $params = json_decode(file_get_contents('php://input'), true);
                    $data   = array(
                        'user_id'  => $params['user_id'],
                        'staff_id' => $params['staff_id'],
                        'rate'     => $params['rate'],
                        'comment'  => $params['comment'],
                        'role'     => 'student',
                    );

                    $insert_result = $this->subjecttimetable_model->add_rating($data);
                    if ($insert_result) {
                        $resp = array('status' => 1, 'msg' => 'inserted');
                    } else {
                        $resp = array('status' => 0, 'msg' => 'something wrong or already submitted');
                    }

                    json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getLibraryBooks()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'GET') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {

                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $resp = $this->webservice_model->getLibraryBooks();
                    json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getLibraryBookIssued()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    
                    

                    $params      = json_decode(file_get_contents('php://input'), true);
                    $studentId   = $params['studentId'];
                    $member_type = "student";
                    $resp        = $this->librarymember_model->checkIsMember($member_type, $studentId);

                    json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getTransportroute()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $listroute                   = array(
                        'status' => 200, 'message' => 'Book Issued'
                        
                        );
                    $params       = json_decode(file_get_contents('php://input'), true);
                    $student_id   = $params['student_id'];
                    $student      = $this->student_model->get($student_id);
                    $vec_route_id = $student->vehroute_id;
                    $listroute    = $this->vehroute_model->listroute();

                    if ($vec_route_id != "") {
                        if (!empty($listroute)) {
                            foreach ($listroute as $listroute_key => $listroute_value) {

                                if (!empty($listroute_value['vehicles'])) {
                                    foreach ($listroute_value['vehicles'] as $route_key => $route_value) {
                                        if ($route_value->vec_route_id == $vec_route_id) {
                                            $route_value->assigned = "yes";
                                            break;
                                        } else {
                                            $route_value->assigned = "no";
                                        }
                                    }
                                }
                            }
                        }
                    }

                    json_output($response['status'], $listroute);
                }
            }
        }
    }

    public function getHostelList()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'GET') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $resp = $this->webservice_model->getHostelList();
                    json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getHostelDetails()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $params     = json_decode(file_get_contents('php://input'), true);
                    $hostelId   = $params['hostelId'];
                    $student_id = $params['student_id'];
                    $resp       = $this->webservice_model->getHostelDetails($hostelId, $student_id);
                    json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getDownloadsLinks()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $params    = json_decode(file_get_contents('php://input'), true);
                    $tag       = $params['tag'];
                    $classId   = $params['classId'];
                    $sectionId = $params['sectionId'];
                    
                    
                    $resp      = $this->webservice_model->getDownloadsLinks($classId, $sectionId, $tag);
                    json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getTransportVehicleDetails()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $params    = json_decode(file_get_contents('php://input'), true);
                    $vehicleId = $params['vehicleId'];
                    $resp      = $this->webservice_model->getTransportVehicleDetails($vehicleId);
                    json_output($response['status'], $resp);
                }
            }
        }
    }

    public function getAttendenceRecords1()
    {
        $method = $this->input->server('REQUEST_METHOD');

        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    ///===================
                    $_POST = json_decode(file_get_contents("php://input"), true);

                    $year                 = $this->input->post('year');
                    $month                = $this->input->post('month');
                    $student_id           = $this->input->post('student_id');
                    $student              = $this->student_model->get($student_id);
                    $student_session_id   = $student['student_session_id'];
                    $result               = array();
                    $new_date             = "01-" . $month . "-" . $year;
                    $totalDays            = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                    $first_day_this_month = date('01-m-Y');
                    $fst_day_str          = strtotime(date($new_date));
                    $array                = array();
                    for ($day = 2; $day <= $totalDays; $day++) {
                        $fst_day_str        = ($fst_day_str + 86400);
                        $date               = date('Y-m-d', $fst_day_str);
                        $student_attendence = $this->attendencetype_model->getStudentAttendence($date, $student_session_id);
                        if (!empty($student_attendence)) {
                            $s         = array();
                            $s['date'] = $date;
                            $type      = $student_attendence->type;
                            $s['type'] = $type;
                            $array[]   = $s;
                        }
                    }
                    $data['status'] = 200;
                    $data['data']   = $array;
                     $data =array('status' => 200, 'error' => '', 'message' => 'detail found');
                    json_output($response['status'], $data);

                    //======================
                }
            }
        }
    }

    public function getAttendenceRecords()
    {
        $method = $this->input->server('REQUEST_METHOD');

        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $school_setting = $this->setting_model->getSchoolDetail();

                    $_POST                   = json_decode(file_get_contents("php://input"), true);
                    $year                    = $this->input->post('year');
                    $month                   = $this->input->post('month');
                    $student_id              = $this->input->post('student_id');
                    $date                    = $this->input->post('date');
                    $student                 = $this->student_model->get($student_id);
                    $student_session_id      = $student->student_session_id;
                    $data                    = array('status' => 200, 'error' => '', 'message' => 'detail found');
                    $data['attendence_type'] = $school_setting->attendence_type;
                    if ($school_setting->attendence_type) {
                        $timestamp         = strtotime($date);
                        $day               = date('l', $timestamp);
                        $attendence_result = $this->attendencetype_model->studentAttendanceByDate($student->class_id, $student->section_id, $day, $date, $student_session_id);
                        $data['data']      = $attendence_result;
                    } else {

                        $result               = array();
                        $new_date             = "01-" . $month . "-" . $year;
                        $totalDays            = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                        $first_day_this_month = date('01-m-Y');
                        $fst_day_str          = strtotime(date($new_date));
                        $array                = array();

                        for ($day = 1; $day <= $totalDays; $day++) {
                            $date               = date('Y-m-d', $fst_day_str);
                            $student_attendence = $this->attendencetype_model->getStudentAttendence($date, $student_session_id);
                            if (!empty($student_attendence)) {
                                $s         = array();
                                $s['date'] = $date;
                                $type      = $student_attendence->type;
                                $s['type'] = $type;
                                $array[]   = $s;
                            }
                            $fst_day_str = ($fst_day_str + 86400);
                        }

                        $data['data'] = $array;
                        
                    }

                    json_output($response['status'], $data);

                    //======================
                }
            }
        }
    }

    public function examSchedule()
    {

        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $_POST                = json_decode(file_get_contents("php://input"), true);
                    $student_id           = $this->input->post('student_id');
                    $data                 = array();
                    $stu_record           = $this->student_model->getRecentRecord($student_id);
                    $data['status']       = "200";
                    $data['class_id']     = $stu_record['class_id'];
                    $data['section_id']   = $stu_record['section_id'];
                    $examSchedule         = $this->examschedule_model->getExamByClassandSection($data['class_id'], $data['section_id']);
                    $data['examSchedule'] = $examSchedule;
                    json_output($response['status'], $data);
                }
            }
        }
    }

    public function getexamscheduledetail()
    {

        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $_POST = json_decode(file_get_contents("php://input"), true);
                    $this->form_validation->set_data($_POST);
                    $exam_id      = $this->input->post('exam_id');
                    $section_id   = $this->input->post('section_id');
                    $class_id     = $this->input->post('class_id');
                    $examSchedule = $this->examschedule_model->getDetailbyClsandSection($class_id, $section_id, $exam_id);
                    json_output($response['status'], $examSchedule);
                }
            }
        }
    }

    public function getlessonplan()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $_POST = json_decode(file_get_contents("php://input"), true);
                    $this->form_validation->set_data($_POST);
                    $student_id = $this->input->post('student_id');
                    $date_from  = $this->input->post('date_from');
                    $date_to    = $this->input->post('date_to');
                    $student    = $this->student_model->get($student_id);
                    $class_id   = $student->class_id;
                    $section_id = $student->section_id;
                    $result     = $this->syllabus_model->getLessonPlanBwDate($class_id, $section_id, $date_from, $date_to);

                    $syllabus['data'] = array();
                    $start            = strtotime($date_from);
                    $end              = strtotime($date_to);
                    for ($i = $start; $i <= $end; $i += 86400) {
                        $syllabus['data'][date('l', $i)] = array();
                    }

                    if (!empty($result)) {
                        foreach ($result as $result_key => $result_value) {
                            $syllabus['data'][date('l', strtotime($result_value->date))][] = $result_value;
                        }
                    }
                    $data       = array(
                        'status' => 200, 'message' => 'Lesson Plan Found.'
                        
                        );
                    $data['timetable'] = $syllabus['data'];
                   // $data['status']    = "200";
                    json_output($response['status'], $data);
                }
            }
        }
    }

    public function getsyllabus()
    {

        $method = $this->input->server('REQUEST_METHOD');

        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $_POST = json_decode(file_get_contents("php://input"), true);
                    $this->form_validation->set_data($_POST);
                    $subject_syllabus_id = $this->input->post('subject_syllabus_id');
                    $syllabus['data']    = $this->syllabus_model->getSyllabusDetail($subject_syllabus_id);
                    json_output($response['status'], $syllabus);
                }
            }
        }
    }

    public function getsyllabussubjects()
    {

        $method = $this->input->server('REQUEST_METHOD');

        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $_POST = json_decode(file_get_contents("php://input"), true);
                    $this->form_validation->set_data($_POST);
                    $subjects       = array(
                        'status' => 200, 'message' => 'Syllabus Subject Found.'
                        
                        );
                    $student_id           = $this->input->post('student_id');
                    $stu_record           = $this->student_model->getRecentRecord($student_id);
                    $data['class_id']     = $stu_record['class_id'];
                    $data['section_id']   = $stu_record['section_id'];
                    $subjects['subjects'] = $this->syllabus_model->getSyllabusSubjects($data['class_id'], $data['section_id']);
                    json_output($response['status'], $subjects);
                }
            }
        }
    }

    public function getSubjectsLessons()
    {

        $method = $this->input->server('REQUEST_METHOD');

        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $_POST = json_decode(file_get_contents("php://input"), true);
                    $this->form_validation->set_data($_POST);
                    $subject_group_subject_id        = $this->input->post('subject_group_subject_id');
                    $subject_group_class_sections_id = $this->input->post('subject_group_class_sections_id');

                    $subjects = $this->syllabus_model->getSubjectsLesson($subject_group_subject_id, $subject_group_class_sections_id);
                    json_output($response['status'], $subjects);
                }
            }
        }
    }

    public function fees()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $data       = array(
                        'status' => 200, 'message' => 'Fee Detail Found.'
                        
                        );
                    $pay_method = $this->paymentsetting_model->getActiveMethod();
                    $_POST      = json_decode(file_get_contents("php://input"), true);
                    $student_id = $this->input->post('student_id');
                    $student    = $this->student_model->get($student_id);

                    $student_due_fee        = $this->studentfeemaster_model->getStudentFees($student->student_session_id);
                    $student_discount_fee   = $this->feediscount_model->getStudentFeesDiscount($student->student_session_id);
                    $init_amt               = 0;
                    $grand_amt              = 0;
                    $grand_total_paid       = 0;
                    $grand_total_discount   = 0;
                    $grand_total_fine       = 0;
                    $fees_fine_amount       = 0;
                    $total_fees_fine_amount = 0;

                    if (!empty($student_due_fee)) {

                        foreach ($student_due_fee as $student_due_fee_key => $student_due_fee_value) {

                            foreach ($student_due_fee_value->fees as $each_fees_key => $each_fees_value) {

                                $amt                                     = 0;
                                $total_paid                              = 0;
                                $total_discount                          = 0;
                                $total_fine                              = 0;
                                $each_fees_value->total_amount_paid      = number_format((float) $amt, 2, '.', '');
                                $each_fees_value->total_amount_discount  = number_format((float) $amt, 2, '.', '');
                                $each_fees_value->total_amount_fine      = number_format((float) $amt, 2, '.', '');
                                $each_fees_value->total_amount_display   = number_format((float) $amt, 2, '.', '');
                                $each_fees_value->total_amount_remaining = number_format((float) $each_fees_value->amount, 2, '.', '');
                                $each_fees_value->status                 = 'unpaid';

                                $grand_amt = $grand_amt + $each_fees_value->amount;
                                if (($each_fees_value->due_date != "0000-00-00" && $each_fees_value->due_date != null) && (strtotime($each_fees_value->due_date) < strtotime(date('Y-m-d')))) {
                                    $fees_fine_amount       = $each_fees_value->fine_amount;
                                    $total_fees_fine_amount = $total_fees_fine_amount + $each_fees_value->fine_amount;
                                }
                                $each_fees_value->fees_fine_amount = $fees_fine_amount;

                                if (is_string($each_fees_value->amount_detail) && is_array(json_decode($each_fees_value->amount_detail, true)) && (json_last_error() == JSON_ERROR_NONE)) {
                                    $fess_list = json_decode($each_fees_value->amount_detail);

                                    foreach ($fess_list as $fee_key => $fee_value) {

                                        $grand_total_paid = $grand_total_paid + $fee_value->amount;
                                        $total_paid       = $total_paid + $fee_value->amount;

                                        $grand_total_discount = $grand_total_discount + $fee_value->amount_discount;
                                        $total_discount       = $total_discount + $fee_value->amount_discount;

                                        $grand_total_fine = $grand_total_fine + $fee_value->amount_fine;
                                        $total_fine       = $total_fine + $fee_value->amount_fine;
                                    }

                                    $each_fees_value->total_amount_paid     = number_format((float) $total_paid, 2, '.', '');
                                    $each_fees_value->total_amount_discount = number_format((float) $total_discount, 2, '.', '');
                                    $each_fees_value->total_amount_fine     = number_format((float) $total_fine, 2, '.', '');

                                    $each_fees_value->total_amount_display   = number_format((float) ($total_paid + $total_discount), 2, '.', '');
                                    $each_fees_value->total_amount_remaining = number_format((float) ($each_fees_value->amount - (($total_paid + $total_discount))), 2, '.', '');

                                    if ($each_fees_value->total_amount_remaining <= '0.00') {
                                        $each_fees_value->status = 'paid';
                                    } elseif ($each_fees_value->total_amount_remaining == number_format((float) $each_fees_value->amount, 2, '.', '')) {
                                        $each_fees_value->status = 'unpaid';
                                    } else {
                                        $each_fees_value->status = 'partial';
                                    }
                                }

                                if (($each_fees_value->amount - ($each_fees_value->total_amount_paid + $each_fees_value->total_amount_discount)) == 0) {
                                    $each_fees_value->status = 'paid';
                                }
                            }
                        }
                    }

                    $grand_fee = array('amount' => number_format((float) $grand_amt, 2, '.', ''), 'amount_discount' => number_format((float) $grand_total_discount, 2, '.', ''), 'amount_fine' => number_format((float) $grand_total_fine, 2, '.', ''), 'amount_paid' => number_format((float) $grand_total_paid, 2, '.', ''), 'amount_remaining' => number_format((float) ($grand_amt - ($grand_total_paid + $grand_total_discount)), 2, '.', ''), 'fee_fine' => $total_fees_fine_amount);

                    $data['pay_method']           = empty($pay_method) ? 0 : 1;
                    $data['student_due_fee']      = $student_due_fee;
                    $data['student_discount_fee'] = $student_discount_fee;
                    $data['grand_fee']            = $grand_fee;

                    json_output($response['status'], $data);
                }
            }
        }
    }

    public function class_schedule()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $_POST      = json_decode(file_get_contents("php://input"), true);
                    $student_id = $this->input->post('student_id');
                    $student    = $this->student_model->get($student_id);
                    $class_id   = $student->class_id;
                    $section_id = $student->section_id;

                    $days        = $this->customlib->getDaysname();
                    $days_record = array();
                    foreach ($days as $day_key => $day_value) {

                        $days_record[$day_key] = $this->subjecttimetable_model->getSubjectByClassandSectionDay($class_id, $section_id, $day_key);
                    }
                    $data       = array(
                        'status' => 200, 'message' => 'Class Schedule Found.'
                        
                        );
                    $data['timetable'] = $days_record;
                    
                    json_output($response['status'], $data);
                }
            }
        }
    }

    public function getExamResult()
    {

        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $_POST                          = json_decode(file_get_contents("php://input"), true);
                    $exam_group_class_batch_exam_id = $this->input->post('exam_group_class_batch_exam_id');
                    $student_id                     = $this->input->post('student_id');
                    $student                        = $this->student_model->get($student_id);

                    $dt          = array();
                    $exam_result = $this->examgroup_model->searchExamResult($student->student_session_id, $exam_group_class_batch_exam_id, true, true);

                    $exam_grade = $this->grade_model->getGradeDetails();

                    if (!empty($exam_result->exam_result)) {
                        $exam                                 = new stdClass;
                        $exam->exam_group_class_batch_exam_id = $exam_result->exam_group_class_batch_exam_id;
                        $exam->exam_group_id                  = $exam_result->exam_group_id;
                        $exam->exam                           = $exam_result->exam;
                        $exam->exam_group                     = $exam_result->name;
                        $exam->description                    = $exam_result->description;
                        $exam->exam_type                      = $exam_result->exam_type;
                        $exam->subject_result                 = array();
                        $exam->total_max_marks                = 0;
                        $exam->total_get_marks                = 0;
                        $exam->total_exam_points              = 0;
                        $exam->exam_quality_points            = 0;
                        $exam->exam_credit_hour               = 0;
                        $exam->exam_credit_hour               = 0;
                        $exam->exam_result_status             = "pass";
                        if ($exam_result->exam_result['exam_connection'] == 0) {
                            $exam->is_consolidate = 0;
                            foreach ($exam_result->exam_result['result'] as $exam_result_key => $exam_result_value) {

                                $subject_array = array();
                                if ($exam_result_value->attendence != "present") {
                                    $exam->exam_result_status = "fail";
                                } elseif ($exam_result_value->get_marks < $exam_result_value->min_marks) {

                                    $exam->exam_result_status = "fail";
                                }
                                $exam->total_max_marks                            = $exam->total_max_marks + $exam_result_value->max_marks;
                                $exam->total_get_marks                            = $exam->total_get_marks + $exam_result_value->get_marks;
                                $percentage                                       = ($exam_result_value->get_marks * 100) / $exam_result_value->max_marks;
                                $subject_array['name']                            = $exam_result_value->name;
                                $subject_array['code']                            = $exam_result_value->code;
                                $subject_array['exam_group_class_batch_exams_id'] = $exam_result_value->exam_group_class_batch_exams_id;
                                $subject_array['room_no']                         = $exam_result_value->room_no;
                                $subject_array['max_marks']                       = $exam_result_value->max_marks;
                                $subject_array['min_marks']                       = $exam_result_value->min_marks;
                                $subject_array['subject_id']                      = $exam_result_value->subject_id;
                                $subject_array['attendence']                      = $exam_result_value->attendence;
                                $subject_array['get_marks']                       = $exam_result_value->get_marks;
                                $subject_array['exam_group_exam_results_id']      = $exam_result_value->exam_group_exam_results_id;
                                $subject_array['note']                            = $exam_result_value->note;
                                $subject_array['duration']                        = $exam_result_value->duration;
                                $subject_array['credit_hours']                    = $exam_result_value->credit_hours;
                                $subject_array['exam_grade']                      = findExamGrade($exam_grade, $exam_result->exam_type, $percentage);

                                if ($exam_result->exam_type == "gpa") {

                                    $point                                = findGradePoints($exam_grade, $exam_result->exam_type, $percentage);
                                    $exam->exam_quality_points            = $exam->exam_quality_points + ($exam_result_value->credit_hours * $point);
                                    $exam->exam_credit_hour               = $exam->exam_credit_hour + $exam_result_value->credit_hours;
                                    $exam->total_exam_points              = $exam->total_exam_points + $point;
                                    $subject_array['exam_grade_point']    = number_format($point, 2, '.', '');
                                    $subject_array['exam_quality_points'] = $exam_result_value->credit_hours * $point;
                                }
                                $exam->subject_result[] = $subject_array;
                            }
                            $exam->percentage = ($exam->total_get_marks * 100) / $exam->total_max_marks;
                            $exam->division   = getExamDivision($exam->percentage);
                            $exam->exam_grade = findExamGrade($exam_grade, $exam_result->exam_type, $exam->percentage);
                        } else {
                            $exam->is_consolidate = 1;
                            $exam_connected_exam  = ($exam_result->exam_result['exam_result']['exam_result_' . $exam_result->exam_group_class_batch_exam_id]);

                            if (!empty($exam_connected_exam)) {
                                foreach ($exam_connected_exam as $exam_result_key => $exam_result_value) {

                                    $subject_array = array();
                                    if ($exam_result_value->attendence != "present") {
                                        $exam->exam_result_status = "fail";
                                    } elseif ($exam_result_value->get_marks < $exam_result_value->min_marks) {

                                        $exam->exam_result_status = "fail";
                                    }
                                    $exam->total_max_marks                            = $exam->total_max_marks + $exam_result_value->max_marks;
                                    $exam->total_get_marks                            = $exam->total_get_marks + $exam_result_value->get_marks;
                                    $percentage                                       = ($exam_result_value->get_marks * 100) / $exam_result_value->max_marks;
                                    $subject_array['name']                            = $exam_result_value->name;
                                    $subject_array['code']                            = $exam_result_value->code;
                                    $subject_array['exam_group_class_batch_exams_id'] = $exam_result_value->exam_group_class_batch_exams_id;
                                    $subject_array['room_no']                         = $exam_result_value->room_no;
                                    $subject_array['max_marks']                       = $exam_result_value->max_marks;
                                    $subject_array['min_marks']                       = $exam_result_value->min_marks;
                                    $subject_array['subject_id']                      = $exam_result_value->subject_id;
                                    $subject_array['attendence']                      = $exam_result_value->attendence;
                                    $subject_array['get_marks']                       = $exam_result_value->get_marks;

                                    $subject_array['exam_group_exam_results_id'] = $exam_result_value->exam_group_exam_results_id;
                                    $subject_array['note']                       = $exam_result_value->note;
                                    $subject_array['duration']                   = $exam_result_value->duration;
                                    $subject_array['credit_hours']               = $exam_result_value->credit_hours;
                                    $subject_array['exam_grade']                 = findExamGrade($exam_grade, $exam_result->exam_type, $percentage);

                                    if ($exam_result->exam_type == "gpa") {

                                        $point                             = findGradePoints($exam_grade, $exam_result->exam_type, $percentage);
                                        $exam->exam_quality_points         = $exam->exam_quality_points + ($exam_result_value->credit_hours * $point);
                                        $exam->exam_credit_hour            = $exam->exam_credit_hour + $exam_result_value->credit_hours;
                                        $exam->total_exam_points           = $exam->total_exam_points + $point;
                                        $subject_array['exam_grade_point'] = number_format($point, 2, '.', '');
                                    }
                                    $exam->subject_result[] = $subject_array;
                                }
                                $exam->percentage = ($exam->total_get_marks * 100) / $exam->total_max_marks;
                                $exam->division   = getExamDivision($exam->percentage);
                                $exam->exam_grade = findExamGrade($exam_grade, $exam_result->exam_type, $exam->percentage);
                            }
                            $consolidate_result                     = new stdClass;
                            $consolidate_get_total                  = 0;
                            $consolidate_total_points               = 0;
                            $consolidate_max_total                  = 0;
                            $consolidate_subjects_total             = 0;
                            $consolidate_result->exam_array         = array();
                            $consolidate_result->consolidate_result = array();
                            $consolidate_result_status              = "pass";
                            if (!empty($exam_result->exam_result['exams'])) {
                                $consolidate_exam_result = "pass";
                                foreach ($exam_result->exam_result['exams'] as $each_exam_key => $each_exam_value) {
                                    if ($exam_result->exam_type != "gpa") {
                                        $consolidate_each = getCalculatedExam($exam_result->exam_result['exam_result'], $each_exam_value->id);

                                        if ($consolidate_each->exam_status == "fail") {
                                            $consolidate_result_status = "fail";
                                        }

                                        $consolidate_get_percentage_mark = getConsolidateRatio($exam_result->exam_result['exam_connection_list'], $each_exam_value->id, $consolidate_each->get_marks);

                                        $each_exam_value->percentage = $consolidate_get_percentage_mark;
                                        $consolidate_get_total       = $consolidate_get_total + ($consolidate_get_percentage_mark);
                                        $consolidate_max_total       = $consolidate_max_total + ($consolidate_each->max_marks);
                                    }

                                    if ($exam_result->exam_type == "gpa") {
                                        $consolidate_each = getCalculatedExamGradePoints($exam_result->exam_result['exam_result'], $each_exam_value->id, $exam_grade, $exam_result->exam_type);

                                        $each_exam_value->total_points = $consolidate_each->total_points;
                                        $each_exam_value->total_exams  = $consolidate_each->total_exams;

                                        $consolidate_exam_result         = ($consolidate_each->total_points / $consolidate_each->total_exams);
                                        $consolidate_get_percentage_mark = getConsolidateRatio($exam_result->exam_result['exam_connection_list'], $each_exam_value->id, $consolidate_exam_result);
                                        $each_exam_value->percentage     = $consolidate_get_percentage_mark;
                                        $consolidate_get_total           = $consolidate_get_total + ($consolidate_get_percentage_mark);

                                        $consolidate_subjects_total = $consolidate_subjects_total + $consolidate_each->total_exams;

                                        $each_exam_value->exam_result = number_format($consolidate_exam_result, 2, '.', '');
                                    }

                                    $consolidate_result->exam_array[] = $each_exam_value;
                                }
                                $consolidate_result->consolidate_result['marks_obtain'] = $consolidate_get_total;
                                $consolidate_result->consolidate_result['marks_total']  = $consolidate_max_total;

                                $consolidate_result->consolidate_result['percentage'] = ($consolidate_get_total * 100) / $consolidate_max_total;
                                $consolidate_result->consolidate_result['division']   = getExamDivision($consolidate_result->consolidate_result['percentage']);
                                if ($exam_result->exam_type != "gpa") {

                                    $consolidate_percentage_grade                            = ($consolidate_get_total * 100) / $consolidate_max_total;
                                    $consolidate_result->consolidate_result['result']        = $consolidate_get_total . "/" . $consolidate_max_total;
                                    $consolidate_result->consolidate_result['grade']         = findExamGrade($exam_grade, $exam_result->exam_type, $consolidate_percentage_grade);
                                    $consolidate_result->consolidate_result['result_status'] = $consolidate_result_status;
                                } elseif ($exam_result->exam_type == "gpa") {
                                    $consolidate_percentage_grade = ($consolidate_get_total * 100) / $consolidate_subjects_total;

                                    $consolidate_result->consolidate_result['result'] = $consolidate_get_total . "/" . $consolidate_subjects_total;

                                    $consolidate_result->consolidate_result['grade'] = findExamGrade($exam_grade, $exam_result->exam_type, $consolidate_percentage_grade);
                                }

                                $consolidate_exam_result_percentage = $consolidate_percentage_grade;
                            }
                            $exam->consolidated_exam_result = $consolidate_result;
                        }
                        $data['exam'] = $exam;
                    }

                    $data['status'] = "200";
                    json_output($response['status'], $data);
                }
            }
        }
    }

    public function getGradeByMarks($marks = 0)
    {
        $gradeList = $this->grade_model->get();
        if (empty($gradeList)) {
            return "empty list";
        } else {

            foreach ($gradeList as $grade_key => $grade_value) {
                if (round($marks) >= $grade_value['mark_from'] && round($marks) <= $grade_value['mark_upto']) {
                    return $grade_value['name'];
                    break;
                }
            }
            return "no record found";
        }
    }

    public function Parent_GetStudentsList()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $array = array('status' => 200, 'error' => '', 'message' => 'detail found');

                    $_POST           = json_decode(file_get_contents("php://input"), true);
                    $parent_id       = $this->input->post('parent_id');
                    $students_array  = $this->student_model->read_siblings_students($parent_id);
                    $array['childs'] = $students_array;
                    json_output($response['status'], $array);
                }
            }
        }
    }

    public function getModuleStatus()
    {
        $method = $this->input->server('REQUEST_METHOD');

        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $_POST               = json_decode(file_get_contents("php://input"), true);
                    $user                = $this->input->post('user');
                    $resp = array('status' => 200, 'error' => '', 'message' => 'detail found');
                    $resp['module_list'] = $this->module_model->get($user);
                    json_output($response['status'], $resp);
                }
            }
        }
    }

    public function searchuser()
    {

        $method = $this->input->server('REQUEST_METHOD');

        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $data = array();

                    $params     = json_decode(file_get_contents('php://input'), true);
                    $student_id = $params['student_id'];

                    $keyword = $params['keyword'];

                    $chat_user    = $this->chatuser_model->getMyID($student_id, 'student');
                    $chat_user_id = 0;
                    if (!empty($chat_user)) {
                        $chat_user_id = $chat_user->id;
                    }

                    $resp['chat_user'] = $this->chatuser_model->searchForUser($keyword, $chat_user_id, $student_id, 'student');
                    json_output($response['status'], $resp);
                }
            }
        }
    }

    public function addChatUser()
    {

        $method = $this->input->server('REQUEST_METHOD');

        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $params      = json_decode(file_get_contents('php://input'), true);
                    $user_type   = $params['user_type'];
                    $user_id     = $params['user_id'];
                    $student_id  = $params['student_id'];
                    $first_entry = array(
                        'user_type'  => "student",
                        'student_id' => $student_id,
                    );
                    $insert_data = array('user_type' => strtolower($user_type), 'create_student_id' => null);

                    if ($user_type == "Student") {
                        $insert_data['student_id'] = $user_id;
                    } elseif ($user_type == "Staff") {
                        $insert_data['staff_id'] = $user_id;
                    }
                    $insert_message = array(
                        'message'            => 'you are now connected on chat',
                        'chat_user_id'       => 0,
                        'is_first'           => 1,
                        'chat_connection_id' => 0,
                    );

                    //===================
                    $new_user_record = $this->chatuser_model->addNewUserForStudent($first_entry, $insert_data, $student_id, $insert_message, 'student');
                    $json_record     = json_decode($new_user_record);

                    //==================

                    $new_user           = $this->chatuser_model->getChatUserDetail($json_record->new_user_id);
                    $chat_user          = $this->chatuser_model->getMyID($student_id, 'student');
                    $data['chat_user']  = $chat_user;
                    $chat_connection_id = $json_record->new_user_chat_connection_id;
                    $chat_to_user       = 0;
                    $user_last_chat     = $this->chatuser_model->getLastMessages($chat_connection_id);

                    $chat_connection = $this->chatuser_model->getChatConnectionByID($chat_connection_id);
                    if (!empty($chat_connection)) {
                        $chat_to_user       = $chat_connection->chat_user_one;
                        $chat_connection_id = $chat_connection->id;
                        if ($chat_connection->chat_user_one == $chat_user->id) {
                            $chat_to_user = $chat_connection->chat_user_two;
                        }
                    }

                    $array = array('status' => 200, 'error' => '', 'message' => $this->lang->line('success_message'), 'new_user' => $new_user, 'chat_connection_id' => $json_record->new_user_chat_connection_id, 'chat_records' => $chat_records, 'user_last_chat' => $user_last_chat);
                    json_output($response['status'], $array);
                }
            }
        }
    }

    public function liveclasses()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $_POST        = json_decode(file_get_contents("php://input"), true);
                    $student_id   = $this->input->post('student_id');
                    $result       = $this->student_model->get($student_id);
                    $class_id     = $result->class_id;
                    $section_id   = $result->section_id;
                    $live_classes = $this->conference_model->getByStudentClassSection($class_id, $section_id);
                    if (!empty($live_classes)) {
                        foreach ($live_classes as $lc_key => $lc_value) {
                            $live_url                            = json_decode($lc_value->return_response);
                            $live_classes[$lc_key]->{'join_url'} = $live_url->join_url;
                            unset($lc_value->return_response);
                        }
                    }

                    $data["live_classes"] = $live_classes;
                    json_output($response['status'], $data);
                }
            }
        }
    }

    public function livehistory()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $_POST       = json_decode(file_get_contents("php://input"), true);
                    $insert_data = array(
                        'student_id'    => $this->input->post('student_id'),
                        'conference_id' => $this->input->post('conference_id'),
                    );
                    $this->conference_model->updatehistory($insert_data);
                    $array = array('status' => 200, 'msg' => 'Success');
                    json_output($response['status'], $array);
                }
            }
        }
    }

    public function gmeetclasses()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $_POST        = json_decode(file_get_contents("php://input"), true);
                    $student_id   = $this->input->post('student_id');
                    $result       = $this->student_model->get($student_id);
                    $class_id     = $result->class_id;
                    $section_id   = $result->section_id;
                    $live_classes = $this->gmeet_model->getByStudentClassSection($class_id, $section_id);

                    $data["live_classes"] = $live_classes;
                    json_output($response['status'], $data);
                }
            }
        }
    }

    public function gmeethistory()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $_POST = json_decode(file_get_contents("php://input"), true);

                    $insert_data = array(
                        'student_id' => $this->input->post('student_id'),
                        'gmeet_id'   => $this->input->post('gmeet_id'),
                    );
                    $this->gmeet_model->updatehistory($insert_data);
                    $array = array('status' => 200, 'msg' => 'Success');

                    json_output($response['status'], $array);
                }
            }
        }
    }

    public function checkProfileUpdate()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $school_setting = $this->setting_model->getSchoolDetail()->student_profile_edit;
                    $array          = array('status' => 200, 'student_profile_edit' => $school_setting);
                    json_output($response['status'], $array);
                }
            }
        }
    }

    public function profileUpdateFields()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {

                    $_POST      = json_decode(file_get_contents("php://input"), true);
                    $student_id = $this->input->post('student_id');

                    $inserted_fields        = $this->student_edit_field_model->get();
                    $result['id']           = $student_id;
                    $student                = $this->student_model->get($student_id);
                    $genderList             = $this->customlib->getGender();
                    $result['student']      = $student;
                    $result['genderList']   = $genderList;
                    $vehroute_result        = $this->vehroute_model->get();
                    $result['vehroutelist'] = $vehroute_result;
                    $category               = $this->category_model->get();
                    $result['categorylist'] = $category;
                    $result["bloodgroup"]   = $this->config->item('bloodgroup');
                    $array                  = array();
                    $sch_setting_detail     = $this->setting_model->getSetting();
                    if (!empty($inserted_fields)) {
                        foreach ($inserted_fields as $field_key => $field_value) {
                            $obj         = new stdClass();
                            $obj->name   = $field_value->name;
                            $obj->status = check_student_field_status($sch_setting_detail, $field_value);
                            $array[]     = $obj;
                        }
                    }
                    $result['student_details'] = $array;
                    $array                     = array('status' => 200, 'result' => $result);
                    json_output($response['status'], $array);
                }
            }
        }
    }

    public function editprofile()
    {

        $method = $this->input->server('REQUEST_METHOD');

        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $post_data = $this->input->POST();

                    $this->form_validation->set_error_delimiters('', '');
                    $student_id = $this->input->post('student_id');
                    $data['id'] = $student_id;
                    $post_data  = $this->input->post();
                    if (isset($post_data['firstname'])) {
                        $this->form_validation->set_rules('firstname', 'first_name', 'trim|required|xss_clean');
                    }
                    if (isset($post_data['guardian_is'])) {
                        $this->form_validation->set_rules('guardian_is', 'guardian', 'trim|required|xss_clean');
                    }
                    if (isset($post_data['dob'])) {
                        $this->form_validation->set_rules('dob', 'date_of_birth', 'trim|required|xss_clean');
                    }
                    if (isset($post_data['gender'])) {
                        $this->form_validation->set_rules('gender', 'gender', 'trim|required|xss_clean');
                    }
                    if (isset($post_data['guardian_name'])) {
                        $this->form_validation->set_rules('guardian_name', 'guardian_name', 'trim|required|xss_clean');
                    }

                    if (isset($post_data['guardian_phone'])) {
                        $this->form_validation->set_rules('guardian_phone', 'guardian_phone', 'trim|required|xss_clean');
                    }

                    if ($this->form_validation->run() == false) {

                        $validation_error = array();

                        if (isset($post_data['firstname'])) {
                            $validation_error['firstname'] = form_error('firstname');
                        }
                        if (isset($post_data['guardian_is'])) {
                            $validation_error['guardian_is'] = form_error('guardian_is');
                        }
                        if (isset($post_data['dob'])) {
                            $validation_error['dob'] = form_error('dob');
                        }
                        if (isset($post_data['gender'])) {
                            $validation_error['gender'] = form_error('gender');
                        }
                        if (isset($post_data['guardian_name'])) {
                            $validation_error['guardian_name'] = form_error('guardian_name');
                        }

                        if (isset($post_data['guardian_phone'])) {
                            $validation_error['guardian_phone'] = form_error('guardian_phone');
                        }

                        $array = array('status' => 400, 'error' => $validation_error);
                    } else {

                        $student_id = $student_id;
                        $data       = array(
                            'id' => $student_id,
                        );

                        $firstname = $this->input->post('firstname');
                        if (isset($firstname)) {
                            $data['firstname'] = $this->input->post('firstname');
                        }
                        $rte = $this->input->post('rte');
                        if (isset($rte)) {
                            $data['rte'] = $this->input->post('rte');
                        }
                        $pincode = $this->input->post('pincode');
                        if (isset($pincode)) {
                            $data['pincode'] = $this->input->post('pincode');
                        }
                        $cast = $this->input->post('cast');
                        if (isset($cast)) {
                            $data['cast'] = $this->input->post('cast');
                        }
                        $guardian_is = $this->input->post('guardian_is');
                        if (isset($guardian_is)) {
                            $data['guardian_is'] = $this->input->post('guardian_is');
                        }
                        $previous_school = $this->input->post('previous_school');
                        if (isset($previous_school)) {
                            $data['previous_school'] = $this->input->post('previous_school');
                        }
                        $dob = $this->input->post('dob');
                        if (isset($dob)) {
                            $data['dob'] = date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('dob')));
                        }
                        $current_address = $this->input->post('current_address');
                        if (isset($current_address)) {
                            $data['current_address'] = $this->input->post('current_address');
                        }
                        $permanent_address = $this->input->post('permanent_address');
                        if (isset($permanent_address)) {
                            $data['permanent_address'] = $this->input->post('permanent_address');
                        }
                        $bank_account_no = $this->input->post('bank_account_no');
                        if (isset($bank_account_no)) {
                            $data['bank_account_no'] = $this->input->post('bank_account_no');
                        }
                        $bank_name = $this->input->post('bank_name');
                        if (isset($bank_name)) {
                            $data['bank_name'] = $this->input->post('bank_name');
                        }
                        $ifsc_code = $this->input->post('ifsc_code');
                        if (isset($ifsc_code)) {
                            $data['ifsc_code'] = $this->input->post('ifsc_code');
                        }
                        $guardian_occupation = $this->input->post('guardian_occupation');
                        if (isset($guardian_occupation)) {
                            $data['guardian_occupation'] = $this->input->post('guardian_occupation');
                        }
                        $guardian_email = $this->input->post('guardian_email');
                        if (isset($guardian_email)) {
                            $data['guardian_email'] = $this->input->post('guardian_email');
                        }
                        $gender = $this->input->post('gender');
                        if (isset($gender)) {
                            $data['gender'] = $this->input->post('gender');
                        }
                        $guardian_name = $this->input->post('guardian_name');
                        if (isset($guardian_name)) {
                            $data['guardian_name'] = $this->input->post('guardian_name');
                        }
                        $guardian_relation = $this->input->post('guardian_relation');
                        if (isset($guardian_relation)) {
                            $data['guardian_relation'] = $this->input->post('guardian_relation');
                        }
                        $guardian_phone = $this->input->post('guardian_phone');
                        if (isset($guardian_phone)) {
                            $data['guardian_phone'] = $this->input->post('guardian_phone');
                        }
                        $guardian_address = $this->input->post('guardian_address');
                        if (isset($guardian_address)) {
                            $data['guardian_address'] = $this->input->post('guardian_address');
                        }
                        $adhar_no = $this->input->post('adhar_no');
                        if (isset($adhar_no)) {
                            $data['adhar_no'] = $this->input->post('adhar_no');
                        }
                        $samagra_id = $this->input->post('samagra_id');
                        if (isset($samagra_id)) {
                            $data['samagra_id'] = $this->input->post('samagra_id');
                        }

                        $house             = $this->input->post('house');
                        $blood_group       = $this->input->post('blood_group');
                        $measurement_date  = $this->input->post('measure_date');
                        $roll_no           = $this->input->post('roll_no');
                        $lastname          = $this->input->post('lastname');
                        $category_id       = $this->input->post('category_id');
                        $religion          = $this->input->post('religion');
                        $mobileno          = $this->input->post('mobileno');
                        $email             = $this->input->post('email');
                        $admission_date    = $this->input->post('admission_date');
                        $height            = $this->input->post('height');
                        $weight            = $this->input->post('weight');
                        $father_name       = $this->input->post('father_name');
                        $father_phone      = $this->input->post('father_phone');
                        $father_occupation = $this->input->post('father_occupation');
                        $mother_name       = $this->input->post('mother_name');
                        $mother_phone      = $this->input->post('mother_phone');
                        $mother_occupation = $this->input->post('mother_occupation');

                        if (isset($measurement_date)) {
                            $data['measurement_date'] = date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('measure_date')));
                        }

                        if (isset($house)) {
                            $data['school_house_id'] = $this->input->post('house');
                        }
                        if (isset($blood_group)) {

                            $data['blood_group'] = $this->input->post('blood_group');
                        }

                        if (isset($lastname)) {

                            $data['lastname'] = $this->input->post('lastname');
                        }

                        if (isset($category_id)) {

                            $data['category_id'] = $this->input->post('category_id');
                        }

                        if (isset($religion)) {

                            $data['religion'] = $this->input->post('religion');
                        }

                        if (isset($mobileno)) {

                            $data['mobileno'] = $this->input->post('mobileno');
                        }

                        if (isset($email)) {

                            $data['email'] = $this->input->post('email');
                        }

                        if (isset($admission_date)) {

                            $data['admission_date'] = date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('admission_date')));
                        }

                        if (isset($height)) {

                            $data['height'] = $this->input->post('height');
                        }

                        if (isset($weight)) {

                            $data['weight'] = $this->input->post('weight');
                        }

                        if (isset($father_name)) {

                            $data['father_name'] = $this->input->post('father_name');
                        }

                        if (isset($father_phone)) {

                            $data['father_phone'] = $this->input->post('father_phone');
                        }

                        if (isset($father_occupation)) {

                            $data['father_occupation'] = $this->input->post('father_occupation');
                        }

                        if (isset($mother_name)) {

                            $data['mother_name'] = $this->input->post('mother_name');
                        }

                        if (isset($mother_phone)) {

                            $data['mother_phone'] = $this->input->post('mother_phone');
                        }

                        if (isset($mother_occupation)) {

                            $data['mother_occupation'] = $this->input->post('mother_occupation');
                        }

                        $this->student_model->add($data);

                        if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                            $fileInfo = pathinfo($_FILES["file"]["name"]);
                            $img_name = $student_id . '.' . $fileInfo['extension'];
                            move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/student_images/" . $img_name);
                            $data_img = array('id' => $student_id, 'image' => 'uploads/student_images/' . $img_name);
                            $this->student_model->add($data_img);
                        }

                        if (isset($_FILES["father_pic"]) && !empty($_FILES['father_pic']['name'])) {
                            $fileInfo = pathinfo($_FILES["father_pic"]["name"]);
                            $img_name = $student_id . "father" . '.' . $fileInfo['extension'];
                            move_uploaded_file($_FILES["father_pic"]["tmp_name"], "./uploads/student_images/" . $img_name);
                            $data_img = array('id' => $student_id, 'father_pic' => 'uploads/student_images/' . $img_name);
                            $this->student_model->add($data_img);
                        }

                        if (isset($_FILES["mother_pic"]) && !empty($_FILES['mother_pic']['name'])) {
                            $fileInfo = pathinfo($_FILES["mother_pic"]["name"]);
                            $img_name = $student_id . "mother" . '.' . $fileInfo['extension'];
                            move_uploaded_file($_FILES["mother_pic"]["tmp_name"], "./uploads/student_images/" . $img_name);
                            $data_img = array('id' => $student_id, 'mother_pic' => 'uploads/student_images/' . $img_name);
                            $this->student_model->add($data_img);
                        }

                        if (isset($_FILES["guardian_pic"]) && !empty($_FILES['guardian_pic']['name'])) {
                            $fileInfo = pathinfo($_FILES["guardian_pic"]["name"]);
                            $img_name = $student_id . "guardian" . '.' . $fileInfo['extension'];
                            move_uploaded_file($_FILES["guardian_pic"]["tmp_name"], "./uploads/student_images/" . $img_name);
                            $data_img = array('id' => $student_id, 'guardian_pic' => 'uploads/student_images/' . $img_name);
                            $this->student_model->add($data_img);
                        }

                        $array = array('status' => 200, 'msg' => 'Record Updated Successfully');
                    }
                    json_output(200, $array);
                }
            }
        }
    }

    public function edit_handle_upload($value, $field_name)
    {

        $image_validate = $this->config->item('image_validate');

        if (isset($_FILES[$field_name]) && !empty($_FILES[$field_name]['name'])) {

            $file_type         = $_FILES[$field_name]['type'];
            $file_size         = $_FILES[$field_name]["size"];
            $file_name         = $_FILES[$field_name]["name"];
            $allowed_extension = $image_validate['allowed_extension'];
            $ext               = pathinfo($file_name, PATHINFO_EXTENSION);
            $allowed_mime_type = $image_validate['allowed_mime_type'];
            if ($files = @getimagesize($_FILES[$field_name]['tmp_name'])) {

                if (!in_array($files['mime'], $allowed_mime_type)) {
                    $this->form_validation->set_message('edit_handle_upload', 'File Type Not Allowed');
                    return false;
                }

                if (!in_array($ext, $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('edit_handle_upload', 'Extension Not Allowed');
                    return false;
                }
                if ($file_size > $image_validate['upload_size']) {
                    $this->form_validation->set_message('edit_handle_upload', $this->lang->line('file_size_shoud_be_less_than') . number_format($image_validate['upload_size'] / 1048576, 2) . " MB");
                    return false;
                }
            } else {
                $this->form_validation->set_message('edit_handle_upload', "File Type / Extension Error Uploading  Image");
                return false;
            }

            return true;
        }
        return true;
    }
    public function getMarks($question)
    {

        if ($question->select_option != null) {

            if ($question->question_type == "singlechoice" || $question->question_type == "true_false") {

                if ($question->correct == $question->select_option) {
                    return json_encode(array('get_marks' => $question->marks, 'scr_marks' => $question->marks));
                }

            } elseif ($question->question_type == "descriptive") {

                return json_encode(array('get_marks' => $question->marks, 'scr_marks' => $question->score_marks));

            } elseif ($question->question_type == "multichoice") {
                $cr_ans  = json_decode($question->correct);
                $sel_ans = json_decode($question->select_option);
                if ($this->array_equal($cr_ans, $sel_ans)) {
                    return json_encode(array('get_marks' => $question->marks, 'scr_marks' => $question->marks));
                }

            }
        }

        return json_encode(array('get_marks' => $question->marks, 'scr_marks' => 0));
    }
    public function array_equal($a, $b)
    {
        return (
            is_array($a) && is_array($b) && count($a) == count($b) && array_diff($a, $b) === array_diff($b, $a)
        );
    }

    public function uploadDocument()
    {

        $method = $this->input->server('REQUEST_METHOD');

        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $data = $this->input->POST();

                    $this->form_validation->set_data($data);
                    $this->form_validation->set_error_delimiters('', '');
                    $this->form_validation->set_rules('student_id', 'Student ID', 'required|trim');
                    $this->form_validation->set_rules('title', 'Title', 'required|trim');
                    $this->form_validation->set_rules('file', 'File', 'callback_handle_upload_file_compulsory');
                    if ($this->form_validation->run() == false) {

                        $form_error = array(

                            'student_id' => form_error('student_id'),
                            'title'      => form_error('title'),
                            'file'       => form_error('file'),
                        );
                        $array = array('status' => 400, 'error' => $form_error);
                    } else {
                        //==================
                        $student_id  = $this->input->post('student_id');
                        $title       = $this->input->post('title');
                        $upload_path = $this->config->item('upload_path') . "/student_documents/" . $student_id . "/";
                        if (!is_dir($upload_path) && !mkdir($upload_path)) {
                            die("Error creating folder $upload_path");
                        }

                        if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                            $fileInfo  = pathinfo($_FILES["file"]["name"]);
                            $file_name = $_FILES['file']['name'];
                            $exp       = explode(' ', $file_name);
                            $imp       = implode('_', $exp);
                            $img_name  = $upload_path . basename($imp);
                            move_uploaded_file($_FILES["file"]["tmp_name"], $img_name);
                            $data_img = array('student_id' => $student_id, 'title' => $title, 'doc' => $imp);
                            $this->student_model->adddoc($data_img);
                        }

                        $array = array('status' => 200, 'msg' => 'Success');
                    }
                    json_output(200, $array);
                }
            }
        }
    }
	
	/**
     * This function is used to get online course list based on student class_id and section_id
     */
	public function courselist()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $_POST        = json_decode(file_get_contents("php://input"), true);
					$pay_method = $this->paymentsetting_model->getActiveMethod();
                    $student_id   = $this->input->post('student_id');
                    $result       = $this->student_model->get($student_id);
                    $class_id     = $result->class_id;
                    $section_id   = $result->section_id;
                    $courselist         = $this->course_model->courselistforstudent($class_id, $section_id);
					$course_list     = array();
					foreach ($courselist as $key => $courselist_value) {
						$lesson_count   = $this->course_model->totallessonbycourse($courselist_value['id']);
						
						$courselist_value['total_lesson'] = count($lesson_count);
						$courselist_value['total_hour_count'] = $this->course_model->counthours($courselist_value['id']);
						$courselist_value['paidstatus']	= $this->course_model->paidstatus($courselist_value['id'], $student_id);
						$courseprogresscount = $this->course_model->courseprogresscount($courselist_value['id'], $student_id);
						$quiz_count          = $this->course_model->totalquizbycourse($courselist_value['id']);
						
						$total_quiz_lession = count($quiz_count) + count($lesson_count);
						$course_progress    = 0;
						if ($total_quiz_lession > 0) {
							$course_progress = (count($courseprogresscount) / $total_quiz_lession) * 100;
						}
						$courselist_value['course_progress'] = $course_progress;
						$course_list[]                    = $courselist_value;
						
						$course_list[$key]['image'] ='';
						if(!empty($courselist_value['image'])){							
							$course_list[$key]['image']	=	$courselist_value['image'];
						}else{
							if($courselist_value['gender']=='Female'){
								$course_list[$key]['image']	=	 "default_female.jpg";
							}else{
								$course_list[$key]['image']	=   "default_male.jpg";
							}
						}				
						
					}	
					$data['pay_method']			=  empty($pay_method) ? 0 : 1;

					$data['course_list'] = $course_list;
                    json_output($response['status'], $data);
                }
            }
        }
    }
	
	/**
     * This function is used to get online course details
     */
	public function coursedetail()
    {
		$this->load->library('Aws3');
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $_POST = json_decode(file_get_contents("php://input"), true);
                    $this->form_validation->set_data($_POST);
                    $course_id = $this->input->post('course_id');
                    $coursedetail	= $this->course_model->coursedetail($course_id);
					
					$coursedetail['data']    = $coursedetail;
					
                    json_output($response['status'], $coursedetail);
                }
            }
        }
    }
	
	/**
     * This function is used to get online course section, lesson and quiz details
     */
	public function coursecurriculum()
    {
		$this->load->library('Aws3');
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $_POST = json_decode(file_get_contents("php://input"), true);
                    $this->form_validation->set_data($_POST);
                    $course_id = $this->input->post('course_id');
					$student_id   = $this->input->post('student_id');
					$sectionList          = $this->course_model->getsectionbycourse($course_id,$student_id);				
					$data['sectionList']  = $sectionList;                  
                    json_output($response['status'], $data);
                }
            }
        }
    }
	
	/**
     * This function is used to get online course quiz question based on quiz_id and student_id
     */
	public function getquestionbyquizid()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $_POST = json_decode(file_get_contents("php://input"), true);
                    $this->form_validation->set_data($_POST);
                    $quiz_id = $this->input->post('quiz_id');
					$student_id   = $this->input->post('student_id');
					$questionlist          = $this->course_model->getquestionbyquizid($quiz_id,$student_id);					
					$data['questionlist']  = $questionlist;                  
                    json_output($response['status'], $data);
                }
            }
        }
    }
	
	/**
     * This function is used to get online course quiz result based on quiz_id and student_id
     */
	public function quizresult()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {
                    $_POST = json_decode(file_get_contents("php://input"), true);
                    $this->form_validation->set_data($_POST);
                    $quiz_id = $this->input->post('quiz_id');
					$answerlist ='';
					$student_id   = $this->input->post('student_id');
					$result          = $this->course_model->quizresult($quiz_id,$student_id);	
					foreach($result as $result_value){
						$answerlist	=	$this->course_model->quizstudentanswerlist($quiz_id,$student_id);	
					}	
					$data['result']  = $result; 
					$data['answerlist']     = 	$answerlist;				
                    json_output($response['status'], $data);
                }
            }
        }
    }
	
	/**
     * This function is used to insert online course quiz answer
     */
	public function saveanswer()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {	
					$params     	= json_decode(file_get_contents('php://input'), true);
                    $student_id 	= $params['student_id'];
                    $quiz_id 		= $params['quiz_id'];
                    $questionID 	= $params['question_id'];			

					$result = $this->course_model->getquizanswerexistornot($questionID, $quiz_id, $student_id);
					
					$answer1    	= $params['answer_1'];
					$answer2    	= $params['answer_2'];
					$answer3    	= $params['answer_3'];
					$answer4    	= $params['answer_4'];
					$answer5    	= $params['answer_5'];
					
					$correctAnswer = array($answer1, $answer2, $answer3, $answer4, $answer5);
					if(empty($result)){
						
						$addData       = array(
							'student_id'   => $student_id,
							'course_quiz_id'      => $quiz_id,
							'course_quiz_question_id'  => $questionID,
							'answer'       => json_encode($correctAnswer),
							'created_date' => date('Y-m-d H:i:s'),
						);
						
					}else{
						
						$addData       = array(
							'id'   			=> $result['id'],
							'answer'       	=> json_encode($correctAnswer),
						 );						 
					}					
                    $this->course_model->addanswer($addData);					
                    $array = array('status' => 200, 'msg' => 'Success');                    
                    json_output(200, $array);
                }
            }
        }
    }
	
	/**
     * This function is used to submit online course quiz
     */
	public function submitquiz()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {	
					$params     	= json_decode(file_get_contents('php://input'), true);
                    $student_id 	= $params['student_id'];
                    $quiz_id 		= $params['quiz_id'];
                    $questionID 	= $params['question_id'];			

					$result = $this->course_model->getquizanswerexistornot($questionID, $quiz_id, $student_id);
					
					$answer1    	= $params['answer_1'];
					$answer2    	= $params['answer_2'];
					$answer3    	= $params['answer_3'];
					$answer4    	= $params['answer_4'];
					$answer5    	= $params['answer_5'];
					
					$correctAnswer = array($answer1, $answer2, $answer3, $answer4, $answer5);
					if(empty($result)){
						
						$addData       = array(
							'student_id'   => $student_id,
							'course_quiz_id'      => $quiz_id,
							'course_quiz_question_id'  => $questionID,
							'answer'       => json_encode($correctAnswer),
							'created_date' => date('Y-m-d H:i:s'),
						);
						
					}else{
						
						$addData       = array(
							'id'   			=> $result['id'],
							'answer'       	=> json_encode($correctAnswer),
						 );
						 
					}					
                    $this->course_model->addanswer($addData);
					$resultData = array(
						'student_id'   => $student_id,
						'course_quiz_id'      => $quiz_id,
						'status'       => 1,
						'created_date' => date('Y-m-d H:i:s'),
					);
					
					$lastid        = $this->course_model->addquizstatus($resultData);
					$studentresult = $this->course_model->getresult($quiz_id,$student_id);
					$answercount   = array();
					$wrongcount    = array();
					$not_attempted = array();
					if (!empty($studentresult)) {
						foreach ($studentresult as $studentresult_value) {
						$result = '';
							if (!empty($studentresult_value['answer'])) {
								$submit_answer = json_decode($studentresult_value['answer']);

								foreach ($submit_answer as $key => $submit_answer_value) {
									if (!empty($submit_answer_value)) {
										$key = $key + 1;
										if ($key == 1) {
											$result = "option_1,";
										}
										if ($key == 2) {
											$result = $result . "option_2,";
										}
										if ($key == 3) {
											$result = $result . "option_3,";
										}
										if ($key == 4) {
											$result = $result . "option_4,";
										}
										if ($key == 5) {
											$result = $result . "option_5";
										}
									}			
								}
								$result = rtrim($result, ',');
							}

							if ($studentresult_value['correct_answer'] == $result) {
								$answer_value = '1';
								array_push($answercount, $answer_value);
							} elseif (empty($result)) {
								$attempted_value = '1';
								array_push($not_attempted, $attempted_value);
							}
						}
					}
					
					$questioncount    = $this->course_model->getquestionbyquizid($quiz_id,$student_id);
		
					$questioncount   = count($questioncount);
					$answercount   = count($answercount);
					$not_attempted = count($not_attempted);
					$wrong_answer  = $questioncount - ($answercount + $not_attempted);
					if (!empty($lastid)) {
						$updateData = array(
							'id'             => $lastid,
							'total_question' => $questioncount,
							'correct_answer' => $answercount,
							'wrong_answer'   => $wrong_answer,
							'not_answer'     => $not_attempted,
						);
			
						$this->course_model->addquizstatus($updateData);
					}
		
                    $array = array('status' => 200, 'msg' => 'Success');
                    
                    json_output(200, $array);
                }
            }
        }
    }
	
	/*
    This is used to delete previous record of student if he has given exam
     */
	public function resetquiz()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {	
					$params     	= json_decode(file_get_contents('php://input'), true);
                    $student_id 	= $params['student_id'];
                    $course_quiz_id 		= $params['quiz_id'];			

					$this->course_model->removequizstatus($course_quiz_id,$student_id);
					$this->course_model->removestudentquizanswer($course_quiz_id,$student_id);								
                   					
                    $array = array('status' => 200, 'msg' => 'Success');                    
                    json_output(200, $array);
                }
            }
        }
    }
	
	/**
     * This function is used to mark quiz and lesson completed or not 
     */
	public function markascomplete()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {	
					$params     		= json_decode(file_get_contents('php://input'), true);
                    $student_id 		= $params['student_id'];
                    $section_id 		= $params['section_id'];				
                    $lesson_quiz_type 	= $params['lesson_quiz_type'];			
                    $lesson_quiz_id 	= $params['lesson_quiz_id'];
					$result           	= $this->course_model->coursebysection($section_id);
					$data = array(

						"student_id"        => $student_id,
						"lesson_quiz_id"    => $lesson_quiz_id,
						"lesson_quiz_type"  => $lesson_quiz_type,
						"course_section_id" => $section_id,
						"course_id"         => $result['id'],
					);

					$is_completed = $this->course_model->getcourseprogress($result['id'], $student_id, $section_id, $lesson_quiz_type, $lesson_quiz_id);
					

					if (!empty($is_completed)) {
						$this->course_model->markascomplete($data, 0);
					} else {
						$this->course_model->markascomplete($data, 1);
					}				
                   					
                    $array = array('status' => 200, 'msg' => 'Success');                    
                    json_output(200, $array);
                }
            }
        }
    }
	
	/*
    This is used to get student course performance
     */
	public function courseperformance()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->auth_model->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->auth_model->auth();
                if ($response['status'] == 200) {	
					$params     		= 	json_decode(file_get_contents('php://input'), true);
                    $course_id 			= 	$params['course_id'];
                    $student_id 		= 	$params['student_id'];					
					$data['result']  	= 	$this->course_model->courseperformance($course_id,$student_id);		
					$lessoncount		=	$this->course_model->totallessonbycourse($course_id);
					$data['lessoncount']  = count($lessoncount);					
					$data['lessoncompleted']  = count($this->course_model->lessoncompleted($course_id,$student_id,1));
					
					$quizcount				=	$this->course_model->totalquizbycourse($course_id);
					$data['quizcount']  	= 	count($quizcount);					
					$data['quizcompleted']  = 	count($this->course_model->lessoncompleted($course_id,$student_id,2));
					
					$lessonquizcount 			= 	$data['lessoncount']+$data['quizcount'] ;
					$lessonquizcompletedcount 	=	$data['lessoncompleted']+$data['quizcompleted'];
					if($lessonquizcount > 0){
					$data['percentage']  =	($lessonquizcompletedcount/$lessonquizcount)*100;
					}else{
						$data['percentage']  =	0;
					}
                    json_output($response['status'], $data);
					
                }
            }
        }
    }
	
}
