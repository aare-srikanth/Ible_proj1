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
$document = JFactory::getDocument();
$document->setTitle("Boxon Pobox Software");
$session = JFactory::getSession();
$user=$session->get('user_casillero_id');
if($user==""){
?>
<style>ul.nav.menu.nav.navbar-nav.mod-list{display:block!important}</style>
<?php    
}
?>
<?php include 'dasboard_navigation.php' ?>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!-- 
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
-->  
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>

<script type="text/javascript">
var $joomla = jQuery.noConflict(); 
$joomla(document).ready(function() {
        $joomla('#u_table').DataTable({
        "pagingType": "simple", // "simple" option for 'Previous' and 'Next' buttons only
        "bPaginate": false,
        "bFilter" : false 
      });
 $joomla(function() {
 
 		// Initialize form validation on the registration form.
		// It has the name attribute "registration"
		$joomla("form[name='userprofileFormOne']").validate({
			
			// Specify validation rules
			rules: {
			  // The key name on the left side is the name attribute
			  // of an input field. Validation rules are defined
			  // on the right side
			  searchStr:{
					required: true
			  }
            },
			// Specify validation error messages
			messages: {
			   searchStr:{
				required: "Please enter tracking number"
			  }
      
			},
			// Make sure the form is submitted to the destination defined
			// in the "action" attribute of the form when valid
			submitHandler: function(form) {
			    //alert( $joomla('#stateTxt').val())
				// Returns successful data submission message when the entered information is stored in database.
				/*$.post("http://boxon.justfordemo.biz/index.php/register", {
					name1: name,
					email1: email,
					task: register,
					id:  0
				}, function(data) {
					$joomla("#returnmessage").append(data); // Append returned message to message paragraph.
					if (data == "Your Query has been received, We will contact you soon.") {
						$joomla("#registerFormOne")[0].reset(); // To reset form fields on success.
					}
				});*/
			  //form.submit();


			}
		});
    });		
	$joomla('.searchingtrack').live('click',function(){
    	$joomla('.utable').hide();
	    if($joomla('input[name=searchStr]').val()==""){
	        alert('Please enter tracking number');
	        return false;
	    }
        $joomla("#tracid").html($joomla('input[name=searchStr]').val());
	    var ntainer=$joomla(".cntr").html();
	    $joomla("#noLogs").html('');
	    
	    var panelbody=$joomla('#resultsId').html();
	    //$joomla("#searchsLogs").html('');
        $joomla.ajax({
			url: "<?php echo JURI::base(); ?>index.php?option=com_userprofile&task=user.get_ajax_data&searchid="+$joomla('input[name=searchStr]').val() +"&searchflag=1&jpath=<?php echo urlencode  (JPATH_SITE); ?>&pseudoParam="+new Date().getTime(),
			data: { "searchLogsid": 1 },
			dataType:"html",
			type: "get",
			beforeSend: function() {
                 $joomla("#noLogs").removeClass("alert alert-danger");
              $joomla("#resultsId").html('<div id="loading-image3" ><img src="/components/com_userprofile/images/loader.gif"></div>');
           },success: function(data){
               
               $joomla('#resultsId').html(panelbody);
               $joomla('.cntr').html(ntainer);
               if(data==2){
                 $joomla("#noLogs").addClass("alert alert-danger");
                 $joomla("#noLogs").html('Tracking Id does not exist.');
               }else{
        	     $joomla("#noLogs").removeClass("alert alert-danger");
                 $joomla('.utable').show();
                 
                 $joomla("#u_table .dataTables_empty").hide();
                 $joomla("#u_table tbody").html('');
                 $joomla("#u_table tbody").append(data);
               }
        	}
		});
    });	
    
    $joomla("input.searchinput").after('<span class="clearspace1"><i class="clear1" title="clear">&cross;</i></span>');
    $joomla("input.searchinput").on('keyup input',function(){
    if ($joomla(this).val()) {$joomla(".clear1").addClass("show");} else {$joomla(".clear1").removeClass("show");}
    });
    $joomla('.clear1').click(function(){
        $joomla('input.searchinput').val('').focus();
        $joomla(".clear1").removeClass("show");
    });

    
});
</script>
<div class="container">
	<div class="main_panel persnl_panel">
		<div class="main_heading">Track Your Shipment</div>
		<div class="panel-body">
			
		<form name="userprofileFormOne" id="userprofileFormOne" method="post" action="">
		<div id="tabs1">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label>Tracking No <span class="error">*</span></label>
						<div>
						<input type="text" class="form-control searchinput" name="searchStr" id="searchStr">
						</div>
					</div>
				</div>
		        <div class="col-sm-6">
		            <div class="form-group">
						
					<input type="button" class="btn btn-primary searchingtrack" style="margin-top:25px" value="Search" name="submit">
				</div>
				</div>
						
			</div>
			
		</div>
 
        <input type="hidden" name="id" value="0" />
		</form>
		<div id="resultsId">	
    		<div class="row">
              <div class="col-sm-12">
                <h3 class="mx-1"><strong>Tracking Search Results</strong></h3>
              </div>
            </div>
            <div class="row"><div class="col-sm-12"><div class="form-group"><label>Tracking No : <span id="tracid" style="style:color:red"></span></span></label></div></div></div>
        	<div class="row cntr">
                <div class="col-sm-12 utable">
            	    <table class="grd-tracknew table table-stripped table-bordered theme_table" id="u_table">
            	        <thead>
            	            <tr>
                                <th scope="col">&nbsp;</th>
                                <th scope="col">Track Number</th>
                                <th scope="col">Status</th>
            	            </tr>
            	       </thead>
            	       <tbody>
            	           <div id="searchsLogs"></div>
            	       </tbody>
            	   </table>
                </div>
    	    </div>
            <div class="row">
              <div class="col-sm-12">
               <div id="noLogs"></div>
              </div>
            </div>
        
        </div>
		
		</div>
		</div>
	</div>
