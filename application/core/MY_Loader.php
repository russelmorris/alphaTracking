<?php

class MY_Loader extends CI_Loader {

	public function template($templateName, $vars = array(), $return = false)
	{
		if($return) {
            $content = $this->view( "include/v_header", $vars, $return);
            $content .= $this->view( "include/v_navigation", $vars, $return);
            $content .= $this->view( "partial/" . $templateName, $vars, $return);
            $content .= $this->view( "include/v_footer", $vars, $return);

            return $content;
        }else {

            $this->view( "include/v_header", $vars);
            $this->view( "include/v_navigation", $vars, $return);
            $this->view( "partial/" . $templateName, $vars);
            $this->view( "include/v_footer", $vars);
        }
        return true;
	}

//    public function singleView($templateName, $vars = array(), $return = false)
//    {
//
//        if($return === true) {
//            $content = $this->view(TEMPLATE_PATH . "partial/".$templateName, $vars, $return);
//
//            return $content;
//        }else {
//
//            $this->view(TEMPLATE_PATH . "partial/".$templateName, $vars, $return);
//        }
//        return true;
//    }
//
//    public function email_template($templateName, $vars = array(), $return = false)
//    {
//        if($return) {
//            $content = $this->view(TEMPLATE_PATH . "partial/emails/email_header", $vars, $return);
//            $content .= $this->view(TEMPLATE_PATH . "partial/" . $templateName, $vars, $return);
//            $content .= $this->view(TEMPLATE_PATH . "partial/emails/email_footer", $vars, $return);
//
//            return $content;
//        }else {
//
//            $this->view(TEMPLATE_PATH . "partial/emails/email_header", $vars);
//            $this->view(TEMPLATE_PATH . "partial/" . $templateName, $vars);
//            $this->view(TEMPLATE_PATH . "partial/emails/email_footer", $vars);
//        }
//        return true;
//    }

	public function admin($templateName, $vars = array(), $return = false)
	{
		if($return) {
            $content = $this->view(TEMPLATE_ADMIN_PATH . "partial/v_header", $vars, $return);
            $content .= $this->view(TEMPLATE_ADMIN_PATH . "partial/" . $templateName, $vars, $return);
            $content .= $this->view(TEMPLATE_ADMIN_PATH . "partial/v_footer", $vars, $return);

            return $content;
        } else {
            $this->view(TEMPLATE_ADMIN_PATH . "partial/v_header", $vars);
            $this->view(TEMPLATE_ADMIN_PATH . "partial/" . $templateName, $vars);
            $this->view(TEMPLATE_ADMIN_PATH . "partial/v_footer", $vars);

        }
        return true;
	}
}