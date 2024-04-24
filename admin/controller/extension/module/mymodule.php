<?php
class ControllerExtensionModuleMymodule extends Controller {
    private $error = array();

    public function index() {
    $this->load->language('extension/module/mymodule');
    $this->document->setTitle($this->language->get('heading_title'));

    $data['breadcrumbs'] = array();

    $data['breadcrumbs'][] = array(
        'text' => $this->language->get('text_home'),
        'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
    );

    $data['breadcrumbs'][] = array(
        'text' => $this->language->get('heading_title'),
        'href' => $this->url->link('extension/module/mymodule', 'user_token=' . $this->session->data['user_token'], true)
    );

    $data['action'] = $this->url->link('extension/module/mymodule/install', 'user_token=' . $this->session->data['user_token'], true);
    $data['uninstall'] = $this->url->link('extension/module/mymodule/uninstall', 'user_token=' . $this->session->data['user_token'], true);
    $data['back'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], true);

    $data['header'] = $this->load->controller('common/header');
    $data['column_left'] = $this->load->controller('common/column_left');
    $data['footer'] = $this->load->controller('common/footer');

    $this->response->setOutput($this->load->view('extension/module/mymodule', $data));
}


    public function install() {
        $this->load->model('extension/module/mymodule');
        $this->model_extension_module_mymodule->install();
        $this->session->data['success'] = $this->language->get('text_success_install');
        $this->response->redirect($this->url->link('extension/module/mymodule', 'user_token=' . $this->session->data['user_token'], true));
    }

    public function uninstall() {
        $this->load->model('extension/module/mymodule');
        $this->model_extension_module_mymodule->uninstall();
        $this->session->data['success'] = $this->language->get('text_success_uninstall');
        $this->response->redirect($this->url->link('extension/module/mymodule', 'user_token=' . $this->session->data['user_token'], true));
    }
}
