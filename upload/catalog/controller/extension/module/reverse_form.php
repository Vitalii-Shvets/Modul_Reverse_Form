<?php

class ControllerExtensionModuleReverseForm extends Controller
{
    public function index()
    {
        $this->load->language('extension/module/reverse_form');

        //Data Form
        $data['button_feedback'] = $this->language->get('button_feedback');
        $data['button_send'] = $this->language->get('button_send');
        $data['button_close'] = $this->language->get('button_close');
        $data['form_name'] = $this->language->get('form_name');
        $data['text_name'] = $this->language->get('text_name');
        $data['text_telephone'] = $this->language->get('text_telephone');
        $data['text_email'] = $this->language->get('text_email');
        $data['text_description'] = $this->language->get('text_description');
        $data['mask'] = ($this->config->get('reverse_form_mask')) ? $this->config->get('reverse_form_mask') : '';

        //Errors
        $data['name_error'] = $this->language->get('name_error');
        $data['tel_error'] = $this->language->get('tel_error');
        $data['email_error'] = $this->language->get('email_error');

        //Front validate
        $data['front_validate'] = true;

        return $this->load->view('extension/module/reverse_form', $data);
    }


    public function send()
    {

        $json = array();
        $this->language->load('extension/module/reverse_form');
        $this->load->model('extension/module/reverse_form');

        $data = $this->request->post;

        if (utf8_strlen(trim($data['name'])) < 1) {
            $json['error']['name'] = $this->language->get('name_error');
        }

        $phone_count = utf8_strlen(str_replace(array('_', '-', '(', ')', '+', ' '), "", $this->config->get('reverse_form_mask')));
        if (utf8_strlen(str_replace(array('_', '-', '(', ')', '+', ' '), "", $this->request->post['tel'])) < $phone_count) {
            $json['error']['tel'] = $this->language->get('tel_error');
        }
//
//        if (utf8_strlen(trim($this->request->post['email']))!='') {
//            $rv_email = '/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/';
//            if (!preg_match($rv_email, $this->request->post['email'])) {
//                $json['error']['email'] = $this->language->get('email_error');
//            }
//        }

        if (!isset($json['error'])) {
            $this->model_extension_module_reverse_form->addRequest($data);
        }


        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }


}