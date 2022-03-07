<!DOCTYPE html>
<html>
   <head>
      <!-- TABLES CSS CODE -->
      <?php include"comman/code_css_form.php"; ?>
      <!-- </copy> -->  
   </head>
   <body class="hold-transition skin-blue sidebar-mini">
      <div class="wrapper">
         <?php include"sidebar.php"; ?>
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <h1>
                  <?= $page_title;  ?>
                  <small>Enter Branch Information</small>
               </h1>
               <ol class="breadcrumb">
                  <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                  <li><a href="<?php echo $base_url; ?>branchs"><?= $this->lang->line('branch'); ?></a></li>
                  <li class="active"><?= $page_title; ?></li>
               </ol>
            </section>
            <!-- Main content -->
            <section class="content">
               <div class="row">
                  <!-- ********** ALERT MESSAGE START******* -->
                  <?php include"comman/code_flashdata.php"; ?>
                  <!-- ********** ALERT MESSAGE END******* -->
                  <!-- right column -->
                  <div class="col-md-12">
                     <!-- Horizontal Form -->
                     <div class="box box-info ">
                        <!-- /.box-header -->
                        <!-- form start -->
                            <?= form_open('#', array('class' => 'form-horizontal', 'id' => 'departments-form', 'enctype'=>'multipart/form-data', 'method'=>'POST'));?>
                           <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                           <input type="hidden" name="command" value="<?php echo $command;; ?>">
                           <div class="box-body">
                              <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="new_department" class="col-sm-4 control-label"><?= $this->lang->line('name'); ?><label class="text-danger">*</label></label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control input-sm" id="name" name="name" placeholder="" onkeyup="shift_cursor(event,'name')" value="<?php print $name; ?>" <?=$disabled;?> autofocus>
                                       <span id="name" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                                 
                                 </div>
                              </div>
                             
                               
                              </div>
                           </div>
                           <!-- /.box-body -->
                            <div class="box-footer">
                              <div class="col-sm-8 col-sm-offset-2 text-center">
                                 <!-- <div class="col-sm-4"></div> -->
                                 <?php
                                    if($name!=""){
                                         $btn_name="Update";
                                         $btn_id="update";
                                    
                                    }
                                       else{
                                          $btn_name="Save";
                                          $btn_id="save";
                                       }
                                    
                                 ?>
                                 <input type="hidden" name="q_id" id="q_id" value="<?php echo $q_id;?>"/>
                                 <div class="col-md-3 col-md-offset-3">
                                    <button type="button" id="<?php echo $btn_id;?>" class=" btn btn-block btn-success" title="Save Data"><?php echo $btn_name;?></button>
                                 </div>
                                 <div class="col-sm-3">
                                    <a href="<?=base_url('dashboard');?>">
                                    <button type="button" class="col-sm-3 btn btn-block btn-warning close_btn" title="Go Dashboard">Close</button>
                                    </a>
                                 </div>
                              </div>
                           </div>
                           <!-- /.box-footer -->
                        <?= form_close(); ?>
                     </div>
                     <!-- /.box -->
                  </div>
                  <!--/.col (right) -->
               </div>
               <!-- /.row -->
            </section>
            <!-- /.content -->
         </div>
         <!-- /.content-wrapper -->
         <?php include"footer.php"; ?>
         <!-- Add the sidebar's background. This div must be placed
            immediately after the control sidebar -->
         <div class="control-sidebar-bg"></div>
      </div>
      <!-- ./wrapper -->
      <!-- SOUND CODE -->
      <?php include"comman/code_js_sound.php"; ?>
      <!-- TABLES CODE -->
      <?php include"comman/code_js_form.php"; ?>
      <script src="<?php echo $theme_link; ?>js/branchs.js"></script>
      <!-- Make sidebar menu hughlighter/selector -->
      <script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
   </body>
</html>
