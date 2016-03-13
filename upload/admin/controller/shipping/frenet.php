<?php
class ControllerShippingfrenet extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('shipping/frenet');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('frenet', $this->request->post);		
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->response->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');

        $data['entry_msg_prazo'] = $this->language->get('entry_msg_prazo');
        $data['entry_frenet_key'] = $this->language->get('entry_frenet_key');
        $data['entry_frenet_key_codigo'] = $this->language->get('entry_frenet_key_codigo');
        $data['entry_frenet_key_senha'] = $this->language->get('entry_frenet_key_senha');

		$data['entry_cost'] = $this->language->get('entry_cost');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');


		$data['help_frenet_key'] = $this->language->get('help_frenet_key');
        $data['help_msg_prazo'] = $this->language->get('help_msg_prazo');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		$data['tab_general'] = $this->language->get('tab_general');
		
		$data['entry_postcode']= $this->language->get('entry_postcode');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->error['postcode'])) {
			$data['error_postcode'] = $this->error['postcode'];
		} else {
			$data['error_postcode'] = '';
		}

		$data['breadcrumbs'] = array();
   		
   		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
   		);
   		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_shipping'),
			'href' => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL')
   		);
   		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('shipping/frenet', 'token=' . $this->session->data['token'], 'SSL')
   		);
		
   		$data['action'] = $this->url->link('shipping/frenet', 'token=' . $this->session->data['token'], 'SSL');
		
   		$data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->post['frenet_status'])) {
			$data['frenet_status'] = $this->request->post['frenet_status'];
		} else {
			$data['frenet_status'] = $this->config->get('frenet_status');
		}
		if (isset($this->request->post['frenet_tax_class_id'])) {
			$data['frenet_tax_class_id'] = $this->request->post['frenet_tax_class_id'];
		} else {
			$data['frenet_tax_class_id'] = $this->config->get('frenet_tax_class_id');
		}
		if (isset($this->request->post['frenet_geo_zone_id'])) {
			$data['frenet_geo_zone_id'] = $this->request->post['frenet_geo_zone_id'];
		} else {
			$data['frenet_geo_zone_id'] = $this->config->get('frenet_geo_zone_id');
		}
		if (isset($this->request->post['frenet_postcode'])) {
			$data['frenet_postcode'] = $this->request->post['frenet_postcode'];
		} else {
			$data['frenet_postcode'] = $this->config->get('frenet_postcode');
		}
        if (isset($this->request->post['frenet_msg_prazo'])) {
            $data['frenet_msg_prazo'] = $this->request->post['frenet_msg_prazo'];
        } else {
            $data['frenet_msg_prazo'] = $this->config->get('frenet_msg_prazo');
        }

		if (isset($this->request->post['frenet_contrato_codigo'])) {
			$data['frenet_contrato_codigo'] = $this->request->post['frenet_contrato_codigo'];
		} else {
			$data['frenet_contrato_codigo'] = $this->config->get('frenet_contrato_codigo');
		}
		if (isset($this->request->post['frenet_contrato_senha'])) {
			$data['frenet_contrato_senha'] = $this->request->post['frenet_contrato_senha'];
		} else {
			$data['frenet_contrato_senha'] = $this->config->get('frenet_contrato_senha');
		}						

		if (isset($this->request->post['frenet_sort_order'])) {
			$data['frenet_sort_order'] = $this->request->post['frenet_sort_order'];
		} else {
			$data['frenet_sort_order'] = $this->config->get('frenet_sort_order');
		}
		$this->load->model('localisation/tax_class');
		
		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
		
		$this->load->model('localisation/geo_zone');
		
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		if (version_compare(VERSION, '2.2') < 0) {
			$this->response->setOutput($this->load->view('shipping/frenet.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('shipping/frenet', $data));
		}
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/frenet')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}
?>