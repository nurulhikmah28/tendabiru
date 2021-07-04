<?php
error_reporting(0);
function kirim_email($email, $subject, $message)
{
    $ci = get_instance();
    $ci->load->library('email');
    $config['protocol'] = "smtp";
    $config['smtp_host'] = "smtp.gmail.com";
    $config['smtp_crypto'] = "tls";
    $config['smtp_port'] = "587";
    $config['smtp_user'] = "deashafiras@gmail.com ";
    $config['smtp_pass'] = "1234567890";
    $config['charset'] = "iso-8859-1";
    $config['mailtype'] = "html";
    $config['newline'] = "\r\n";
    $ci->email->initialize($config);
    $ci->email->from('deashafiras@gmail.com ', "Saung Biru Tenda");
    $ci->email->to("$email");
    $ci->email->subject("$subject");
    $ci->email->message("$message");
    $ci->email->send();
}
