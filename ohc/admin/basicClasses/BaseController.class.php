<?php

class BaseController {

    protected $templateTool;

    public function __construct($templateTool) {
        $this->templateTool = $templateTool;
        header("Content-Type: text/html;charset=utf-8");
    }

    public function display() {
        $this->templateTool->display($this->templateFile);
    }

    public function assign($name, $value) {
        $this->templateTool->assign($name, $value);
    }

    public function getTemplateFile() {
        return $this->templateFile;
    }

    public function setBaseTemplate($templateFile) {
        $this->templateFile = $templateFile;
    }

    public function jsJump($url, $msg) {
        if ($url == -1) {
            exit('<script>alert("' . $msg . '");history.go(-1);</script>');
        }
        else
            exit('<script>alert("' . $msg . '");window.location.href="' . $url . '";</script>');
    }

}

?>