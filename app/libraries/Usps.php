<?php
namespace App\Libraries;

use Session;use DB;
use Cart;

class Usps  {

	function USPSLabel($parameters_array){


		$user = env('USERID');

		$xml_data="<DelivConfirmCertifyV4.0Request USERID='$user'>".

		
		$xml_data="<DelivConfirmCertifyV4.0Request USERID=".env('USERID').">".

		"<Revision>2</Revision>".
		"<ImageParameters />".
		"<FromName>".env('FROMNAME')."</FromName>".
		"<FromFirm>".env('FROMFIRM')."</FromFirm>".
		"<FromAddress1>".env('FROMADDRESS1')."</FromAddress1>".
		"<FromAddress2>".env('FROMADDRESS2')."</FromAddress2>".
		"<FromCity>".env('FROMCITY')."</FromCity>".
		"<FromState>".env('FROMSTATE')."</FromState>".
		"<FromZip5>".env('FROMZIP5')."</FromZip5>".
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
		"<WeightInOunces>10</WeightInOunces>".
		"<ServiceType>PRIORITY</ServiceType>".

		"<SeparateReceiptPage>False</SeparateReceiptPage>".
		
		"<ImageType>TIF</ImageType>".
		"<AddressServiceRequested>False</AddressServiceRequested>".
		"<HoldForManifest>N</HoldForManifest>".
		//"<Container>NONRECTANGULAR</Container>".
	//	"<Size>".$parameters_array['Size']."</Size>".
	//	"<Width>".$parameters_array['Width']."</Width>".
	//	"<Length>".$parameters_array['Length']."</Length>".
	//	"<Height>".$parameters_array['Height']."</Height>".
	//	"<Girth>".$parameters_array['Girth']."</Girth>".
		"<ReturnCommitments>true</ReturnCommitments>".
		"</DelivConfirmCertifyV4.0Request>";



		$url = "https://secure.shippingapis.com/ShippingAPI.dll?API=DelivConfirmCertifyV4";

		  $output=$this->callCurl($url,$xml_data);

		

		$array_data = json_decode(json_encode(simplexml_load_string($output)), true);

		$labelfile=$this->generateLabel($array_data,$parameters_array['order_id']);
		
	
	}
	
public function trackrequest($parameters_array){


		$user = $parameters_array['user'];
	
	$url = "http://production.shippingapis.com/ShippingAPI.dll?API=TrackV2";
	
		$xml_data ='<TrackFieldRequest USERID='.env('USERID').'>'.
		'<Revision>1</Revision>'.
		'<ClientIp>'.$parameters_array['FromIP'].'</ClientIp>'.
		'<SourceId>'.$parameters_array['Name'].'</SourceId>'.
		'<TrackID ID="'.$parameters_array['TrackID'].'">'.
		'<DestinationZipCode>'.$parameters_array['Zipcode'].'</DestinationZipCode>'.
		'<MailingDate>'.$parameters_array['MailDate'].'</MailingDate>'.
		'</TrackID>'.
		'</TrackFieldRequest>';
		
		$output=$this->callCurl($url,$xml_data);

		

		$array_data = json_decode(json_encode(simplexml_load_string($output)), true);
		return $array_data;
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
	
private function generateLabel($hasdata,$order_id){
	
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
		
		$label_title = 'uploads/pdf/'.$order_id.'_label_'.uniqid().'.pdf';
		
		$file=fopen($label_title,"w");
		
		fwrite($file,$filecontent);
		fclose($file);
		return $label_title;
		 
	}
 	
public function varifyaddress($parameters_array){
	
	$url = "https://secure.shippingapis.com/ShippingAPI.dll?API=Verify";
	
	$xml_data=urlencode('<AddressValidateRequest USERID="'.env('USERID').'">

	<IncludeOptionalElements>true</IncludeOptionalElements>
      
	<ReturnCarrierRoute>true</ReturnCarrierRoute>
      
	<Address ID="0">  
      
	  <FirmName />   
      
	  <Address1>'.$parameters_array['Address1'].'<Address1/>   
      
	  <Address2>'.$parameters_array['Address2'].'</Address2>   
      
	  <City>'.$parameters_array['City'].'</City>   
      
	  <State>'.$parameters_array['State'].'</State>   
      
	  <Zip5></Zip5>   
      
	  <Zip4></Zip4> 
      
	</Address>      
      
      </AddressValidateRequest>');
	
	$output=$this->callCurl($url,$xml_data);

		

		$array_data = json_decode(json_encode(simplexml_load_string($output)), true);
		return $array_data;
}

}
?>