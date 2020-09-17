<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Userprofile
 * @author     madan <madanchunchu@gmail.com>
 * @copyright  2018 madan
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

class Controlbox{
     
     /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function setRegister($fname,$lname,$addressone,$addresstwo,$pin,$phone,$acctype,$email,$country,$state,$city,$password,$agency)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/RegistrationAPI/Register';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		//echo '{"ActivationKey":"123456789","FirstName":"'.$fname.'","LastName":"'.$lname.'","Address1":"'.$addressone.'","Address2":"'.$addresstwo.'","PostalCode":"'.$pin.'","PhoneNumber":"'.$phone.'","AccountType":"'.$acctype.'","Email":"'.$email.'","Country":"'.$country.'","State":"'.$state.'","City":"'.$city.'","Password":"'.$password.'","ConfirmPassword":"'.$password.'","UpdatedOn":""}';
		curl_setopt($ch, CURLOPT_POSTFIELDS,'{"FirstName":"'.$fname.'","LastName":"'.$lname.'","Address1":"'.$addressone.'","Address2":"'.$addresstwo.'","PostalCode":"'.$pin.'","PhoneNumber":"'.$phone.'","AccountType":"'.$acctype.'","Email":"'.$email.'","Country":"'.$country.'","State":"'.$state.'","City":"'.$city.'","Password":"'.$password.'","ConfirmPassword":"'.$password.'","UpdatedOn":"","ActivationKey":"123456789","AgencyId":"'.$agency.'"}');
		$result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg;
    }
    
    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getLogin($user,$pass)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/AccountApi/Login';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"UserName":"'.$user.'","Password":"'.$pass.'","ActivationKey":"123456789"}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->ResCode;
    }

    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getExistTracking($track)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/shipmentsAPi/isExistTrackingId?TrackingId='.$track;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        //var_dump($result);exit;
        //$msg=json_decode($result);
        return $result;
    }
     /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    
    public static function getDocumentList($id)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/DocumentsApi/getDocuments?custId='.$id.'&ActivationKey=123456789';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Data;
    }       

     /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    
    public static function getDocumentListAjax($id)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/DocumentsApi/getDocuments?custId='.$id.'&ActivationKey=123456789';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        $UserDocumentView=$msg->Data;
        $html='';
        if($UserDocumentView->identity_form_doc){ $fileExt=$UserDocumentView->identity_form_Name.'.'.end((explode('/', $UserDocumentView->identity_form_content_type)));
        $html.='<div class="form-group">
            <div class="row">
              <div class="col-sm-2">
                <label>Photo ID</label>
              </div>
              <div class="col-sm-10">
                <label class="radio-inline">
                <input type="radio" name="downfile" value="1:'.$UserDocumentView->identity_form_doc.'" >
                '.end((explode('/', $UserDocumentView->identity_form_Name))).'</label>
                <input type="hidden" name="downfilenameone" value="'.$fileExt.'" >
              </div>
            </div>
          </div>';
        } 
        if($UserDocumentView->form_doc){$fileExt2=$UserDocumentView->form_name.'.'.end((explode('/', $UserDocumentView->form_content_type)));
        $html.='<div class="form-group">
            <div class="row">
              <div class="col-sm-2">
                <label>Form 1583</label>
              </div>
              <div class="col-sm-10">
                <label class="radio-inline">
                <input type="radio" name="downfile" value="2:'.$UserDocumentView->form_doc.'">
                '.end((explode('/', $UserDocumentView->form_name))).'</label>
                <input type="hidden" name="downfilenametwo" value="'.$fileExt2.'" >
              </div>
            </div>
          </div>';
        }
        if($UserDocumentView->utility_doc){$fileExt3=$UserDocumentView->utility_name.'.'.end((explode('/', $UserDocumentView->utility_content_type)));
        $html.=' <div class="form-group">
            <div class="row">
              <div class="col-sm-2">
                <label>Utility Bills</label>
              </div>
              <div class="col-sm-10">
                <label class="radio-inline">
                <input type="radio" name="downfile" value="3:'.$UserDocumentView->utility_doc.'">
                '.end((explode('/', $UserDocumentView->utility_name))).'</label>
                <input type="hidden" name="downfilenamethree" value="'.$fileExt3.'" >
              </div>
            </div>
          </div>';
        }
        if($UserDocumentView->other_doc){$fileExt4=$UserDocumentView->other_name.'.'.end((explode('/', $UserDocumentView->other_content_type)));
        $html.='  <div class="form-group">
            <div class="row">
              <div class="col-sm-2">
                <label>Others</label>
              </div>
              <div class="col-sm-10">
                <label class="radio-inline">
                <input type="radio" name="downfile" value="4:'.$UserDocumentView->other_doc.'">
                '.end((explode('/', $UserDocumentView->other_name))).'</label>
                <input type="hidden" name="downfilenamefour" value="'.$fileExt4.'" >
              </div>
            </div>
          </div>';
        }         
        return $html.'<input type="hidden" name="taskmethod" value="'.$UserDocumentView->sendCommandType.'" />';
    }       

     /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    
    public static function getCountriesList()
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/RegistrationAPI/Countries?ActivationKey=123456789';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        return $result;
    }       


     /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getStatesList($countryid,$stateid)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/RegistrationAPI/States?countryId='.$countryid.'&ActivationKey=123456789';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        $states='';
        $result = json_decode($result); 
        foreach($result->Data as $rg){
          if($stateid==$rg->StatesId){echo $sel="selected";}else{ $sel="";}
          $states.= '<option value="'.$rg->StatesId.'" '.$sel.'>'.$rg->StateDesc.'</option>';
        }        
        return $states;
    }       


     /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getCitiesList($countryid,$stateid,$cityid)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/RegistrationAPI/Cities?stateId='.urlencode($stateid).'&ActivationKey=123456789';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        
        $rescities = json_decode($result); 
        $cities='';
        foreach($rescities->Data as $rg){
           if($cityid==$rg->CityCode){echo $sel="selected";}else{ $sel="";}
           $cities.= '<option value="'.$rg->CityDesc.'" data-xyz="'.$rg->CityCode.'" '.$sel.'>'.$rg->CityDesc.'</option>';
        }        
        return $cities;
    }  


     /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    
    public static function getPickupOderInfo($user,$quid)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/PickupOrderAPI/getAdditionalPickUpOrderInfo?custId='.$user.'&QuoteNumber='.$quid;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        //$result = json_decode($result); 
        //var_dump($result);exit;
        return $result;
    }   

    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function addconvertpickup($CustId,$txtShipperName,$txtShipperAddress,$txtConsigneeName, $txtConsigneeAddress,$txtThirdPartyName,$txtThirdPartyAddress, $txtChargableWeight,$txtName, $txtPickupDate, $txtPickupAddress, $QuoteNumberTxt)
    {
        $txtShipperNames=explode(":",$txtShipperName);
        $txtConsigneeNames=explode(":",$txtConsigneeName);
        $txtThirdPartyNames=explode(":",$txtThirdPartyName);
        $QuoteNumberTxts=explode(":",$QuoteNumberTxt);
        //echo '{"QuoteNumber":"'.$QuoteNumberTxts[0].'","IdCust":"'.$QuoteNumberTxts[1].'","IdServ":"'.$QuoteNumberTxts[1].'","Shipment_Id":"","ShipperId":"'.$QuoteNumberTxts[1].'","ShipperName":"'.$txtShipperNames[0].'","ShipperAddress":"'.$txtShipperAddress.'","ConsigneeId":"'.$txtConsigneeNames[0].'","ConsigneeName":"'.$txtConsigneeNames[1].'","ConsigneeAddress":"'.$txtConsigneeAddress.'","BitThirdPartySameAsCust":"","ThirdPartyId":"'.$QuoteNumberTxts[1].'","ThirdPartyName":"'.$txtThirdPartyNames[0].'","ThirdPartyAddress":"'.$txtThirdPartyAddress.'","BitConSameAsCust":"false","BitShipperSameAsCust":"true","PickUpInfo":{"Name":"'.$txtName.'","PickupDate":"'.$txtPickupDate.'","PickupAddr":"'.$txtPickupAddress.'"}}';
        //exit;
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/PickupOrderAPI/ConvertToPickup';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"QuoteNumber":"'.$QuoteNumberTxts[0].'","IdCust":"'.$QuoteNumberTxts[1].'","IdServ":"'.$QuoteNumberTxts[1].'","Shipment_Id":"","ShipperId":"'.$QuoteNumberTxts[1].'","ShipperName":"'.$txtShipperNames[0].'","ShipperAddress":"'.$txtShipperAddress.'","ConsigneeId":"'.$txtConsigneeNames[0].'","ConsigneeName":"'.$txtConsigneeNames[1].'","ConsigneeAddress":"'.$txtConsigneeAddress.'","BitThirdPartySameAsCust":"","ThirdPartyId":"'.$QuoteNumberTxts[1].'","ThirdPartyName":"'.$txtThirdPartyNames[0].'","ThirdPartyAddress":"'.$txtThirdPartyAddress.'","BitConSameAsCust":"false","BitShipperSameAsCust":"true","PickUpInfo":{"Name":"'.$txtName.'","PickupDate":"'.$txtPickupDate.'","PickupAddr":"'.$txtPickupAddress.'"}}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
		//var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Msg;
    }



     /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    
    public static function getPickupOderShippernameId($id)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/PickupOrderAPI/getAdditionalUser?UserType=ShipperUser&User=Shipper';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        $result = json_decode($result); 
        //var_dump($result);exit;
        $cts='';
        if($id==1)
        return $result->IdAdduser;
        else
        foreach($result->Cntry_List as $rg){
          $cts.= '<option value="'.$rg->id_values.'" '.$sel.'>'.$rg->desc_vals.'</option>';
        }        
        return $cts;
    }   

     /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    
    public static function getPickupOderConsigneeId($id)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/PickupOrderAPI/getAdditionalUser?UserType=ConsigneeUser&User=Consignee';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        $result = json_decode($result); 
        //var_dump($result);exit;
        $cts='';
        if($id==1)
        return $result->IdAdduser;
        else
        foreach($result->Cntry_List as $rg){
          $cts.= '<option value="'.$rg->id_values.'" '.$sel.'>'.$rg->desc_vals.'</option>';
        }        
        return $cts;
    }   
    
     /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    
    public static function getCodorders($id)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/shipmentsApi/liOfCodOrders?custId='.$id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        $result = json_decode($result); 
        //var_dump($result);exit;
        return $result->Data;
    }   
    
    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    
    public static function getPickupOderThirdpartyId($id)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/PickupOrderAPI/getAdditionalUser?UserType=DeliveryUser&User=Third%20Party';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        $result = json_decode($result); 
        //var_dump($result);exit;
        $cts='';
        if($id==1)
        return $result->IdAdduser;
        else
        foreach($result->Cntry_List as $rg){
          $cts.= '<option value="'.$rg->id_values.'" '.$sel.'>'.$rg->desc_vals.'</option>';
        }        
        return $cts;
    }   

     /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    
    public static function getPickupFieldviewsList($cid)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/PickupOrderAPI/getPickupOrder?custId='.$cid.'&Activationkey=123456789';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Data;
    }       

    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    
    public static function getQuotationFieldviewsList($cid)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/QuotationAPI/getQuoteId?custId='.$cid.'&Activationkey=123456789';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Data;
    }       

     /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    
    public static function getCalculatorFieldviewsList($cid)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/QuotationAPI/getPickupOrder?custId='.$cid.'&Activationkey=123456789';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Data;
    }       


    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getEmailExist($email)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/RegistrationAPI/GetEmail?Email='.$email.'&ActivationKey=123456789';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Response;
    }

    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getDeleteOrder($id)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/ShipmentsAPI/DeleteMypurchase?Id='.$id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Response;
    }



    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function deleteDownloadfile($custid,$id)
    {
        if($id==1){
        $id="Identification";
        }elseif($id==2){
        $id="Form";
        }elseif($id==3){
        $id="Utility";
        }elseif($id==4){
            $id="Other";
        }
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/DocumentsApi/DeleteFile?CustId='.$custid.'&DocumentName='.$id.'&ActivationKey=123456789';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Response;
    }

    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getDeleteShopper($id)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/ShopperAssistAPI/deleteItem?itemid='.$id.'&status=delete';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Response;
    }


    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getTicketnumber()
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/SupportTicketAPI/AutoGenerateTicketNumber?ActivationKey=123456789';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Data;
    }


   /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getUpdatePurchaseDetails($itd)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/shipmentsapi/GetPurchaseOrderById';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"ItemId":"'.$itd.'"}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
		//var_dump($result);exit;
		$msg=json_decode($result);
        $msg2=$msg->Data;
        return $msg2->ItemId.':'.$msg2->SupplierId.':'.$msg2->CarrierId.':'.$msg2->OrderDate.':'.$msg2->TrackingId.':'.$msg2->ItemName.':'.$msg2->ItemQuantity.':'.$msg2->ItemPrice.':'.$msg2->cost.':'.$msg2->itemstatus.':'.$msg2->Dest_Cntry.':'.$msg2->Dest_Hub.':'.$msg2->ItemImage;
        
    }



   /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function insertDocument($CustId,$photoname, $photosrc,$phototype, $formname,$formsrc,$formtype,$utilityname,$utilitysrc,$utilitytype,$othername,$othersrc,$othertype)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/DocumentsApi/insertOrUpdateDocument';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"CustId":"'.$CustId.'","ActivationKey":"123456789","commandType":"Insert","identity_form_Name":"'.$photoname.'","identity_form_doc":"'.$photosrc.'","identity_form_content_type":"'.$phototype.'","form_name":"'.$formname.'","form_doc":"'.$formsrc.'","form_content_type":"'.$formtype.'","utility_name":"'.$utilityname.'","utility_doc":"'.$utilitysrc.'","utility_content_type":"'.$utilitytype.'","other_name":"'.$othername.'","other_doc":"'.$othersrc.'","other_content_type":"'.$othertype.'"}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        //echo '{"CustId":"'.$CustId.'","ActivationKey":"123456789","commandType":"Insert","identity_form_Name":"identity","identity_form_GUID":"'.$photodest1.'","identity_form_content_type":".png","form_name":"Form","form_GUID":"'.$formdest1.'","form_content_type":".png","utility_name":"utility","utility_GUID":"'.$utilitydest1.'","utility_content_type":".png","other_name":"Others","others_GUID":"'.$otherdest1.'","other_content_type":".png"}';
        $result=curl_exec($ch);
		//var_dump($result);exit;
		$msg=json_decode($result);
		return $msg->Response;
    }



   /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */                                        
    public static function updateDocument($CustId,$photoname, $photosrc,$phototype, $formname,$formsrc,$formtype,$utilityname,$utilitysrc,$utilitytype,$othername,$othersrc,$othertype)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/DocumentsApi/insertOrUpdateDocument';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"CustId":"'.$CustId.'","ActivationKey":"123456789","commandType":"Update","identity_form_Name":"'.$photoname.'","identity_form_doc":"'.$photosrc.'","identity_form_content_type":"'.$phototype.'","form_name":"'.$formname.'","form_doc":"'.$formsrc.'","form_content_type":"'.$formtype.'","utility_name":"'.$utilityname.'","utility_doc":"'.$utilitysrc.'","utility_content_type":"'.$utilitytype.'","other_name":"'.$othername.'","other_doc":"'.$othersrc.'","other_content_type":"'.$othertype.'"}');
        //echo '{"CustId":"'.$CustId.'","ActivationKey":"123456789","commandType":"Update","identity_form_Name":"identity","identity_form_GUID":"'.$photodest1.'","identity_form_content_type":".png","form_name":"Form","form_GUID":"'.$formdest1.'","form_content_type":".png","utility_name":"utility","utility_GUID":"'.$utilitydest1.'","utility_content_type":".png","other_name":"Others","others_GUID":"'.$otherdest1.'","other_content_type":".png"}';exit;
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
		//var_dump($result);exit;
		$msg=json_decode($result);
		return $msg->Response;
    }


   /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getPackageDetails($itd)
    {
        
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/QuotationAPI/GetPackageDetailsById?PkgId='.$itd;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
		//var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Length.':'.$msg->Width.':'.$msg->Height;
        
    }


   /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getShipDetails($itd)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/shipmentsapi/GetHistroyIdkDetails';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"CmdType":"History","Idk":"'.$itd.'"}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
		//var_dump($result);
		$msg=json_decode($result);
		return $msg->Data->idk.':'.$msg->Data->cmdType.':'.$msg->Data->comments.':'.$msg->Data->ShippingDetails.':'.$msg->Data->DocumentationCharges.':'.$msg->Data->ShippingCost.':'.$msg->Data->FinalCost.':'.$msg->Data->AmountPaid.':'.$msg->Data->AmountPayable.':'.$msg->Data->PaymentMethod.':'.$msg->Data->TransactionNumber.':'.$msg->Data->InvoiceNumber.':'.$msg->Data->Date.':'.$msg->Data->AmountPaidPaid;
    
    }

    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getMomentoLog($rec)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/shipmentsapi/getmomentumlog?billformno='.$rec;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        $mlg='';
        foreach($msg->Data as $rg){
          $mlg.= '<tr><td>'.$rg->Status.'</td>'.'<td>'.$rg->CreatedBy.'</td>'.'<td>'.$rg->CreatedDate.'</td></tr>';
        }        
        return $mlg;
    }

     /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function submitTicket($user, $txtticketDescStr,$txtTicketNumberStr)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/SupportTicketAPI/InsertTicket_ByCustomer';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"number_ticket":"'.$txtTicketNumberStr.'","status_ticket":"Open","id_cust":"'.$user.'","reason_ticket":"'.$txtticketDescStr.'","ActivationKey":"123456789"}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
		//echo '{"number_ticket":"'.$txtTicketNumberStr.'","status_ticket":"Open","id_cust":"'.$user.'","reason_ticket":"'.$txtticketDescStr.'","ActivationKey":"123456789"}';
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Data;
    }


     /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function postQotationRequest($CustId, $txtMeasurementUnits,$txtTypeOfShipperName,$txtServiceType,$txtIdServ,$txtSourceCntry,$txtDestinationCntry,$txtLength,$txtWidth,$txtHeight,$txtQuantity,$txtWeight,$txtWeightUnits,$txtquotationCost,$discount,$txtfinalCost,$addservcost,$addservid,$txtqty,$quotid,$txtNotes,$txtCommodity,$txtRatetypeIds,$txtItemName,$txtPackageList,$txtVolumeMultiple,$txtVolWtMultiple,$txtIdrate,$txtIns,$txtGrossWeight,$addservid)
    {
        $rows='';
        
        for($i=0;$i<count($txtPackageList);$i++){
            $txtPackage=explode(":",$txtPackageList[$i]);
            $packageid[]=$txtPackage[0];
            $packagename[]=$txtPackage[1];
        }
        $txtRatetype=explode(",",$txtRatetypeIds);
        $txtVolumeMultiple=explode(",",$txtVolumeMultiple);
        $txtVolWtMultiple=explode(",",$txtVolWtMultiple);
        $txtGrossWeights=explode(",",$txtGrossWeight);
        for($i=0;$i<count($txtVolumeMultiple);$i++){
            if($txtWeight[$i])
            $rows.='{"CommandType":"InsertUpdate","CommodityId":"'.$txtCommodity[$i].'","Gross_Wt":"'.$txtGrossWeights[$i].'","Gross_Wt_PerItem":"'.$txtWeight[$i].'","Height":"'.$txtHeight[$i].'","IdPkg":"'.$packageid[$i].'","IdRateType":"'.$txtRatetype[$i].'","ItemName":"'.$txtItemName[$i].'","ItemQty":"'.$txtQuantity[$i].'","Length":"'.$txtLength[$i].'","Pkg_Name":"'.$packagename[$i].'","QuotationNumber":"'.$quotid.'","Volume":"'.$txtVolumeMultiple[$i].'","Volumetric_Wt":"'.$txtVolWtMultiple[$i].'","Width":"'.$txtWidth[$i].'"},';
        }
        if($txtIns=="true"){
            $txtIns="PEN";
        }else{
            $txtIns="ACT";
        }    
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/QuotationAPI/InsertOrUpdateQuotation';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"MUnits":"'.$txtMeasurementUnits.'","Shipment_Id":"'.$txtTypeOfShipperName.'","ServiceType_Id":"'.$txtServiceType.'","RateId":"'.$txtIdrate.'","Source":"'.$txtSourceCntry.'","Destination":"'.$txtDestinationCntry.'","WUnits":"'.$txtWeightUnits.'","Total_Cost":"'.$txtquotationCost.'","discount":"'.$discount.'","Final_Cost":"'.$txtfinalCost.'","addtServiceCost":"'.$addservcost.'","addtServiceId":"'.$addservid.'","itemQty": "'.$txtqty.'","isShowInh": "0,0,","isShowOtherChrg": "0,0,","IdCust":"'.$CustId.'","Quote_Id":"'.$quotid.'","Note":"'.$txtNotes.'","IdServ":"'.$txtIdServ.'","Status":"'.$txtIns.'","ActivationKey":"123456789","Items_List":['.substr($rows,0,-1).']}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
		//echo '{"MUnits":"'.$txtMeasurementUnits.'","Shipment_Id":"'.$txtTypeOfShipperName.'","ServiceType_Id":"'.$txtServiceType.'","RateId":"'.$txtIdrate.'","Source":"'.$txtSourceCntry.'","Destination":"'.$txtDestinationCntry.'","WUnits":"'.$txtWeightUnits.'","Total_Cost":"'.$txtquotationCost.'","discount":"'.$discount.'","Final_Cost":"'.$txtfinalCost.'","addtServiceCost":"'.$addservcost.'","addtServiceId":"'.$addservid.'","itemQty": "'.$txtqty.'","isShowInh": "0,0,","isShowOtherChrg": "0,0,","IdCust":"'.$CustId.'","Quote_Id":"'.$quotid.'","Note":"'.$txtNotes.'","IdServ":"'.$txtIdServ.'","Status":"'.$txtIns.'","ActivationKey":"123456789","Items_List":['.substr($rows,0,-1).']}';
		//var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Description;
    }


     /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function postPickupRequest($CustId, $txtMeasurementUnits,$txtTypeOfShipperName,$txtServiceType,$txtIdServ,$txtSourceCntry,$txtDestinationCntry,$txtLength,$txtWidth,$txtHeight,$txtQuantity,$txtWeight,$txtWeightUnits,$txtquotationCost,$txtRateId,$quotid,$txtNotes,$txtCommodity,$txtRatetypeIds,$txtItemName,$txtPackageList,$txtVolumeMultiple,$txtVolWtMultiple,$txtShipperName,$txtConsigneeName,$txtThirdPartyName,$txtName,$txtChargableWeight,$txtPickupDate,$txtPickupAddress,$txtConsigneeId,$txtThirdPartyId,$txtShipperNameId,$txtShipperAddress,$txtConsigneeAddress,$txtThirdPartyAddress,$txtIdrate,$txtfinalCost,$txtDiscount,$txtGrossWeight,$addservid,$txtqty)
    {
        $rows='';
        
        for($i=0;$i<count($txtPackageList);$i++){
            $txtPackage=explode(":",$txtPackageList[$i]);
            $packageid[]=$txtPackage[0];
            $packagename[]=$txtPackage[1];
            
        }
        //,"QuotationNumber":"'.$quotid.'"
        $txtRatetype=explode(",",$txtRatetypeIds);
        $txtVolumeMultiple=explode(",",$txtVolumeMultiple);
        $txtVolWtMultiple=explode(",",$txtVolWtMultiple);
        $txtGrossWeights=explode(",",$txtGrossWeight);
        for($i=0;$i<count($txtVolumeMultiple);$i++){
            if($txtWeight[$i])
            $rows.='{"CommandType":"InsertUpdate","CommodityId":"'.$txtCommodity[$i].'","Gross_Wt":"'.$txtGrossWeights[$i].'","Gross_Wt_PerItem":"'.$txtWeight[$i].'","Height":"'.$txtHeight[$i].'","IdPkg":"'.$packageid[$i].'","IdRateType":"'.$txtRatetype[$i].'","ItemName":"'.$txtItemName[$i].'","ItemQty":"'.$txtQuantity[$i].'","Length":"'.$txtLength[$i].'","Pkg_Name":"'.$packagename[$i].'","Status":"PEN","PickUpOrderNumber":"'.$quotid.'","Volume":"'.$txtVolumeMultiple[$i].'","Volumetric_Wt":"'.$txtVolWtMultiple[$i].'","Width":"'.$txtWidth[$i].'"},';
        }
        if($txtIns=="true"){
            $txtIns="PEN";
        }else{
            $txtIns="ACT";
        }
        //echo '{"PickUpOrder_Id":"'.$quotid.'","IdCust":"'.$CustId.'","Shipment_Id":"'.$txtTypeOfShipperName.'","ServiceType_Id":"'.$txtServiceType.'","IdServ":"'.$txtIdServ.'","BitConSameAsCust":"false","BitShipperSameAsCust":"false","BitThirdPartySameAsCust":"false","MUnits":"'.$txtMeasurementUnits.'","WUnits":"'.$txtWeightUnits.'", "Note":"'.$txtNotes.'","ConsigneeId":"'.$txtConsigneeId.'","ConsigneeName":"'.$txtConsigneeName.'","ThirdPartyId":"'.$txtThirdPartyId.'","ThirdPartyName":"'.$txtThirdPartyName.'","ShipperId":"'.$txtShipperNameId.'","ShipperName":"'.$txtShipperName.'","ConsigneeAddress":"'.$txtConsigneeAddress.'","ThirdPartyAddress":"'.$txtThirdPartyAddress.'","ShipperAddress":"'.$txtShipperAddress.'","Total_Cost":"'.$txtquotationCost.'","Final_Cost":"'.$txtfinalCost.'","addtServiceCost":"","addtServiceId":"'.$addservid.'","itemQty": "'.$txtqty.'","isShowInh": "0,0,","isShowOtherChrg": "0,0,","Discount":"'.$txtDiscount.'","PickUpInfo":{ "Name":"'.$txtName.'",	"PickupAddr":"'.$txtPickupAddress.'",	"PickupDate":"'.$txtPickupDate.'" },"Items_List":['.substr($rows,0,-1).']}';
        $session = JFactory::getSession();
        $user=$session->get('user_casillero_id');

        if($user==$txtShipperNameId){
            $t1='true';
        }
        else{
            $t1='false';
        }
        if($user==$txtConsigneeId){
            $t2='true';
        }
        else{
            $t2='false';
        }
        if($user==$txtThirdPartyId){
            $t3='true';
        }
        else{
            $t3='false';
        }

        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/PickupOrderAPI/InsertOrUpdatePoOrder';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"PickUpOrder_Id":"'.$quotid.'","IdCust":"'.$CustId.'","Shipment_Id":"'.$txtTypeOfShipperName.'","ServiceType_Id":"'.$txtServiceType.'","IdServ":"'.$txtIdServ.'","BitConSameAsCust":"'.$t2.'","BitShipperSameAsCust":"'.$t1.'","BitThirdPartySameAsCust":"'.$t3.'","MUnits":"'.$txtMeasurementUnits.'","WUnits":"'.$txtWeightUnits.'", "Note":"'.$txtNotes.'","ConsigneeId":"'.$txtConsigneeId.'","ConsigneeName":"'.$txtConsigneeName.'","ThirdPartyId":"'.$txtThirdPartyId.'","ThirdPartyName":"'.$txtThirdPartyName.'","ShipperId":"'.$txtShipperNameId.'","ShipperName":"'.$txtShipperName.'","ConsigneeAddress":"'.$txtConsigneeAddress.'","ThirdPartyAddress":"'.$txtThirdPartyAddress.'","ShipperAddress":"'.$txtShipperAddress.'","Total_Cost":"'.$txtquotationCost.'","Final_Cost":"'.$txtfinalCost.'","addtServiceCost":"","addtServiceId":"'.$addservid.'","itemQty": "'.$txtqty.'","isShowInh": "0,0,","isShowOtherChrg": "0,0,","Discount":"'.$txtDiscount.'","PickUpInfo":{ "Name":"'.$txtName.'",	"PickupAddr":"'.$txtPickupAddress.'",	"PickupDate":"'.$txtPickupDate.'" },"Items_List":['.substr($rows,0,-1).']}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
		//var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Msg;
    }



    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function submitpayment($amtStr,$cardnumberStr,$txtccnumberStr, $MonthDropDownListStr,  $txtNameonCardStr, $YearDropDownListStr,$invidkStr,$qtyStr,$wherhourecStr, $CustId,$specialinstructionStr, $cc, $shipservtStr,$consignidStr,$invf,$articleStr,$priceStr,$tid,$inhouse,$inhouseid)
    {
        if($consignidStr==""){
            $consignidStr=$CustId;
        }
        
        if($inhouseid){
            $cc='PayForCOD';
        }
		if($cc){
            $cc='COD';
        }
        //$tid=rand();
		//echo '{"paymentOption":{"_amt":"'.$amtStr.'","_cardno":"'.$cardnumberStr.'","_ccno":"'.$txtccnumberStr.'","_index":"1","_month":"'.$MonthDropDownListStr.'","_nameoncard":"'.$txtNameonCardStr.'","_year":"'.$YearDropDownListStr.'"},"idks":"'.$invidkStr.',","qtys":"'.$qtyStr.',","billFormIds":"'.$wherhourecStr.',","ShippingCost":"'.$amtStr.'","ConsigneeId":"'.$consignidStr.'","Comments":"'.$specialinstructionStr.'","PaymentType":"'.$cc.'","CustId":"'.$CustId.'","id_serv":"'.$shipservtStr.'","paymentgateway":"","TransactionID":"'.$tid.'","UploadedFile":"'.$invf.'","InHouseNo":"'.$inhouse.'","InhouseId":"'.$inhouseid.'","EachItemName":"'.$articleStr.',","EachItemQty":"'.$qtyStr.',","TotalitemsPrice":"'.$priceStr.',"}';
		//exit;
		mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/ShipmentsAPI/PaymentTransaction';
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"paymentOption":{"_amt":"'.$amtStr.'","_cardno":"'.$cardnumberStr.'","_ccno":"'.$txtccnumberStr.'","_index":"1","_month":"'.$MonthDropDownListStr.'","_nameoncard":"'.$txtNameonCardStr.'","_year":"'.$YearDropDownListStr.'"},"idks":"'.$invidkStr.',","qtys":"'.$qtyStr.',","billFormIds":"'.$wherhourecStr.',","ShippingCost":"'.$amtStr.'","ConsigneeId":"'.$consignidStr.'","Comments":"'.$specialinstructionStr.'","PaymentType":"'.$cc.'","CustId":"'.$CustId.'","id_serv":"'.$shipservtStr.'","paymentgateway":"","TransactionID":"'.$tid.'","UploadedFile":"'.$invf.'","InHouseNo":"'.$inhouse.'","InhouseId":"'.$inhouseid.'","EachItemName":"'.$articleStr.',","EachItemQty":"'.$qtyStr.',","TotalitemsPrice":"'.$priceStr.',"}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
		//var_dump($result);exit;
        $msg=json_decode($result);
        if($msg->InvoiceId!="")
        return $msg->InvoiceId.':'.$cardnumberStr;
        else
        return $msg->Data;
    }

     /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getCalculationShipping($CustId,$units,$shiptype,$sertype,$source,$dt,$lg,$wd,$hi,$qty,$gwt,$wtunits)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/QuotationAPI/calcQuotationCost';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"CustId":"'.$CustId.'","MUnits":"'.$units.'","ShipmentType":"'.$shiptype.'","ServiceType":"'.$sertype.'","Source":"'.$source.'","Destination":"'.$dt.'","Length":"'.$lg.'","Width":"'.$wd.'","Height":"'.$hi.'","ItemQty":"'.$qty.'","Gross_Wt_PerItem":"'.$gwt.'","wtunits":"'.$wtunits.'","ActivationKey":"123456789"}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
		//echo '{"CustId":"'.$CustId.'","MUnits":"'.$units.'","ShipmentType":"'.$shiptype.'","ServiceType":"'.$sertype.'","Source":"'.$source.'","Destination":"'.$dt.'","Length":"'.$lg.'","Width":"'.$wd.'","Height":"'.$hi.'","ItemQty":"'.$qty.'","Gross_Wt_PerItem":"'.$gwt.'","wtunits":"'.$wtunits.'","ActivationKey":"123456789"}';
		//var_dump($result);exit;
        $msg=json_decode($result);
        if($msg->Description=="Successfully Calculated")
        return $msg->Data->RatetypeIds.":".$msg->Data->VolumeMultiple.":".$msg->Data->VolWtMultiple.":".$msg->Data->quotationCost.":".$msg->Data->IdServ.":".$msg->Data->RateId.":".$msg->Data->discount.":".$msg->Data->addtServiceCost.":".$msg->Data->GrossWtMultiple.':'.$msg->Data->addtServiceId;
        else
        return $msg->Description;
        
    }




     /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getCalculatorMesurements($units,$shiptype,$sertype,$source,$dt,$lg,$wd,$hi,$qty,$gwt,$wtunits)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/CalculatorAPI/calcVolume';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"Length":"'.$lg.'","Height":"'.$hi.'","Width":"'.$wd.'","Quantity":"'.$qty.'","ShipmentTypeValue":"'.$shiptype.'","ActivationKey":"123456789"}');
        //echo '{"Length":"'.$lg.'","Height":"'.$hi.'","Width":"'.$wd.'","Quantity":"'.$qty.'","ShipmentTypeValue":"'.$shiptype.'","ActivationKey":"123456789"}';
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
		//var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Data->Volume.":".$msg->Data->VolumetricWeight;
    }





     /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getadduserfieldsInfo($user,$usertype)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/CustomerInfoApi/GetAdditionaluserByCustomerId?id_cust='.$user.'&ActivationKey=123456789';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        $mlg='';
        foreach($msg->Data as $rg){
          if($usertype==$rg->addtAddrId)    
          $mlg.= $rg->userType.':'.$rg->id_cust.':'.$rg->name_f.':'.$rg->name_l.':'.$rg->id_cntry.':'.$rg->id_state.':'.$rg->id_city.':'.$rg->postal_addr.':'.$rg->AddtEmail.':'.$rg->Addr1Name.':'.$rg->Addr2Name;
        }        
        return $mlg;
    }





     /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getadduserconsigInfo()
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/customerInfoApi/getAdditionalUser?UserType=ConsigneeUser&User=Consignee';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Data->UserType.':'.$msg->Data->IdAdduser;
    }


     /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getCalculatingMesurements($munits,$tos,$stype,$source,$dt,$length,$width,$height,$qty,$gwt,$wtunits,$value,$vmetric)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/CalculatorAPI/calculate';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        if($stype==166){
            $stype='AIR';
        }
        if($stype==1728){
            $stype='OCEAN';
        }
        
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"Destination":"'.$dt.'","GrossWeight":"'.$gwt.'","Source":"'.$source.'","VolumetricWeight":"'.$value.'","ActivationKey":"123456789","ShippingType":"'.$stype.'"}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
		//var_dump($result);exit;
        $msg=json_decode($result);
        $ser=Controlbox::getServiceList();
        $resService=$ser->AS_List;
        if($msg->Data[0]->ShippingCost>0){

            $charge=0;
            foreach($resService as $row){
                $charge+=$row->Cost+$msg->Data[0]->ShippingCost;
            }    
            return $msg->Data[0]->ChargeableWeight.":".$charge;
        }else{
            return $msg->Data[0]->ChargeableWeight.":No Service for Destination";
        }    
    }



     /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function submitpayshopperassist($CustId,$amtStr,$cardnumberStr,$txtccnumberStr, $MonthDropDownListStr,  $txtNameonCardStr, $YearDropDownListStr,$txtSpecialInStr,$txtTaxesStr,$txtShippChargesStr,$ItemIdsStr,$ItemQuantityStr,$ItemSupplierIdStr,$txtPaymentMethod,$ack,$corid,$tid)
    {    
        if($txtPaymentMethod==1){
            $txtPaymentMethod='PPD';    
        }
        //echo '{"objCardDetails":{"_amt":"'.$amtStr.'","_cardno":"'.$cardnumberStr.'","_ccno":"'.$txtccnumberStr.'","_index":1,"_month":"'.$MonthDropDownListStr.'","_nameoncard":"'.$txtNameonCardStr.'","_year":"'.$YearDropDownListStr.'"},"Comments":"'.$txtSpecialInStr.'","CreatedBy":"Customer","CustomerId":"'.$CustId.'","Id":"'.$ItemIdsStr.'","ItemQuantity":"'.$ItemQuantityStr.'","SupplierId":"'.$ItemSupplierIdStr.'",	"LocalShipCost":"'.$txtShippChargesStr.'","LocalTax":"'.$txtTaxesStr.'","PurchseType":"0","ItemUrl":",","Status":"yes","paymenttype":"'.$txtPaymentMethod.'","paymentgateway":"COD","TransactionID":"'.$tid.'","CorrelationID":"'.$corid.'","ACK":"'.$ack.'"}';
		mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/ShopperAssistAPI/PaymentTransaction';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"objCardDetails":{"_amt":"'.$amtStr.'","_cardno":"'.$cardnumberStr.'","_ccno":"'.$txtccnumberStr.'","_index":1,"_month":"'.$MonthDropDownListStr.'","_nameoncard":"'.$txtNameonCardStr.'","_year":"'.$YearDropDownListStr.'"},"Comments":"'.$txtSpecialInStr.'","CreatedBy":"Customer","CustomerId":"'.$CustId.'","Id":"'.$ItemIdsStr.'","ItemQuantity":"'.$ItemQuantityStr.'","SupplierId":"'.$ItemSupplierIdStr.'",	"LocalShipCost":"'.$txtShippChargesStr.'","LocalTax":"'.$txtTaxesStr.'","PurchseType":"0","ItemUrl":",","Status":"yes","paymenttype":"'.$txtPaymentMethod.'","paymentgateway":"COD","TransactionID":"'.$tid.'","CorrelationID":"'.$corid.'","ACK":"'.$ack.'"}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
		//var_dump($result);exit;
        $msg=json_decode($result);
        if($msg->Data!="")
        return $msg->Data.':'.$cardnumberStr;
        else
        return $msg->Msg;
    }

    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function pickupAdditionalusers($CustId,$useridTxt,$usertypeTxt, $fnameTxt, $lnameTxt,$countryTxt, $stateTxt, $cityTxt, $PostalCode, $addressTxt, $emailTxt)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/PickupOrderAPI/addAdditionalUser';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        if($usertypeTxt=="ShipperUser"){ 
	        $usertype="Shipper";
        }elseif($usertypeTxt=="ConsigneeUser"){
            $usertype="Consignee";
        }else{
            $usertype="Third Party";
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"IdCust":"'.$CustId.'","addr1Name":"Additonal Address","IdAdduser":"'.$useridTxt.'","IdUSerType":"'.$usertypeTxt.'","UserType":"'.$usertype.'","email_name":"'.$emailTxt.'","postal_addr":"'.$PostalCode.'","id_cntry":"'.$countryTxt.'","id_state":"'.$stateTxt.'","id_city":"'.$cityTxt.'","name_f":"'.$fnameTxt.'","name_l":"'.$lnameTxt.'","commandtype":"InsertPortal"}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Msg;
    }

    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function updatePurchaseOrder($itemid,$customerid,$supplierid,$carrierid,$trackingid,$orderdate,$file,$itemname,$itemquantity,$price,$cost,$status,$countryTxt,$stateTxt)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/ShipmentsAPI/UpdatePurchaseOrder';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        if($stateTxt==0){
            $stateTxt="";
        }
        //echo '{"ItemId":"'.$itemid.'","CustomerId":"'.$customerid.'","SupplierId":"'.$supplierid.'","CarrierId":"'.$carrierid.'","TrackingId":"'.$trackingid.'","OrderDate":"'.$orderdate.'","ItemImage":"'.$file.'","Dest_Cntry":"'.$countryTxt.'","Dest_Hub":"'.$stateTxt.'","ItemName":"'.$itemname.'","ItemQuantity":"'.$itemquantity.'","ItemPrice":"'.$price.'","Cost":"'.$cost.'","ItemStatus":"'.$status.'","ItemUrl":"Joomla","ActivationKey":"123456789"}';
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"ItemId":"'.$itemid.'","CustomerId":"'.$customerid.'","SupplierId":"'.$supplierid.'","CarrierId":"'.$carrierid.'","TrackingId":"'.$trackingid.'","OrderDate":"'.$orderdate.'","ItemImage":"'.$file.'","Dest_Cntry":"'.$countryTxt.'","Dest_Hub":"'.$stateTxt.'","ItemName":"'.$itemname.'","ItemQuantity":"'.$itemquantity.'","ItemPrice":"'.$price.'","Cost":"'.$cost.'","ItemStatus":"'.$status.'","ItemUrl":"Joomla","ActivationKey":"123456789"}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
		//var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Description;
    }
     /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function updatePurchaseOrder_($itemid,$customerid,$supplierid,$carrierid,$trackingid,$orderdate,$file,$itemname,$itemquantity,$price,$cost,$status,$country,$state)
    {
        //echo '{"ItemId":"'.$itemid.'","CustomerId":"'.$customerid.'","SupplierId":"'.$supplierid.'","CarrierId":"'.$carrierid.'","TrackingId":"'.$trackingid.'","OrderDate":"'.$orderdate.'","ItemImage":"'.$file.'","ItemName":"'.$itemname.'","ItemQuantity":"'.$itemquantity.'","ItemPrice":"'.$price.'","Cost":"'.$cost.'","ItemStatus":"'.$status.'","ItemUrl":"frontend","ActivationKey":"123456789"}';
        //exit;
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/ShipmentsAPI/UpdatePurchaseOrder';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"ItemId":"'.$itemid.'","CustomerId":"'.$customerid.'","SupplierId":"'.$supplierid.'","CarrierId":"'.$carrierid.'","TrackingId":"'.$trackingid.'","OrderDate":"'.$orderdate.'","ItemImage":"'.$file.'","ItemName":"'.$itemname.'","ItemQuantity":"'.$itemquantity.'","ItemPrice":"'.$price.'","Cost":"'.$cost.'","ItemStatus":"'.$status.'","ItemUrl":"frontend","ActivationKey":"123456789"}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
		//var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Description;
    }

    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getShippmentDetails($CustId,$paymenttype,$wherhourec,$invidk,$qty,$destination,$volres,$munits,$source,$shiptype,$service,$dvalue)
    {
        $fl=explode(",",$volres);
        $qt=explode(",",$qty);
        $str='';
        for($i=0;$i<count($qt);$i++){
           $str.=substr($fl[$i],0,5)*$qt[$i]*$service.",";
        }
        $volresStr=str_replace("E-","",$volres).',';
        
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/ShipmentsAPI/getServiceCost?PaymentType='.$paymenttype.'&WarehouseReceiptNo='.$wherhourec.'&InvIdks='.$invidk.',&Qtys='.$qty.',&destination='.$destination.'&ShipmentType='.$shiptype.'&ActivationKey=123456789&CustId='.$CustId.'&Source='.$source.'&volume='.$volresStr.'&MUnits='.$munits.'&DeclaredVaue='.$dvalue;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        //var_dump($result);
        $msg=json_decode($result);
        return $msg->Data->shipping_cost.':'.$msg->Data->id_serv.':'.$msg->Data->addserv_cost.':'.$msg->Data->discount.':'.$msg->Data->ship_cost.':'.$msg->Data->insurance_cost;
    }

    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public function getShippmentDetailsValues($munits,$shiptype,$service,$source,$destination)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/ShipmentsAPI/GetValues?MUnits='.$munits.'&ShipmentType='.$shiptype.'&ServiceType='.$service.'&Source='.$source.'&destination='.$destination;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Data->CubicValue;
    }

    
     /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getchangepassword($user,$oldpwd,$pwd)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/CustomerInfoAPI/ChangePassword';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{ "CustId":"'.$user.'", "OldPassword":"'.$oldpwd.'", "NewPassword":"'.$pwd.'", "ConfirmPassword":"'.$pwd.'", "ActivationKey":"123456789"}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg;
    }
 
    
     /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getnewpassword($user,$token,$pwd)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/AccountAPI/resetPassword';
        //echo '{ "Password":"'.$pwd.'","resetToken":"'.$token.'", "CustId":"'.$user.'", "ActivationKey":"123456789"}';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{ "Password":"'.$pwd.'","resetToken":"'.$token.'", "CustId":"'.$user.'", "ActivationKey":"123456789"}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg;
    }

     /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getUserprofileDetails($user)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/dashboardapi/GetCustomerDetailsByCustId?CustId='.$user.'&ActivationKey=123456789';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Data;
    }
    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getUserpersonalDetails($user)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/CustomerInfoApi/GetCustomerInfo?Custid='.$user.'&ActivationKey=123456789';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Data;
    }
    
    
    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function changepersonalinformation($CustId, $DailCode,$PrimaryNumber, $AlternativeNumber,$Fax, $PrimaryEmail, $AlternativeEmail, $AddressAccounts, $Country, $State, $City,$PostalCode,$profilepic,$fileTxt,$DialCodeOther,$address2Txt)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/CustomerInfoApi/CustomerInfo';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        if($profilepic==1){
            //echo '{"CustId":"'.$CustId.'","PrimaryNumber":"'.$PrimaryNumber.'","AlternativeNumber":"'.$AlternativeNumber.'","Fax":"'.$Fax.'","DailCode":"'.$DailCode.'","PrimaryEmail":"'.$PrimaryEmail.'","AlternativeEmail":"'.$AlternativeEmail.'","AddressAccounts":"'.$AddressAccounts.'","addr_2_name":"'.$address2Txt.'","Country":"'.$Country.'","State":"'.$State.'","City":"'.$City.'","PostalCode":"'.$PostalCode.'","custImage":"'.$fileTxt.'","DialCodeOther":"'.$DialCodeOther.'","custImageURL":"Joomla", "ActivationKey":"123456789"}';
            curl_setopt($ch, CURLOPT_POSTFIELDS,'{"CustId":"'.$CustId.'","PrimaryNumber":"'.$PrimaryNumber.'","AlternativeNumber":"'.$AlternativeNumber.'","Fax":"'.$Fax.'","DailCode":"'.$DailCode.'","PrimaryEmail":"'.$PrimaryEmail.'","AlternativeEmail":"'.$AlternativeEmail.'","AddressAccounts":"'.$AddressAccounts.'","addr_2_name":"'.$address2Txt.'","Country":"'.$Country.'","State":"'.$State.'","City":"'.$City.'","PostalCode":"'.$PostalCode.'","custImage":"'.$fileTxt.'","DialCodeOther":"'.$DialCodeOther.'","custImageURL":"Joomla", "ActivationKey":"123456789"}');
        }else{
            //echo '{"CustId":"'.$CustId.'","PrimaryNumber":"'.$PrimaryNumber.'","AlternativeNumber":"'.$AlternativeNumber.'","Fax":"'.$Fax.'","DailCode":"'.$DailCode.'","PrimaryEmail":"'.$PrimaryEmail.'","AlternativeEmail":"'.$AlternativeEmail.'","AddressAccounts":"'.$AddressAccounts.'","addr_2_name":"'.$address2Txt.'","Country":"'.$Country.'","State":"'.$State.'","City":"'.$City.'","PostalCode":"'.$PostalCode.'", "custImage":"'.$profilepic.'","DialCodeOther":"'.$DialCodeOther.'","custImageURL":"Joomla", "ActivationKey":"123456789"}';
            curl_setopt($ch, CURLOPT_POSTFIELDS,'{"CustId":"'.$CustId.'","PrimaryNumber":"'.$PrimaryNumber.'","AlternativeNumber":"'.$AlternativeNumber.'","Fax":"'.$Fax.'","DailCode":"'.$DailCode.'","PrimaryEmail":"'.$PrimaryEmail.'","AlternativeEmail":"'.$AlternativeEmail.'","AddressAccounts":"'.$AddressAccounts.'","addr_2_name":"'.$address2Txt.'","Country":"'.$Country.'","State":"'.$State.'","City":"'.$City.'","PostalCode":"'.$PostalCode.'", "custImage":"'.$profilepic.'","DialCodeOther":"'.$DialCodeOther.'","custImageURL":"Joomla", "ActivationKey":"123456789"}');
        }
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
		//var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Description;
    }
    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getadduser($CustId, $typeuserTxt,$idTxt,$fnameTxt, $lnameTxt,$country2Txt, $state2Txt, $city2Txt, $PostalCode, $addressTxt,$addressTxt,$emailtxt)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/CustomerInfoApi/InsertOrUpdateAdditionalAddress';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"name_f":"'.$fnameTxt.'","name_l":"'.$lnameTxt.'","id_cntry":"'.$country2Txt.'","id_state":"'.$state2Txt.'","id_city":"'.$city2Txt.'","IdAdduser":"'.$idTxt.'","IdUserType":"ConsigneeUser","UserType":"'.$typeuserTxt.'","_IdAdduser":"'.$idTxt.'","addr1Name":"'.$addressTxt.'","CustId":"'.$CustId.'","ActivationKey":"123456789","email_name":"'.$emailtxt.'","postal_addr":"'.$PostalCode.'"}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
        //echo '{"name_f":"'.$fnameTxt.'","name_l":"'.$lnameTxt.'","id_cntry":"'.$country2Txt.'","id_state":"'.$state2Txt.'","id_city":"'.$city2Txt.'","IdAdduser":"'.$idTxt.'","IdUserType":"ConsigneeUser","UserType":"'.$typeuserTxt.'","_IdAdduser":"'.$idTxt.'","addr1Name":"'.$addressTxt.'","CustId":"'.$CustId.'","ActivationKey":"123456789","email_name":"'.$emailtxt.'","postal_addr":"'.$PostalCode.'"}';
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Description;
    }
    
    
    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getadduserpay($CustId,$gettypeuser,$getid,$getfname,$getlname,$getcountry,$getstate,$getcity,$getzip,$getaddress,$getaddress2,$getemail)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/CustomerInfoApi/InsertOrUpdateAdditionalAddress';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"name_f":"'.$getfname.'","name_l":"'.$getlname.'","id_cntry":"'.$getcountry.'","id_state":"'.$getstate.'","id_city":"'.$getcity.'","IdAdduser":"'.$getid.'","IdUserType":"ConsigneeUser","UserType":"'.$gettypeuser.'","_IdAdduser":"'.$getid.'","addr1Name":"'.$getaddress.'","CustId":"'.$CustId.'","ActivationKey":"123456789","email_name":"'.$getemail.'","postal_addr":"'.$getzip.'"}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
        //echo '{"name_f":"'.$getfname.'","name_l":"'.$getlname.'","id_cntry":"'.$getcountry.'","id_state":"'.$getstate.'","id_city":"'.$getcity.'","IdAdduser":"'.$idTxt.'","IdUserType":"ConsigneeUser","UserType":"'.$gettypeuser.'","_IdAdduser":"'.$getid.'","addr1Name":"'.$getaddress.'","CustId":"'.$CustId.'","ActivationKey":"123456789","email_name":"'.$getemail.'","postal_addr":"'.$getzip.'"}';
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Description;
    }
    
    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function geteditadduser($CustId,$fid, $typeuserTxt, $idTxt, $fnameTxt, $lnameTxt,$country2Txt, $state2Txt, $city2Txt, $PostalCode, $addressTxt,$address2Txt, $emailTxt)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/CustomerInfoApi/InsertOrUpdateAdditionalAddress';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"addtAddrId":"'.$fid.'","name_f":"'.$fnameTxt.'","name_l":"'.$lnameTxt.'","id_cntry":"'.$country2Txt.'","id_state":"'.$state2Txt.'","id_city":"'.$city2Txt.'","IdAdduser":"'.$idTxt.'","IdUserType":"ConsigneeUser","UserType":"'.$typeuserTxt.'","_IdAdduser":"'.$idTxt.'","addr1Name":"'.$addressTxt.'","addr2Name":"'.$address2Txt.'","IdCust":"'.$CustId.'",	"ActivationKey":"123456789","email_name":"'.$emailTxt.'","postal_addr":"'.$PostalCode.'"}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Description;
    }

    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getaddshippment($CustId, $mnameTxt, $carrierTxt,$carriertrackingTxt, $orderdateTxt, $addinvoiceTxt, $anameTxt, $quantityTxt,$declaredvalueTxt,$totalpriceTxt,$itemstatusTxt,$countryTxt,$stateTxt)
    {
        
        $loop='';
        for($i=0;$i<count($anameTxt);$i++){
            $loop.='{"ItemName":"'.$anameTxt[$i].'","ItemQuantity":"'.$quantityTxt[$i].'","ItemPrice":"'.$declaredvalueTxt[$i].'","TotalPrice":"'.$totalpriceTxt[$i].'","ItemStatus":"'.$itemstatusTxt[$i].'"}';    
        }
        if($stateTxt=="0"){
            $stateTxt='';
        }
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/ShipmentsAPI/AddPurchaseOrder1';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"CustomerId":"'.$CustId.'","SupplierId":"'.$mnameTxt.'","CarrierId":"'.$carrierTxt.'","TrackingId":"'.$carriertrackingTxt.'", "OrderDate":"'.$orderdateTxt.'","ItemImage":"'.$addinvoiceTxt.'","Dest_Cntry":"'.$countryTxt.'","Dest_Hub":"'.$stateTxt.'","ItemUrl":"Joomla","ActivationKey":"123456789","liInventoryPurchasesVM":['.$loop.']}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
		//echo '{"CustomerId":"'.$CustId.'","SupplierId":"'.$mnameTxt.'","CarrierId":"'.$carrierTxt.'","TrackingId":"'.$carriertrackingTxt.'", "OrderDate":"'.$orderdateTxt.'","ItemImage":"'.$addinvoiceTxt.'","Dest_Cntry":"'.$countryTxt.'","Dest_Hub":"'.$stateTxt.'","ItemUrl":"Joomla","ActivationKey":"123456789","liInventoryPurchasesVM":['.$loop.']}';
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Description;
    }


    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getaddshippment_($CustId, $mnameTxt, $carrierTxt,$carriertrackingTxt, $orderdateTxt, $addinvoiceTxt, $anameTxt, $quantityTxt,$declaredvalueTxt,$totalpriceTxt,$itemstatusTxt)
    {
        $loop='';
        for($i=0;$i<count($anameTxt);$i++){
            $loop.='{"ItemName":"'.$anameTxt[$i].'","ItemQuantity":"'.$quantityTxt[$i].'","ItemPrice":"'.$declaredvalueTxt[$i].'","TotalPrice":"'.$totalpriceTxt[$i].'","ItemStatus":"'.$itemstatusTxt[$i].'"},';    
        }
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/ShipmentsAPI/AddPurchaseOrder1';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"CustomerId":"'.$CustId.'","SupplierId":"'.$mnameTxt.'","CarrierId":"'.$carrierTxt.'","TrackingId":"'.$carriertrackingTxt.'", "OrderDate":"'.$orderdateTxt.'","ItemImage":"'.$addinvoiceTxt.'","ItemUrl":"frontend","ActivationKey":"123456789","liInventoryPurchasesVM":['.$loop.']}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Description;
    }


    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function addShopperassist($CustId, $txtMerchantName, $txtMerchantWebsite,$txtItemName, $txtItemModel, $txtItemRefference, $txtColor, $txtSize,$txtQuantity,$txtDvalue,$txtTprice,$txtItemurl,$txtItemdescription)
    {
        //echo '{"CommandType":"InsertPurchase","CreatedBy":"'.$CustId.'","CustomerId":"'.$CustId.'","ItemDesc":"'.$txtItemdescription.',", "ItemName":"'.$txtItemName.',","ItemPrice":"'.$txtDvalue.',","ItemQuantity":"'.$txtQuantity.',","Merchant_Website":"'.$txtMerchantWebsite.'","PurchaseType":"Abe","SupplierId":"'.$txtMerchantName.'" ,"TotalPrice":"'.$txtTprice.',","color":"'.$txtColor.',","itemmodel":"'.$txtItemModel.',","sku":"'.$txtItemRefference.',","ItemUrl":"'.$txtItemurl.',","OrderDate":"","size":"'.$txtSize.',","Company":"","EditLevel":"","TrackingId":"","CarrierId":""}';
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/ShopperAssistAPI/InsertItemDetails';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"CommandType":"InsertPurchase","CreatedBy":"'.$CustId.'","CustomerId":"'.$CustId.'","ItemDesc":"'.$txtItemdescription.',", "ItemName":"'.$txtItemName.',","ItemPrice":"'.$txtDvalue.',","ItemQuantity":"'.$txtQuantity.',","Merchant_Website":"'.$txtMerchantWebsite.'","PurchaseType":"Abe","SupplierId":"'.$txtMerchantName.'" ,"TotalPrice":"'.$txtTprice.',","color":"'.$txtColor.',","itemmodel":"'.$txtItemModel.',","sku":"'.$txtItemRefference.',","ItemUrl":"'.$txtItemurl.',","OrderDate":"","size":"'.$txtSize.',","Company":"","EditLevel":"","TrackingId":"","CarrierId":""}');
       curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Description;
    }

   /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getShopperassistList($CustId)
    {

        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/ShopperAssistAPI/GetShopperAssistList';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"CommandType":"GetPurchaseDet","CustomerId":"'.$CustId.'","purchaseType":"Shweeboinp"}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
		//var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Data;
    }

   /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getareturnshippment($CustId, $txtqty,$txtBackCompany, $txtReturnAddress,$txtReturnCarrier, $txtReturnReason, $txtOriginalOrderNumber,$txtMerchantNumber,$txtSpecialInstructions, $dest1,$txtWArehousid,$txtIdkid)
    {

        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/ShipmentsAPI/CreateBillFormReturnDiscardHold';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        //curl_setopt($ch, CURLOPT_POSTFIELDS,'{"Qty":"'.$txtqty.'","bill_form_no":"'.$txtWArehousid.'","bill_no":"'.$txtOriginalOrderNumber.'","idkAlert":"'.$txtIdkid.'","item_Status":"Return", "merchant_mo":"'.$txtMerchantNumber.'","r_reason":"'.$txtReturnReason.'","r_s_carrier":"'.$txtReturnCarrier.'","returnAddr":"'.$txtReturnAddress.'","returnCompany":"'.$txtBackCompany.'","spe_instions":"'.$txtSpecialInstructions.'"}');
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"bill_form_no":"'.$txtWArehousid.'","bill_no":"'.$txtOriginalOrderNumber.'","item_Status":"Return","ActivationKey":"123456789","merchant_rno":"'.$txtMerchantNumber.'","r_reason":"'.$txtReturnReason.'","r_s_carrier":"'.$txtReturnCarrier.'","returnAddr":"'.$txtReturnAddress.'","returnCompany":"'.$txtBackCompany.'","spe_instions":"'.$txtSpecialInstructions.'","UploadedFail":"'.$dest1.'"}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Description;
    }


   /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getaholdshippment($CustId,$txtqty, $txtReturnReason,$txtWArehousid,$txtIdkid)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/shipmentsapi/CreateBillFormReturnDiscardHold';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"bill_form_no":"'.$txtWArehousid.'","item_Status":"Hold","r_reason":"'.$txtReturnReason.'","ActivationKey":"123456789"}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
		//var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Description;
    }

   /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getdiscardshippment($CustId,$txtQty, $txtReturnReason,$txtWArehousid,$txtIdkid)
    {

        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/shipmentsapi/CreateBillFormReturnDiscardHold';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"Qty":"'.$txtQty.'","bill_form_no":"'.$txtWArehousid.'","idkAlert":"'.$txtIdkid.'","item_Status":"Discard","ActivationKey":"123456789","r_reason":"'.$txtReturnReason.'"}');
        //echo '{"Qty":"'.$txtQty.'","bill_form_no":"'.$txtWArehousid.'","idkAlert":"'.$txtIdkid.'",	"item_Status":"Discard","ActivationKey":"123456789","r_reason":"'.$txtReturnReason.'"}';
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
		//var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Description;
    }

    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    
    public static function getadduserdeleteInfo($deleteadduserid)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/customerInfoApi/delAddtionalAddr?addtAddrId='.$deleteadduserid;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        //var_dump(strlen($result));
        if(strlen($result)==21)
        return 1;
        else
        return 0;
    }       


    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    
    public static function getUsersorderscount($user)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/dashboardapi/GetCustomerDetailsByCustId?CustId='.$user.'&ActivationKey=123456789';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Data;
    }       


     /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getDialCodeList($countryid)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/RegistrationAPI/GetDailCodes?ActivationKey=123456789';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        return $result;
    }  


     /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getQuotationProcess($id)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/PickupOrderAPI/GenPickupOrderFromQuo?idkQuotation='.$id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        $msg=json_decode($result);
        return $msg->Msg;
    }  


    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getOrdersList($user)
    {
         mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/ShipmentsAPI/GetInvertoryPurchases';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"CustomerId":"'.$user.'","ActivationKey":"123456789"}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Data->liInventoryPurchasesVM;
   }

    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getOrdersPendingList($user)
    {
         mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/ShipmentsAPI/GetOrdersbyStatus';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"CustomerId":"'.$user.'","PurchaseType":"My1","Status":"Received","ActivationKey":"123456789"}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Data->liInventoryPurchasesVM;
   }


    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getOrdersHoldList($user)
    {
         mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/ShipmentsAPI/GetOrdersbyStatus';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"CustomerId":"'.$user.'","PurchaseType":"My1","Status":"Hold","ActivationKey":"123456789"}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Data->liInventoryPurchasesVM;
   }


    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getOrdersHistoryList($user)
    {
         mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/ShipmentsAPI/GetOrdersbyStatus';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"CustomerId":"'.$user.'","ActivationKey":"123456789","PurchaseType":"History","Status":"All"}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Data->liInventoryPurchasesVM;
   }

    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getInvertoryPurchasesList($user)
    {
         mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/ShipmentsAPI/AddPurchaseOrder';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"CustomerId":"'.$user.'","ActivationKey":"123456789"}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Data->liInventoryPurchasesVM;
   }

    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getInvoicedetailsList($user)
    {
         mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/shipmentsapi/getinvoicedetails';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'{"CustomerId":"'.$user.'","CmdType":"getinvoicedetails","ActivationKey":"123456789"}');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Data;
   }



    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getQuotationShipmentsList($user)
    {
         mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/QuotationAPI/GetShipments?custId='.$user;
        $ch = curl_init();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        $rs='';
        $i=1;
        foreach($msg as $rg){
            $cv='';
            if($rg->status=="Approved"){
               $cv='<a data-toggle="modal" data-target="#inv_view"  data-id="'.$rg->number_quotation.':'.$rg->id_cust.'" >'.Jtext::_('PICKUP ORDER').'</a>'; 
            }
          $rs.= '<tr><td>'.$i.'</td><td>'.$rg->number_quotation.'</td><!--<td>'.$rg->number_pickup_order.'</td>--><td>'.$rg->bill_form_no.'</td><td>'.$rg->status.'</td><td>'.$rg->totalQty.'</td><td>'.$rg->dti_created.'</td></tr>';
          $i++;
        }        
        return $rs;
   }
    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getPreAlertsList($user)
    {
         mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/DashBoardAPi/GetPreAlerts?custId='.$user.'&ActivationKEy=123456789';
        $ch = curl_init();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        $rs='';
        $i=1;
        foreach($msg->Data as $rg){
          $rs.= '<tr><td>'.$i.'</td><td>'.$rg->parant_id.'</td><td>'.$rg->msg.'</td><td>'.$rg->dti_created.'</td></tr>';
          $i++;
        }        
        return $rs;
   }

    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getAdditionalUsersSelect($user)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/CustomerInfoApi/GetAdditionaluserByCustomerId?id_cust='.$user.'&ActivationKey=123456789';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);

        $additionalUsersView= '<option value="0">'.Jtext::_('PLEASE_SELECT_ADDITIONAL_USER').'</option>';
        foreach($msg->Data as $rg){
          if($rg->NameAdduser!=" "){
           $additionalUsersView.= '<option value="'.$rg->id_cust.':'.$rg->id_cntry.'" '.$sel. '>'.$rg->NameAdduser.'</option>';
          }
        }
        return $additionalUsersView;
    }

    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getAdditionalUsersDetails($user)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/CustomerInfoApi/GetAdditionaluserByCustomerId?id_cust='.$user.'&ActivationKey=123456789';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        $rs='';
        $i=1;
        foreach($msg->Data as $rg){
          $rs.= '<tr><td>'.$i.'</td><td>'.$rg->NameAdduser.'</td><td>'.$rg->AddtEmail.'</td><td>'.$rg->userType.'</td><td>'.$rg->CntryName.'</td><td>'.$rg->StateName.'</td><td>'.$rg->CityName.'</td><td>'.$rg->postal_addr.'</td><td>'.$rg->Addr1Name.'</td><td>'.$rg->Addr2Name.'</td><td class="action_btns"><a href="#" class="btn btn-primary" data-backdrop="static" data-keyboard="false" data-toggle="modal"  data-id='.$rg->addtAddrId.' data-target="#ord_edit"><i class="fa fa-pencil-square-o"></i></a><a href="#" class="btn btn-danger"  data-toggle="modal"  data-id='.$rg->addtAddrId.' data-target="#ord_delete"><i class="fa fa-trash"></i></a></td></tr>';
          $i++;
        }        
        return $rs;
    }
    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getBindShipingAddress($user,$bilform)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/shipmentsAPi/BindShipingAddress?CustId='.$user.'&Activationkey=123456789&billformnum='.$bilform;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return str_replace(",","<br>",$msg->Data->addres);
    }


    /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getUserTickets($user)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api//SupportTicketAPI/GetTicketDetailsByCustomerId?id_cust='.$user.'&ActivationKey=123456789';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg->Data;
    }
    
     /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getcitiesInfo($cid,$sid,$citid)
    {
        
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/RegistrationAPI/Cities?stateId='.$sid.'&ActivationKey=123456789';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        
        $rescities = json_decode($result); 
        $cities='';
        foreach($rescities->Data as $rg){
          if($citid==$rg->CityCode){ 
              $cities.= $rg->CityDesc;
          }
        }        
        return $cities;
    }  

    public static function getstateInfo($cid,$sid)
    {
          mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/RegistrationAPI/States?countryId='.$cid.'&ActivationKey=123456789';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        $states='';
        $result = json_decode($result); 
        foreach($result->Data as $rg){
          //echo  utf8_encode($sid).'------'.utf8_encode($rg->StateDesc).'<br>';
          if(utf8_encode(trim($sid))==utf8_encode(trim($rg->StateDesc))){ 
            $states=$rg->StatesId;
          }
        } 
        return $states;
    }  
    
     /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getCitiesListOne($countryid,$stateid,$cityid)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/RegistrationAPI/Cities?stateId='.$stateid.'&ActivationKey=123456789';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        
        $rescities = json_decode($result); 
        foreach($rescities->Data as $rg){
           if($cityid==$rg->CityCode){
               $cities= $rg->CityDesc;
           }
        }        
        return $cities;
    }  
    
    
      /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getFnameDetails($user,$f,$l)
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/CustomerInfoApi/GetAdditionaluserByCustomerId?id_cust='.$user.'&ActivationKey=123456789';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        foreach($msg->Data as $rg){
          //echo $f.'0000'.$rg->name_f.'---'.$l.'00000'.$rg->name_l.'<br>';
          if($l==$rg->name_l && $f==$rg->name_f){
            return 1;
          }
          
        }

    }
    
    
    
      /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getServiceList()
    {
        mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/CalculatorAPI/getDefaultAdditionalService';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        return $msg;

    }
    
  /**
     * Gets the edit permission for an user
     *
     * @param   mixed  $item  The item
     *
     * @return  bool
     */
    public static function getsearchtrackingids($rec)
    {
       mb_internal_encoding('UTF-8');  
        $content_params =JComponentHelper::getParams( 'com_userprofile' );
        $url=$content_params->get( 'webservice' ).'/api/shipmentsapi/getmomentumlog?billformno='.$rec;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result=curl_exec($ch);
        //var_dump($result);exit;
        $msg=json_decode($result);
        if($msg->Data==""){
          return 2;
        }else{
            $mlg='';
            //$mlg='<div class="row"><div class="col-sm-6"><div class="form-group"><label>Tracking No : </label>'.$rec.'</div></div></div>';
            //$mlg.='<table class="table table-bordered theme_table" id="u_table"><thead><tr><th>Status</th><th>Date</th></tr></thead><tbody>';
            foreach($msg->Data as $rg){
              $mlg.='<tr><td>'.$rg->Status.'</td><td>'.$rg->CreatedDate.'</td></tr>';
            }
            //$mlg.='</tbody></table>';
            return $mlg;    
        }
    }    
}