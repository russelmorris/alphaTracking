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

    public function twigTemplate($templateName, $vars = array(), $return = false)
    {
        if($return) {
            $content = $this->view( "include/v_header", $vars, $return);
            $content .= $this->view( "include/v_navigation", $vars, $return);
            $content .= $this->twigView( "partial/" . $templateName, $vars, $return);
            $content .= $this->view( "include/v_footer", $vars, $return);

            return $content;
        }else {

            $this->view( "include/v_header", $vars);
            $this->view( "include/v_navigation", $vars, $return);
            $this->twigView( "partial/" . $templateName, $vars);
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

    public function twigView($template, $data = array(), $return = FALSE) {
        $CI =& get_instance();

        try {
            $output = $CI->twig->render($template, $data);
        } catch (Exception $e) {
            show_error(htmlspecialchars_decode($e->getMessage()), 500, 'Twig Exception');
        }

        // Return the output if the return value is TRUE.
        if ($return === TRUE) {
            return $output;
        }

        // Otherwise append to output just like a view.
        $CI->output->append_output($output);
    }

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