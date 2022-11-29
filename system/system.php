<?php
class system {

    private $_url;
    private $_explode;
    protected $_controller;
    protected $_action;
    protected $_params;
    protected $_layout;
    
    public function __construct() { 
        $this->setUrl();
        $this->setExplode();
        $this->setController();
        $this->setAction();
        $this->setParams(); 
    }
    
    private function setUrl() {
        $string = str_replace(array("<", ">", "\\", "=", "?", "#"), "", $_GET['url']);
        $string = trim($string);
        $string = strip_tags($string);
        $string = addslashes($string);
        $string = ($string == null ? 'index' : $string);
        $string = ($string == 'inicial' ? 'index' : $string);
        $string = ($string == 'inicial/' ? 'index' : $string);
        $this->_url = $string;
    }
    
    private function setExplode(){
        $this->_explode = explode('/', $this->_url);
    }

    private function setController(){
        $this->_controller = $this->_explode[0];
        $this->_layout = $this->_explode[0];
    }

    private function setAction(){
        $string = (!isset($this->_explode[1]) || $this->_explode == "inicial" ? "inicial" : $this->_explode[1]);
        $string = ($string == null ? 'inicial' : $string);
        $this->_action = $string;
    }

    private function setParams(){
        unset($this->_explode[0], $this->_explode[1] );
        
        if( end($this->_explode) == null ) array_pop( $this->_explode );

        $i = 0;
        if( !empty($this->_explode) ){
            foreach ( $this->_explode as $val) {
                if( $i % 2 == 0 ){
                    $ind[] = $val;
                } else {
                    $value[] = $val;
                }
                $i++;
            }
        } else {
            $ind = array();
            $value = array();
        }

        if( isset($ind) AND isset($value) ){
            if( count($ind) == count($value) && !empty($ind) && !empty($value)){
                $this->_params = array_combine($ind, $value);
            } else {
                $this->_params = array();
            }
        } else {
            $this->_params = array();
        }
    }

    protected function get($name){
        if(isset($this->_params[$name])){
            return $this->_params[$name];
        } else {
            return '';
        }
    }
    
    protected function post($name){
        if(isset($_POST[$name])){
            $string = str_replace(array("<", ">", "\\", "//", "#"), "", $_POST[$name]); 
            $string = strip_tags($string);
            $string = addslashes($string);
            return trim($string);
        } else {
            return '';
        }
    }
    
    protected function post_htm($name){
        if(isset($_POST[$name])){
            if(htmlspecialchars($_POST[$name])){
                $retorno = htmlspecialchars($_POST[$name]);
                return htmlspecialchars_decode($retorno);
            } else {
                return '';
            }
        } else {
            return '';
        }
    }
    
    protected function post_html($name){
        if(htmlspecialchars($_POST[$name])){
            $retorno = htmlspecialchars($_POST[$name]);
            return htmlspecialchars_decode($retorno);
        } else {
            return '';
        }
    }
    
    protected function irpara($endereco, $destino = '_self'){
        echo "<script> window.open('".$endereco."', target='$destino');</script>";
        exit;
    }
    protected function p($p, $exit = 1){
        echo '<pre>';
        print_r($p);
        echo '</pre>';
        if ($exit == 1)
        {
            exit;
        }
    }

    protected function volta($n){
        echo "<script> history.go(-".$n."); </script>";
        exit;
    }

    protected function msg($msg){
        echo "<script> alert('".$msg."'); </script>";
    }
    
    protected function erro(){
        $this->irpara(DOMINIO.'erro');
        exit;
    }
    
    public function run(){
        
        $controllers_path = CONTROLLERS.'controller_'.$this->_controller.'.php';
        
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //teste de url
        // echo "Controller: $this->_controller <br> Action = $this->_action <br></br> Parametros: "; print_r($this->_params); exit;
        // echo $controllers_path; exit;
        
        
        //aciona gerenciador ou blog
        if($this->_controller == 'sistema'){
            $this->irpara(DOMINIO.'sistema/index.php');
            exit;
        }
        // sitemap
        if($this->_controller == 'sitemap'){            
            $this->_controller = "index";
            $this->_action = "sitemap";
            $controllers_path = CONTROLLERS.'controller_'.$this->_controller.'.php';
        }
        
        
        if(!file_exists($controllers_path)){
            
            $this->_controller = "index";
            $controllers_path = CONTROLLERS.'controller_'.$this->_controller.'.php';
            require_once($controllers_path);
            $app = new $this->_controller();
            $app->init();
            $action = $this->_action;
            if(!method_exists($app, $action) ){
                $this->erro();
            } else {
                $app->$action();
            }

        } else {

            $this->_layout = 'index';
            require_once($controllers_path);
            $app = new $this->_controller();
            echo'<pre>';print_r('aq2');exit;
            $app->init();
            $action = $this->_action;
            if(!method_exists($app, $action) ){
               $this->erro();
           } else {
            $app->$action();
        }
    }
}
}