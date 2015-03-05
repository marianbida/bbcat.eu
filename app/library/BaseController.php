<?php

    class ModelComposite
	{
		private $store;
		
		public function __get($key)
		{
			if (!isset($this->store->$key)) {
				$this->store->$key = Registry::get($key);
			}
			return $this->store->$key;
		}
	}
	
	class Request
	{
		public $post;
		public $get;
		
		public function __construct()
		{
			$this->post = $_POST;
			$this->get = $_GET;
		}
	}
	
	class Response
	{
		
	}
	

	class BaseController
	{
		protected $model;
		protected $request;
		protected $response;
		
		protected $template;
		
		public function getTemplate()
		{
			return $this->template;
		}
		
		public function setTemplate($template = null)
		{
			$this->template = $template;
		}
		
		public function __construct()
		{
			$this->model = new ModelComposite();
			$this->request = new Request();
			$this->response = new Response();
		}
	}