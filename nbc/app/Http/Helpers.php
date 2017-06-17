<?php 

use Illuminate\Contracts\Encryption\DecryptException;

function HELPERDoubleEncrypt ($value) {
    $value = Crypt::encryptString($value);
    return Crypt::encryptString($value);
}
function HELPERDoubleDecrypt ($value) {

    try {
        $value = Crypt::decryptString($value);
        $value = Crypt::decryptString($value);
    } catch (DecryptException $e) {
        $value = "InvalidKey";
    }

    return $value;
}

function HELPERIdentifyCategory ($category) {
    $result;
    switch ($category) {
        case 1 :
            $result = 'Design, Animations and Multimedia';
            break;
        case 2 :
            $result = 'Web Development';
            break;
        case 3 :
            $result = 'Programming & IT';
            break;
        case 4 :
            $result = 'Software Development';
            break;
        case 5 :
            $result = 'Web Host & Server Management';
            break;
        case 6 :
            $result = 'Mobile Applications';
            break;
        case 7 :
            $result = 'Writing & Content';
            break;
        case 8 :
            $result = 'Administrative Support';
            break;
        case 9 :
            $result = 'Administrative Support';
            break;
        case 10 :
            $result = 'Sales & Marketing';
            break;
        case 11 :
            $result = 'Business Services';
            break;
        case 12 :
            $result = 'Finance & Management';
            break;
        case 13 :
            $result = 'Engineering, Manufacturing & Science';
            break;
        case 14 :
            $result = 'Translation & Languages';
            break;
        case 15 :
            $result = 'General Computer Skills';
            break;
        case 16 :
            $result = 'Journalist';
            break;
        default :
            $result ='';
            break;
    }
    return $result;
}
// simplier version xD
function HIS ($status) {
    $result;
    switch ($status) {
        case 1 : 
            $result = "draft";
            break;
        case 2 :
            $result = "published";
            break;
        case 3 :
            $result = "pre_screening";
            break;
        case 4 : 
            $result = "contract_signing";
            break;
        case 5 : 
            $result = "in_progress";
            break;
        case 6 : 
            $result = "closed";
            break;
        default :
            $result ='';
            break;
    }
    return $result;
}

function HELPERIdentifyStatus ($status) {
	$result;
	switch ($status) {
		case 1 : 
			$result = array("class" => "label-info", "status"=> "Draft", "_status" => "draft");
			break;
		case 2 :
			$result = array("class" => "label-success", "status"=> "Published", "_status" => "published");
			break;
        case 3 :
            $result = array("class" => "label-info", "status"=> "Pre-Screening", "_status" => "pre_screening");
            break;
        case 4 : 
            $result = array("class" => "label-primary", "status"=> "Contract Signing", "_status" => "contract_signing");
            break;
		case 5 : 
			$result = array("class" => "label-warning", "status"=> "In Progress", "_status" => "in_progress");
			break;
		case 6 : 
			$result = array("class" => "label-danger", "status"=> "Closed", "_status" => "closed");
			break;
        default :
            $result ='';
            break;
	}
	return $result;
}

function HELPERIdentifyViewUsingStatus ($status) {
    $result;
    switch ($status) {
        case 2 :
            $result = 'coordinator/projects/published/view';
            break;
        case 3 : 
            $result = 'coordinator/projects/prescreening/view';
            break;
        case 4 : 
            $result = 'coordinator/projects/contract/view';
            break;
        case 4 : 
            $result = 'coordinator/projects/progress/view';
            break;
        case 5 : 
            $result = 'coordinator/projects/closed/view';
            break;
        default :
            $result ='errors/404';
            break;
    }
    return $result;
}
?>