</div>


<style type="text/css">
/* Track grid Styles start */

.grd-tracknew { /* border: 1px Solid #9F9F9F; max-width: 800px; margin: auto; font: 12px Tahoma, Geneva, sans-serif; */ }
.grd-tracknew a { /* text-decoration: none; color: #353535; */ }
.grd-tracknew th, .grd-tracknew td { width: auto; border: 0 !important; padding: 4px; }
.grd-tracknew th { width: auto; background: #2E3192 !important; color: #fff; text-align: left; }
.grd-tracknew tr:nth-child(even) { background-color:#EDEDEB }
.grd-tracknew tr:nth-child(odd) { background-color:#FFFF }
table.grd-tracknew tr td { width: auto; line-height: 24px; vertical-align: top; overflow: visible !important; }
table.grd-tracknew tr td:nth-child(1), table.grd-tracknew tr td:nth-child(2), .grd-tracknew table tr td:nth-child(4) { width: auto }
.tracknew-active { background: url(/components/com_userprofile/images/completed-state.png) no-repeat center 10px; position: relative; }
.tracknew-conline { background: url(/components/com_userprofile/images/con-line.png) repeat-y center 10px; position: absolute; top: 0px; bottom: 0; margin-top: 20px; margin-bottom: -20px; left: 16px; }
table.grd-tracknew tr:nth-child(2) td.tracknew-active { background: url(/components/com_userprofile/images/current-state.png) no-repeat center 8px; }
table.grd-tracknew tr:nth-child(2) td, table.grd-tracknew tr:nth-child(2) td a { color: #2E3192; font-weight: 600; }
table.grd-tracknew tr:last-child td span.tracknew-conline:last-child { background: none; }
/* Track grid Styles end */



    .searchinput{display:inline-block;vertical-align: bottom; padding-right: 30px;
    /* width:30%;padding: 5px;padding-right:27px;border:1px solid #ccc;
        outline: none; */
}
        .clearspace1{width: 20px;display: inline-block;margin-left:-25px;
}
.clear1 {
    width: 20px;
    transition: max-width 0.3s;overflow: hidden;float: right;
    display: block;max-width: 0px;
    top: -4px;
    position: relative;
}

.show{
    cursor: pointer;width: 20px;max-width:20px;
}
/* form{white-space: nowrap;} */

    </style>
    
   