<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class settings extends Admin_Controller {

	//--------------------------------------------------------------------

	public function __construct() 
	{
		parent::__construct();
        
        $this->auth->restrict('Analytics.Settings.View');
        
        $this->load->config('analytics');
        $this->load->library('form_validation');
		$this->lang->load('analytics');
		Assets::add_js($this->load->view('settings/js', null, true), 'inline');
		
		
	}
	
	//--------------------------------------------------------------------

	/*
		Method: index()
		
		Displays a list of form data.
	*/
	public function index() 
	{
		$ga_username=$this->config->item('username');
        $ga_password=$this->config->item('password');
        $ga_enabled=$this->config->item('enabled');
        $ga_profile=$this->config->item('profile');
        Template::set('ga_username',$ga_username);
        Template::set('ga_password',$ga_password);
        Template::set('ga_enabled',$ga_enabled);
        Template::set('ga_profile',$ga_profile);
		Template::set('toolbar_title','Google Analytics');
		Template::render();
	}
    public function edit()
    {
        if ($this->input->post('submit'))
		{
			if ($this->save_settings())
			{
				Template::set_message(lang("settings_edit_success"), 'success');
                Template::redirect('admin/settings/analytics');
			}
			else 
			{
				Template::set_message('Error', 'error');
			}
		}
		
		
	
		Template::set('toolbar_title', "Google Analytics");
		Template::set_view('settings/index');
		Template::render();		
    }
    
    public function save_settings()
    {
        $this->form_validation->set_rules('ga_username','Username','valid_email|required|trim|xss_clean|max_length[100]');			
		$this->form_validation->set_rules('ga_password','Password','required|trim|xss_clean|max_length[100]');
        $this->form_validation->set_rules('ga_enabled','Enabled','required|trim|xss_clean|max_length[1]');			
		if ($this->input->post('ga_enabled')!=0)
            {
                $this->form_validation->set_rules('ga_profile','Profile id','required|trim|xss_clean|max_length[100]');
            }
        if ($this->form_validation->run() === false)
		{
			return false;
		}else
        {
            $this->load->helper('config_file');
            $config['username']=$this->input->post('ga_username');
            $config['password']=$this->input->post('ga_password');
            $config['enabled']=$this->input->post('ga_enabled');
            $config['profile']=$this->input->post('ga_profile');
            write_config('analytics',$config);
            return true;
        }
    }

}