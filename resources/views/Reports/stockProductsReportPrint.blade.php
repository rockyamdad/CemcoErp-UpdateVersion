<div class="modal-dialog shape">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <?php
                $userId=Session::get('user_id');
                $userName = \App\User::find($userId);
            ?>
            <?php
            use Illuminate\Support\Facades\URL;
            $curent_url = $_SERVER['REQUEST_URI'];

            if($curent_url == '/reports/printstocksproducts')
            {
            ?>
            <h3 class="page-title" style="text-align: center;"> All Stock Report  </h3>
            <?php }else{
            $stock = \App\StockInfo::find($stock_info_id);
            $cat = \App\Category::find($category_id);
            $branch = \App\Branch::find($branch_id);
            ?>

            <center>
                <h3 style="text-align: center;">zxczxcStock In Hand Report</h3>
                <b>For Category: {{$cat->name}} and Stock:{{$stock->name}} and Branch {{$branch->name}}</b><br>
                    <label>Printed by : {{$userName->name}}</label>
            </center>



            <?php  }
            ?>

        </div>
        <div class="modal-body">
        <center>
            <table class="table" style="border-collapse: collapse;" border="1" id="stock_products_report_table">
                <thead style="background-color:cadetblue">
                <tr>

                    <th>Product Name</th>
                    <th>Quantity On Hand</th>

                </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
                $grandTotal = 0;
                ?>

                @foreach($results as $result )
                    <?php
                    $pName = \App\Product::find($result->product_id);
                    $categoryName = \App\Category::find($pName->category_id);
                    $subCategoryName = \App\SubCategory::find($pName->sub_category_id);
                    $grandTotal = $grandTotal + $result->product_quantity;
                    ?>

                    <tr class="odd gradeX">
                        <td>{{$pName->name}} ({{$categoryName->name}}) ({{$subCategoryName->name}})</td>
                        <td style="text-align: right;">{{$result->product_quantity}}</td>


                    </tr>

                @endforeach
                <tr>
                    <td><b>Total</b></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right;"><b>{{$grandTotal}}</b></td>
                </tr>

                </tbody>
            </table>

            {{--  <div class="modal-footer">
                  <button type="button" data-dismiss="modal" class="btn">Close</button>
                  <button type="button" class="btn blue"  onClick="window.print()">Print</button>
              </div>--}}
        </center>
        </div>
    </div>
</div>
