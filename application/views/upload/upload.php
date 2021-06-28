<html>
    <head>
        <meta charset="utf-8">
        <title>Student List</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets/css/bootstrap.css' ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets/css/jquery.dataTables.css' ?>">
    </head>
    <body>
        <div class="container">
            <!-- Page Heading -->
            <div class="row">
<div class="col-md-10">        
    <h2 class="panel_heading_style">Trainee - Bulk Registration</h2>        
    <div class="table-responsive">
    
        <?php
        //if($error) echo '<font color="red">'.$error.'</font>';
        // echo validation_errors('<div class="error">', '</div>'); 
        if ($this->session->flashdata('success')) {
            echo '<div class="success">' .$this->session->flashdata('success'). '</div>';
        }
        if ($this->session->flashdata('error_message')) {
            echo '<div class="error1">' . $this->session->flashdata('error_message') . '</div>';
        }
        ?>
        <?php $form_attributes = array('name' => 'bulk_registration', 'id' => 'bulk_registration', "onsubmit" => "return(validate());");
        echo form_open_multipart("trainee/bulk_registration", $form_attributes);
        ?>
        <table class="table table-striped">
          <tbody>
            <tr>
              <td width="20%" class="td_heading">Import Trainee Detail:<span class="required">*</span></td>
              <td colspan="2" width="25%">
                  <input name="userfile" type="file" id="xls_file" onchange="validate_trainee_bulk(this)" > 
                  <span id="xls_file_err"></span>
              </td>
              <td width="18%" ><button type="submit" name="upload" id="upload" value="upload" class="btn btn-xs btn-primary no-mar"><span class="glyphicon glyphicon-upload"></span> Upload</button> <span style="font-weight:bold;">(xls or xlsx)</span></td>
              <td colspan="3" width="20%">
              <span class="pull-right"><a href="<?php echo base_url().'trainee/download_xls';?>" class="small_text1">
              <span class="label label-default black-btn"><span class="glyphicon glyphicon-download-alt"></span> Download Import XLS</span></a></span> 
              </td>
            </tr>
          </tbody>
        </table>
        <?php echo form_close(); ?>      
    </div>   
    <div class="table-responsive">
        <table class="table table-striped">
        <tr>
		<?php if($files && $trainee_data){ ?>
            <td width="20%">
                           
                <span class="pull-right"><a href="<?php echo base_url()."trainee/download_import_xls/".$files;?>" class="small_text1">
              <span class="label label-default black-btn"><span class="glyphicon glyphicon-export"></span> Export to XLS</span></a></span> 
            </td>
		<?php } ?>
        </tr>
        </table>
   </div>            
    <h2 class="sub_panel_heading_style"><span class="glyphicon glyphicon-zoom-in"></span> Import Preview </h2>
    <div class="excel">
    <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>NRIC/FIN No.</th>
              <th>Account Type</th>
              <th>Company Name</th>
              <th>User Name</th>
              <th>Password</th>
              <th>Name</th>              
              <th>Import Status</th>
              <th>Failure Reason</th>
            </tr>
          </thead>
        <tbody>
          <?php         
          foreach($trainee_data as $k=>$data){       
        ?>
             <?php if($k != 'flag'){?>  <!--added by shubhranshu-->
              <tr>
                <td>
                <?php 
                if(empty($data['taxcode'])){
                    echo $data['userid'];
                    
                }else{
                    echo $data['taxcode'];} ;?> 
                </td>
                <td> <?php echo ($data['CompanyCode'])?'Company':'Individual';?></td>
                <td> <?php echo ($data['CompanyName'])?$data['CompanyName'].'('.$data['CompanyCode'].')':$data['CompanyCode'];?></td>
                <td> <?php echo $data['username'];?></td>
                <td> <?php echo $data['password'];?></td>
                <td> <?php echo $data['firstname'];?></td>                
                <td> <?php if($data['rowstatus'] == 'fail') echo '<font color="red" > Failed. </font>'; else echo '<font color="green"> Success. </font>';?></td>
                <td> <?php if($data['rowstatus'] == 'fail') echo $data['failure_reason']; ?></td>
              </tr>
          <?php  } 
    
            }?>
        </tbody>
        </table>
        </div>
    </div>          
          
    <div style="clear:both;"></div><br>
          <span class="required required_i"><i>(Password will be auto-generated by the application and the accounts will be activated by-passing the requirement for activation by email.)</i><br><br></span>
          <span class="required required_i">* Required Fields</span>
    </div>
            </div>
        </div>
    </body>
</html>


<!--//////////////////////////////////////////////////////-->
<script>
function validate() {
    var result = validate_trainee_bulk();
    if(result == false){
        return false;
    }else {
        check_nric_restriction();
        return true;
    }
}    
function check_nric_restriction(){
    $.ajax({
            url: "check_nric_restriction",
            type: "post",
            dataType: "json",
            data: {tax_code: $nric},
            success: function(res) {
                if (res == 1) {
                    $('#ex111').modal();
                } 
            }
    });
}
</script>

