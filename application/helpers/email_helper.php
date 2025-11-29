<?php 
	if(!defined('BASEPATH')) exit('No direct script access allowed');
	if(!function_exists('sendemail')) {
  		function sendemail($email,$subject,$message,$fieldname=false,$upload_path=false,$allowed_types=false,$file_name=false) {
    		// Getting CI class instance.
    		$CI = get_instance();
			if(!$CI->load->is_loaded('email')){
				$CI->load->library('email');
			} 
			if(!function_exists('upload')){
				$CI->load->helper('upload');
			} 
			$from="hello@studionineconstructions.com";
			if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST']=='localhost'){
				ini_set('smtp','localhost');
				ini_set('smtp_port',25);
				
				$config['protocol']='smtp';
				$config['smtp_host']='';
				$config['smtp_port']='465';
				$config['smtp_timeout']='30';
				$config['smtp_user']='';
				$config['smtp_pass']='';
				$from=$config['smtp_user'];
			}
            elseif($CI->input->get('test')=='test'){
                $config['mailpath']= "/usr/bin/sendmail";
                $config['protocol'] = 'smtp';
                $config['smtp_host'] = 'smtp.gmail.com';
                $config['_smtp_auth'] = TRUE;
                $config['smtp_port'] = '587';
                $config['smtp_crypto'] = 'tls';
                $config['smtp_user'] = 'hello@studionineconstructions.com';
                $config['smtp_pass'] = 'Hello$1234';
                $config['charset'] = 'iso-8859-1';
                $config['smtp_timeout'] = 15;
				$from=$config['smtp_user'];
			}
			
			$config['newline']="\r\n";
			$config['wordwrap'] = TRUE;
			//$config['charset'] = 'iso-8859-1';
            $config['charset'] = 'utf-8';
			$config['mailtype'] = "html";
			if($CI->input->get('test')=='test'){
                print_pre($config);
            }
            
            //$CI->load->library('email',$config);
            //getmethods();
            //$CI->email->set_newline("\r\n");
            //$CI->email->set_wordwrap(TRUE); // Enable word wrapping
            //$CI->email->set_mailtype('html'); // Set mailtype to HTML
			//print_pre($config,true);
			$CI->email->initialize($config);
			$CI->email->from($from,SITE_SALT);
            $CI->email->set_newline("\r\n");
            $CI->email->set_header('Return-Path', $from);
			$CI->email->to($email);
			$CI->email->subject($subject);
			$CI->email->message($message);
            
            // Add the List-Unsubscribe header
            $CI->email->set_header('List-Unsubscribe', '<mailto:hello@studionineconstructions.com?subject=Unsubscribe>, <https://crm.studionineconstructions.com/unsubscribe>');

			
			if($fieldname!==false && $upload_path!==false && $allowed_types!==false){
				if($file_name===false){
					$file_name=$fieldname.'-attachment';
				}
				if(is_array($_FILES[$fieldname]['name'])){
					$count=count($_FILES[$fieldname]['name']);
					for($i=0; $i<$count; $i++) {
						if(is_uploaded_file($_FILES[$fieldname]['tmp_name'][$i])){
							$_FILES['multi']['name']     = $_FILES[$fieldname]['name'][$i];
							$_FILES['multi']['type']     = $_FILES[$fieldname]['type'][$i];
							$_FILES['multi']['tmp_name'] = $_FILES[$fieldname]['tmp_name'][$i];
							$_FILES['multi']['error']     = $_FILES[$fieldname]['error'][$i];
							$_FILES['multi']['size']     = $_FILES[$fieldname]['size'][$i];
								
							$attachment=upload_file('multi',$upload_path,$allowed_types,$file_name);
							$CI->email->attach(file_url($attachment));
							$attachment='.'.$attachment;
							if(file_exists($attachment)){
								unlink($attachment);
							}
						}
					}
				}
				else{
					$attachment=upload_file($fieldname,$upload_path,$allowed_types,$file_name);
					$CI->email->attach(file_url($attachment));
					$attachment='.'.$attachment;
					if(file_exists($attachment)){
						unlink($attachment);
					}
				}
			}
			if($CI->email->send()){
                if($CI->input->get('test')=='test' || $CI->input->get('test')=='tests'){
                    echo "<br><br><br>Mail sent to $email!<br><br><br>";
                    print_pre($CI->email);
                }
				return true;
			}
			else{
                if($CI->input->get('test')=='test' || $CI->input->get('test')=='tests'){
                    echo "<br><br><br>Mail Not sent!<br><br><br>";
                    print_pre($CI->email);
                }
				return false;
			}
		}  
	}

    if(!function_exists('agentmail')) {
  		function agentmail($agentname,$agentemail,$name,$mobile,$service){
            $subject="Action Required: New Lead Assignment - $name";
            $message='<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Short HTML Email</title>
</head>
<body><table id="v1container" cellspacing="0" cellpadding="0" border="0">
    <tbody>
        <tr>
            <td id="v1container-cell" align="center" style="border: 1px solid">
                <table id="v1header-container" cellspacing="0" cellpadding="15" border="0" width="100%">
                    <tbody>
                        <tr>
                            <td id="v1header-logo-cell" colspan="4">
                                <a href="https://crm.studionineconstructions.com/" target="_blank" rel="noreferrer">
                                    <img src="https://crm.studionineconstructions.com/assets/images/studio-nine.png" alt="StudioNine Logo">
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td height="8" colspan="4" style="font-size: 1px; line-height: 1px">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
                <table cellspacing="0" cellpadding="15" border="0">
                    <tbody>
                        <td>
                            <h5>Dear '.$agentname.',</h5>
                             <p>I hope this email finds you well. I am pleased to inform you that we have a new lead in our pipeline who shows great potential for our service. We believe that this lead aligns with our target audience and objectives, and we\'re excited to have the opportunity to work with them.</p>

                            <p><strong>Lead details:</strong></p>

                            <p><strong>Name:</strong> '.$name.'</p>
                            <p><strong>Mobile No:</strong> '.$mobile.'</p>
                            <p><strong>Service Type:</strong> '.$service.'</p>

                            <p>Please take the necessary actions and update the same in CRM.</p>

                            <p>Regards, </p>
                            <p><strong>Studio Nine Reality Pvt Ltd</strong></p>
                            <p>--------------------</p>
                            <p>Note: This notification is auto-generated for new leads. For any concerns or clarifications, please contact the CRM admin or the designated representative.</p>
                        </td>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
</body>
</html>';
            
            sendemail($agentemail,$subject,$message);
		}  
	}
    if(!function_exists('adminmail')) {
  		function adminmail($adminname,$adminemail,$name,$mobile,$service,$source){
            $subject="Your New Lead: $name - Take the Next Step";
            $message='<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Short HTML Email</title>
</head>
<body><table id="v1container" cellspacing="0" cellpadding="0" border="0">
    <tbody>
        <tr>
            <td id="v1container-cell" align="center" style="border: 1px solid">
                <table id="v1header-container" cellspacing="0" cellpadding="15" border="0" width="100%">
                    <tbody>
                        <tr>
                            <td id="v1header-logo-cell" colspan="4">
                                <a href="https://crm.studionineconstructions.com/" target="_blank" rel="noreferrer">
                                    <img src="https://crm.studionineconstructions.com/assets/images/studio-nine.png" alt="StudioNine Logo">
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td height="8" colspan="4" style="font-size: 1px; line-height: 1px">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
                <table cellspacing="0" cellpadding="15" border="0">
                    <tbody>
                        <td>
                            <h5>Dear '.$adminname.',</h5>
                             <p>I hope this message finds you well. We\'re excited to inform you that an automatic lead generation has resulted in a new lead being assigned to you within our CRM system. We value your swift attention and engagement with this lead.</p>

                            <p><strong>Lead details:</strong></p>

                            <p><strong>Source:</strong> '.$source.'</p>
                            <p><strong>Name:</strong> '.$name.'</p>
                            <p><strong>Mobile No:</strong> '.$mobile.'</p>
                            <p><strong>Service Type:</strong> '.$service.'</p>

                            <p>We kindly request you to take the appropriate actions and ensure updates are recorded in the CRM.</p>
                            
                            <p>Your prompt attention to this lead is greatly appreciated, as it represents an exciting opportunity for our organization. Thank you for your commitment to our continued growth and success.</p>
                            <p>Warm Regards,</p>
                            <p><strong>Studio Nine Reality Pvt Ltd</strong></p>
                            <p>--------------------</p>
                            <p>Note: This notification is auto-generated for new leads. For any concerns or clarifications, please contact the CRM admin or the designated representative.</p>
                        </td>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
</body>
</html>';
            
            sendemail($adminemail,$subject,$message);
		}  
	}
?>
