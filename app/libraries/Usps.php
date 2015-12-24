<?php
namespace App\Libraries;

use Session;use DB;
use Cart;

class Usps  {

	function USPSLabel($parameters_array){


		$user = '293TESTC3874';
	
	
		$xml_data="<DelivConfirmCertifyV4.0Request USERID='$user'>".
		"<Revision>2</Revision>".
		"<ImageParameters />".
		"<FromName>".$parameters_array['FromName']."</FromName>".
		"<FromFirm>USPS</FromFirm>".
		"<FromAddress1>".$parameters_array['FromAddress1']."</FromAddress1>".
		"<FromAddress2>".$parameters_array['FromAddress2']."</FromAddress2>".
		"<FromCity>".$parameters_array['FromCity']."</FromCity>".
		"<FromState>".$parameters_array['FromState']."</FromState>".
		"<FromZip5>".$parameters_array['FromZip5']."</FromZip5>".
		"<FromZip4/>".
		"<ToName>".$parameters_array['ToName']."</ToName>".
		"<ToFirm>".$parameters_array['ToFirm']."</ToFirm>".
		"<ToAddress1>".$parameters_array['ToAddress1']."</ToAddress1>".
		"<ToAddress2>".$parameters_array['ToAddress2']."</ToAddress2>".
		"<ToCity>".$parameters_array['ToCity']."</ToCity>".
		"<ToState>".$parameters_array['ToState']."</ToState>".
		"<ToZip5>".$parameters_array['ToZip5']."</ToZip5>".
		"<ToZip4 />".
		"<ToPOBoxFlag></ToPOBoxFlag>".
		"<WeightInOunces>".$parameters_array['WeightInOunces']."</WeightInOunces>".
		"<ServiceType>".$parameters_array['ServiceType']."</ServiceType>".

		"<SeparateReceiptPage>False</SeparateReceiptPage>".
		"<POZipCode>20770</POZipCode>".
		"<ImageType>TIF</ImageType>".
		"<AddressServiceRequested>False</AddressServiceRequested>".
		"<HoldForManifest>N</HoldForManifest>".
		"<Container>NONRECTANGULAR</Container>".
		"<Size>".$parameters_array['Size']."</Size>".
		"<Width>".$parameters_array['Width']."</Width>".
		"<Length>".$parameters_array['Length']."</Length>".
		"<Height>".$parameters_array['Height']."</Height>".
		"<Girth>".$parameters_array['Girth']."</Girth>".
		"<ReturnCommitments>true</ReturnCommitments>".
		"</DelivConfirmCertifyV4.0Request>";



		//$url = "http://Production.ShippingAPIs.com/ShippingAPI.dll";
		//$url = "http://production.shippingapis.com/ShippingAPITest.dll";
		// $url='http://stg-production.shippingapis.com/ShippingAPI.dll';
		// $url='https://secure.shippingapis.com/ShippingAPI.dll';
		// $url='http://production.shippingapis.com/ShippingAPITest.dll';

		// $url = "http://production.shippingapis.com/ShippingAPITest.dll?API=CityStateLookup";
		$url = "https://secure.shippingapis.com/ShippingAPI.dll?API=DelivConfirmCertifyV4";

		  $output=$this->callCurl($url,$xml_data);

		

		$array_data = json_decode(json_encode(simplexml_load_string($output)), true);

		$labelfile=$this->generateLabel($array_data);
		
	
	}
	
private function callCurl($url,$data){
	
		//setting the curl parameters.
		    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, $url);
		    // Following line is compulsary to add as it is:
		    curl_setopt($ch, CURLOPT_POSTFIELDS,'XML=' . $data);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
		    $output = curl_exec($ch);
		    curl_error($ch);
		    curl_close($ch);
		    return $output;
	}	
	
private function generateLabel($hasdata){
	
		$filecontent=base64_decode($hasdata['DeliveryConfirmationLabel']);
		//file_put_contents('my.pdf', $binary);
		//echo "<pre>";print_r($array_data);exit;
		
		
		/*
		$contents = base64_decode($filecontent);
		header('Content-type: application/pdf');
		header('Content-Disposition: inline; filename="label.pdf"');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . strlen($contents));
		echo $contents;
		*/
		
		$label_title = 'label_'.uniqid().'.pdf';
		
		$file=fopen($label_title,"w");
		
		fwrite($file,$filecontent);
		fclose($file);
		return $label_title;
		
	}

}
?>