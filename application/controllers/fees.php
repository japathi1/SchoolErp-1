<?php
/**
 * Created by PhpStorm.
 * User: Akshat
 * Date: 7/18/2017
 * Time: 10:30 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Fees extends MY_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('get_header_info','ghi');
        $username = $this->ghi->get_admin();
        $this->load->view('private/fees/header',['username'=>$username]);
        $this->load->view('private/fees/footer');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
    }
    public function fees_head()
    {
        //for showing info in table
        //insert fees heading info. in database with insert_genric function

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if ($this->form_validation->run('fees_head')) {
            $post = $this->input->post();
            unset($post['submit']);
            $this->load->model('add_model', 'am');
            $table_name='fees_head';

            if ($this->am->insert_data($table_name,$post)) {
                $field_fhg='fees_head_group_name';
                $field_a='account_name';
                $table_name_fhg='fees_head_group';
                $table_name_a='account';
                $this->load->model('get_model','gm');
                $fees_head_list = $this->gm->get_list($field_fhg,$table_name_fhg);
                $account_name_list = $this->gm->get_list($field_a,$table_name_a);

                $this->load->model('get_model', 'gm');
                $fhl = $this->gm->fees_head_list();

                $this->load->view('private/fees/fees_head',
                    ['view_drop_fhg'=>$fees_head_list,'view_drop_anl'=>$account_name_list,'fhl'=>$fhl]);
            } else {
                echo 'Database query error';
                $field_fhg='fees_head_group_name';
                $field_a='account_name';
                $table_name_fhg='fees_head_group';
                $table_name_a='account';
                $this->load->model('get_model','gm');
                $fees_head_list = $this->gm->get_list($field_fhg,$table_name_fhg);
                $account_name_list = $this->gm->get_list($field_a,$table_name_a);

                $this->load->model('get_model', 'gm');
                $fhl = $this->gm->fees_head_list();

                $this->load->view('private/fees/fees_head',['view_drop_fhg'=>$fees_head_list,
                    'view_drop_anl'=>$account_name_list,'fhl'=>$fhl]);
            }
        } else {
            $field_fhg='fees_head_group_name';
            $field_a='account_name';
            $table_name_fhg='fees_head_group';
            $table_name_a='account';
            $this->load->model('get_model','gm');
            $fees_head_list = $this->gm->get_list($field_fhg,$table_name_fhg);
            $account_name_list = $this->gm->get_list($field_a,$table_name_a);

            $this->load->model('get_model', 'gm');
            $fhl = $this->gm->fees_head_list();

            $this->load->view('private/fees/fees_head',['view_drop_fhg'=>$fees_head_list,
                'view_drop_anl'=>$account_name_list,'fhl'=>$fhl]);
        }
    }

    public function fees_head_group()
    {
        //for inserting records in databse from fees_head group
        $form_validation='fhg';
        $table_name='fees_head_group';
        $view='fees_head_group';
        $field='fees_head_group_name';
        $this->insert_genric($form_validation,$table_name,$view,$field);
    }
    public function fees_head_group_del(){

        $form_validation='fees_head_group_del';
        $table_name='fees_head_group';
        $view='fees/fees_head_group';
        $field='fees_head_group_name';
        $unset='del_fhg';
        $value_form='fees_head_group_name_del';
        $this->delete_genric($form_validation,$table_name,$view,$field,$unset,$value_form);
    }
    public function fees_conc_sett()
    {
        $this->load->view('private/fees/fees_conc_settings');
    }
    public function fees_view(){
        $this->load->view('private/fees/fees_view');
    }

    public function fees_card(){
        $this->load->view('private/fees/fees_card');
    }

    public function fees_day_book(){
        $this->load->view('private/fees/fees_day_book');
    }

    public function insert_genric($form_validation,$table_name,$view,$field)
    {
        if ($this->form_validation->run($form_validation)) {
            $this->load->model('add_model', 'am');
            $post = $this->input->post();
            unset($post['submit']);
            if ($this->am->insert_data($table_name,$post)) {
                $this->load->model('get_model', 'gm');
                $array = $this->gm->get_list($field,$table_name);
                $this->load->view('private/fees/'.$view,['view'=>$array]);
            } else {
                echo 'Query failed in inserting record';
            }
        } else {
            $this->load->model('get_model', 'gm');
            $array = $this->gm->get_list($field,$table_name);
            $this->load->view('private/fees/'.$view,['view'=>$array]);
        }
    }

    public function fees_dues_class_fees(){}
    public function family_wise_dues_list(){}
    public function fees_status_report(){}
    public function fees_dues_list_detailed(){}
    public function fees_estimation_list(){}
    public function fees_receipt_register(){
        $this->load->view('private/fees/fees_reports/fees_receipt_register');
    }
    public function fees_head_summary(){
        $this->load->view('private/fees/fees_reports/fees_head_summary');
    }
    public function fees_monthly_summary(){
        $this->load->view('private/fees/fees_reports/fees_monthly_summary');
    }
    public function fees_concc_sett(){
        $this->load->view('private/fees/fees_reports/fees_concession_settings');
    }
    public function defaulter_list(){
        $this->load->view('private/fees/fees_reports/defaulter_list');
    }
    public function balance_fees_report(){
        $this->load->view('private/fees/fees_reports/balance_fees_report');
    }
    public function yearly_fees_receivable_report(){
        $this->load->view('private/fees/fees_reports/yearly_fees_receivable_report');
    }
    public function receipt_book(){
        $this->load->view('private/fees/fees_reports/receipt_book');
    }
    public function head_wise_collection(){
        $this->load->view('private/fees/fees_reports/head_wise_collection');
    }
    public function fees_group_ledger(){
        $this->load->view('private/fees/fees_reports/fees_group_ledger');
    }
    public function fees_structure(){
        $this->load->view('private/fees/fees_reports/fees_structure');
    }
    public function fees_summary_date_wise(){
        $this->load->view('private/fees/fees_reports/fees_summary_date_wise');
    }
    public function fees_category_concc_wise(){
        $this->load->view('private/fees/fees_reports/fees_category_concc_wise');
    }
    public function fees_head_wise_concc_report(){
        $this->load->view('private/fees/fees_reports/fees_head_wise_concc_report');
    }
    public function concc_register(){
        $this->load->view('private/fees/fees_reports/concc_register');
    }

    public function fees_plan(){

        //getting category list for checkbox (dynamic checkboxes for category and class)
        $this->load->model('get_model','gm');
        $table_name='fees_plan_category';
        $field='category_name';
        $category = $this->gm->get_list($field,$table_name);

        //getting class list for checkbox (dynamic checkboxes for category and class)
        $this->load->model('get_model','gm');
        $table_name='class';
        $field='class';
        $class = $this->gm->get_list($field,$table_name);

        $table_name =  'fees_head';
        $field = 'fees_heading';
        $this->load->model('get_model', 'gm');
        $fees_head_list = $this->gm->get_list($field,$table_name);
        $data=$this->input->post();
        unset($data['submit']);
//        print_r($data);
        $this->load->view('private/fees/fees_plan',['fhl'=>$fees_head_list,'category'=>$category,'class'=>$class]);

    }
    public function fees_plan_category(){
        $form_validation='fees_plan_category';
        $table_name='fees_plan_category';
        $view='fees_plan_category';
        $field='category_name';
        $this->insert_genric($form_validation,$table_name,$view,$field);
    }
    public function fees_plan_category_del()
    {
        $form_validation='fees_plan_category_del';
        $table_name='fees_plan_category';
        $view='fees/fees_plan_category';
        $field='category_name';
        $unset='del_category';
        $value_form='category_delete';
        $this->delete_genric($form_validation,$table_name,$view,$field,$unset,$value_form);
    }
    public function fees_receipt(){
        if ($this->form_validation->run('fees_receipt_search')) {
            $post = $this->input->post();
            unset($post['submit']);
            $admission_no = $post['admission_no'];
            $this->load->model('get_model', 'gm');
            $stu_det = $this->gm->admission_form_search($admission_no);
            $this->load->view('private/fees/fees_receipt', ['stu_det' => $stu_det]);
        } else {
            $this->load->model('get_model', 'gm');
            $stu_list = $this->gm->admission_form_search(0);
            $this->load->view('private/fees/fees_receipt', ['stu_det' => $stu_list]);
        }
    }
}
