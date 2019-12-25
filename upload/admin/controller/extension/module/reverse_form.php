<?php

class ControllerExtensionModuleReverseForm extends Controller
{
    private $error = array();

    public function index()
    {

        $this->load->language('extension/module/reverse_form');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('reverse_form', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['entry_status'] = $this->language->get('entry_status');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['menu_setting'] = $this->language->get('menu_setting');
        $data['menu_list'] = $this->language->get('menu_list');
        $data['text_no_results'] = $this->language->get('text_no_results');

        $data['column_action'] = $this->language->get('column_action');
        $data['column_info'] = $this->language->get('column_info');
        $data['column_date_added'] = $this->language->get('column_date_added');

        $data['name'] = $this->language->get('name');
        $data['phone'] = $this->language->get('phone');
        $data['email'] = $this->language->get('email');
        $data['description'] = $this->language->get('description');

        $data['token'] = $this->session->data['token'];


        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/reverse_form', 'token=' . $this->session->data['token'], true)
        );

        $data['action'] = $this->url->link('extension/module/reverse_form', 'token=' . $this->session->data['token'], true);

        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

        if (isset($this->request->post['reverse_form_status'])) {
            $data['reverse_form_status'] = $this->request->post['reverse_form_status'];
        } else {
            $data['reverse_form_status'] = $this->config->get('reverse_form_status');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->load->model('catalog/reverse_form');

        $results = $this->model_catalog_reverse_form->getCallArray();

        foreach ($results as $result) {

            $data['histories'][] = array(
                'id' => $result['id'],
                'name' => $result['name'],
                'phone' => $result['phone'],
                'email' => $result['email'],
                'description' => $result['description'],
                'date_add' => $result['date_added'],
            );
        }

        $this->response->setOutput($this->load->view('extension/module/reverse_form.tpl', $data));

    }

    public function delete_selected()
    {
        $json = array();
        $this->load->model('catalog/reverse_form');

        if ($this->model_catalog_reverse_form->getCall((int)$this->request->get['delete'])) {
            $this->model_catalog_reverse_form->deleteCall((int)$this->request->get['delete']);
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }


    public function install()
    {
        $this->load->language('extension/module/reverse_form');
        $this->load->model('catalog/reverse_form');
        $this->load->model('extension/extension');
        $this->load->model('setting/setting');
        $this->load->model('user/user_group');

        $this->model_user_user_group->addPermission($this->user->getId(), 'access', 'extension/module/reverse_form');
        $this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'extension/module/reverse_form');

        $this->model_catalog_reverse_form->makeDB();

        $this->model_setting_setting->editSetting('reverse_form', array(
            'reverse_form_status' => '1',
            'reverse_form_mask' => '+38 (999) 999-99-99'
        ));

        if (!in_array('reverse_form', $this->model_extension_extension->getInstalled('module'))) {
            $this->model_extension_extension->install('module', 'reverse_form');
        }

        $this->session->data['success'] = $this->language->get('text_success_install');
    }


    public function uninstall()
    {
        $this->load->model('extension/extension');
        $this->load->model('setting/setting');
        $this->load->model('catalog/reverse_form');

        $this->model_catalog_reverse_form->deleteDB();
        $this->model_extension_extension->uninstall('module', 'reverse_form');
        $this->model_setting_setting->deleteSetting('reverse_form');
    }


    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/module/reverse_form')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }
}