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
                  All Sales Report
                  <small></small>
               </h1>
               <ol class="breadcrumb">
                  <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                  <li class="active">All Sales Report</li>
               </ol>
            </section>
          
            <section class="content">
               <div class="row">
                  <!-- right column -->
                  <div class="col-md-12">
                     <div class="box" id="report-data-all">
                        <div class="box-header">
                           <h3 class="box-title">Sales Information (<?php echo show_date(date('d-m-Y'));?>)</h3>
                           <button type="button" class="btn btn-info pull-right btnExport" title="Download Data in Excel Format">Excel</button>
                        </div>
                        <!-- /.box-header -->
                        <h4 >Total Income</h4>
                        <div class="box-body table-responsive no-padding">
                           <table class="table table-bordered table-hover" id="report-data">
                              <thead>
                                 <tr >
                                    <th >#</th>
                                    <th >Daily </th>
                                    <th >Monthly</th>
                                    <th >Yearly</th>
                                 </tr>
                              </thead>
                              <tbody id="tbodyid">
                                 <tr>
                                        <td> Total Invoice </td>
                                        <td ><?php echo $dailyInvoices;?></td>
                                        <td ><?php echo $monthlyInvoices;?></td>
                                        <td ><?php echo $yearlyInvoices;?></td>
                                  </tr>
                                  <?php $paymentsSum = 0;?>
                                  <?php $paymentsSum1 = 0;?>
                                  <?php $paymentsSum2 = 0;?>
                                  <?php $paymentsSum3 = 0;?>
                                  <?php $paymentsMonlthlySum = 0;?>
                                  <?php $paymentsMonlthlySum1 = 0;?>
                                  <?php $paymentsMonlthlySum2 = 0;?>
                                  <?php $paymentsMonlthlySum3 = 0;?>
                                  <?php $paymentsYearlySum = 0;?>
                                  <?php $paymentsYearlySum1 = 0;?>
                                  <?php $paymentsYearlySum2 = 0;?>
                                  <?php $paymentsYearlySum3 = 0;?>
                                  <?php $receivable = 0;?>
                                  <?php $receivable1 = 0;?>
                                  <?php $receivable2 = 0;?>
                                  <?php $paymentsMonthlySum = 0;?>
                                  <?php $paymentsMonthlySum1 = 0;?>
                                  <?php $paymentsMonthlySum2 = 0;?>
                                  <?php $paymentsMonthlySum3 = 0;?>
                                  <?php $total = 0;?>
                                  <?php $total1 = 0;?>
                                  <?php $total2 = 0;?>
                                  
                                  
                                <?php foreach($payments->result() as $sale){ ?>
                                  <tr>
                                        <td> <?php echo $sale->payment_type; ?></td>
                                        <td > <?php echo $sale->daily_sales; ?> </td>
                                        <td > <?php echo $sale->monthly_sales; ?> </td>
                                        <td > <?php echo $sale->yearly_sales; ?> </td>
                                      <?php   $paymentsSum  += $sale->daily_sales ?>
                                      <?php   $paymentsMonthlySum  += $sale->monthly_sales ?>
                                      <?php   $paymentsYearlySum  += $sale->yearly_sales ?>
                                  </tr>
                                  <?php } ?>
                                  
                                  <?php foreach($paymentsHaierSale->result() as $sale){ ?>
                                  <tr>
                                       <td> Haier Sale</td>
                                        <td > <?php echo $sale->daily_sales; ?> </td>
                                        <td > <?php echo $sale->monthly_sales; ?> </td>
                                        <td > <?php echo $sale->yearly_sales; ?> </td>
                                        <?php   $paymentsSum1  += $sale->daily_sales ?>
                                        <?php   $paymentsMonthlySum1  += $sale->monthly_sales ?>
                                        <?php   $paymentsYearlySum1  += $sale->yearly_sales ?>
                                  </tr>
                                  <?php } ?>
                                  <?php foreach($paymentsDownPayment->result() as $sale){ ?>
                                  <tr>
                                       <td> Down Payment</td>
                                        <td > <?php echo $sale->daily_down_payment; ?> </td>
                                        <td > <?php echo $sale->monthly_down_payment; ?> </td>
                                        <td > <?php echo $sale->yearly_down_payment; ?> </td>
                                        <?php   $paymentsSum2  += $sale->daily_down_payment ?>
                                        <?php   $paymentsMonthlySum2  += $sale->monthly_down_payment ?>
                                        <?php   $paymentsYearlySum2  += $sale->yearly_down_payment ?>
                                  </tr>
                                  <?php } ?>

                                  <?php foreach($installmentPayment->result() as $sale){ ?>
                                  <tr>
                                       <td> Installment Amount</td>
                                        <td > <?php echo $sale->daily_installment; ?> </td>
                                        <td > <?php echo $sale->monthly_installment; ?> </td>
                                        <td > <?php echo $sale->yearly_installment; ?> </td>
                                        <?php   $paymentsSum3  += $sale->daily_installment ?>
                                        <?php   $paymentsMonthlySum3  += $sale->monthly_installment ?>
                                        <?php   $paymentsYearlySum3  += $sale->yearly_installment ?>
                                  </tr>
                                  <?php } ?>

                               

                                  <?php foreach($accountReceivable->result() as $sale){ ?>
                                  <tr>
                                       <td> Credit A/C Receivable</td>
                                        <td > <?php echo $sale->daily_receivable; ?> </td>
                                        <td > <?php echo $sale->monthly_receivable; ?> </td>
                                        <td > <?php echo $sale->yearly_receivable; ?> </td>
                                        <?php   $receivable  += $sale->daily_receivable ?>
                                        <?php   $receivable1  += $sale->monthly_receivable ?>
                                        <?php   $receivable2  += $sale->yearly_receivable ?>
                                  </tr>
                                  <?php } ?>
                              </tbody>
                              <tfoot>
                                    <tr>
                                        <th colspan="1" style="text-align:right">Total</th><!-- 6 -->
                                        <th><?php echo  $paymentsSum + $paymentsSum1 + $paymentsSum2 + $paymentsSum3 + $receivable ?></th>
                                        <th><?php echo   $paymentsMonthlySum + $paymentsMonthlySum1 + $paymentsMonthlySum2 + $paymentsMonthlySum3 + $receivable1  ?></th>
                                        <th><?php echo  $paymentsYearlySum + $paymentsYearlySum1 + $paymentsYearlySum2 + $paymentsYearlySum3 + $receivable2   ?></th>
                                    </tr>
                                </tfoot>
                           </table>
                        </div>
                        <h4>Income By Payment Type :</h4>
                        <div class="box-body table-responsive no-padding">
                           <table class="table table-bordered table-hover" id="report-data-cash" >
                              <thead>
                                 <tr >
                                    <th ># </th>
                                    <th >Daily </th>
                                    <th >Monthly</th>
                                    <th >Yearly</th>
                                 </tr>
                              </thead>
                              <tbody id="tbodyid">
                              <?php foreach($totalCash->result() as $sale){ ?>
                                  <tr>
                                        <td  > <?php echo $sale->payment_type ; ?></td>
                                        <td > <?php  
                                          echo $cash =  $sale->daily;
                                        ?>
                                         <?php   $total  += $sale->daily;    ?>
                                         <?php   $total1  += $sale->monthly;    ?>
                                         <?php   $total2  += $sale->yearly;    ?>
                                         </td>
                                        <td > <?php echo $sale->monthly; ?> </td>
                                        <td > <?php echo $sale->yearly; ?> </td>
                                    
                                  </tr>
                                  <?php } ?>
                                  
                               
                              </tbody>
                              <tfoot>
                                    <tr >
                                        <th  style="text-align:right">Total</th><!-- 6 -->
                                        <th><?php echo  $total   ?></th>
                                        <th><?php echo  $total1 ?></th>
                                        <th><?php echo  $total2 ?></th>
                                    </tr>
                                </tfoot>
                           </table>
                        </div>
                     </div>
                     <!-- /.box -->
                  </div>
               </div>
            </section>
         </div>
         <!-- /.content-wrapper -->
         <?php include"footer.php"; ?>
         <!-- Add the sidebar's background. This div must be placed
            immediately after the control sidebar -->
         <div class="control-sidebar-bg"></div>
      </div>
      <style>
               table#report-data {
         table-layout: fixed;
         width: 100%;  
         }
         table#report-data-cash {
         table-layout: fixed;
         width: 100%;  
         }
      </style>
      <!-- ./wrapper -->
      <!-- SOUND CODE -->
      <?php include"comman/code_js_sound.php"; ?>
      <!-- TABLES CODE -->
      <?php include"comman/code_js_form.php"; ?>
      <script src="<?php echo $theme_link; ?>js/sheetjs.js" type="text/javascript"></script>
      <script>
         function convert_excel(type, fn, dl) {
             var elt = document.getElementById('report-data-all');
             var wb = XLSX.utils.table_to_book(elt, {sheet:"Sheet JS"});
           
             return dl ?
                 XLSX.write(wb, {bookType:type, bookSST:true, type: 'base64'}) :
                 XLSX.writeFile(wb, fn || ('Sales-Report.' + (type || 'xlsx')));
         }
         $(".btnExport").click(function(event) {
          convert_excel('xlsx');
         });
      </script>
      <script src="<?php echo $theme_link; ?>js/report-sales.js"></script>
      <!-- Make sidebar menu hughlighter/selector -->
      <script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
   </body>
</html>
