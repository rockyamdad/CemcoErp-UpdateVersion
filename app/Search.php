<?php namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class Search extends Eloquent
{
    public function getResultSearchType($type,$date1,$date2,$branch)
    {
        if(($type=='')) {
            return DB::table('stock_invoices')
                ->join('stock_details', 'stock_details.invoice_id', '=', 'stock_invoices.invoice_id')
                ->join('products', 'stock_details.product_id', '=', 'products.id')
                ->join('stock_infos', 'stock_details.stock_info_id', '=', 'stock_infos.id')
                ->join('users', 'stock_invoices.user_id', '=', 'users.id')
                ->where('stock_invoices.branch_id', '=', $branch)
                ->whereBetween('stock_invoices.created_at', array(new \DateTime($date1), new \DateTime($date2)))
                ->select('products.name AS pName',
                    'products.category_id AS cid',
                    'products.sub_category_id AS sid',
                    'stock_details.quantity',
                    'stock_details.entry_type',
                    'stock_invoices.branch_id',
                    'stock_details.consignment_name',
                    'stock_details.remarks',
                    'stock_invoices.created_at',
                    'users.name AS uName',
                    'stock_infos.name AS sName'

                )
                ->get();
        }else{
            return DB::table('stock_invoices')
                ->join('stock_details', 'stock_details.invoice_id', '=', 'stock_invoices.invoice_id')
                ->join('products', 'stock_details.product_id', '=', 'products.id')
                ->join('stock_infos', 'stock_details.stock_info_id', '=', 'stock_infos.id')
                ->join('users', 'stock_invoices.user_id', '=', 'users.id')
                ->where('stock_details.entry_type', '=', $type)
                ->where('stock_invoices.branch_id', '=', $branch)
                ->groupBy('stock_details.product_id')
                ->whereBetween('stock_invoices.created_at', array(new \DateTime($date1), new \DateTime($date2)))
                ->select('products.name AS pName',
                    'products.category_id AS cid',
                    'products.sub_category_id AS sid',
                    'stock_details.entry_type',
                    'stock_invoices.branch_id',
                    'stock_details.consignment_name',
                    'stock_details.remarks',
                    'stock_invoices.created_at',
                    'users.name AS uName',
                    'stock_infos.name AS sName',
                    DB::raw('SUM(stock_details.quantity) as product_quantity')
                )
                ->get();
        }
    }
    public function getResultRequisition($party,$branch,$date1,$date2)
    {
        if(($party=='' && $branch=='')) {
            return DB::table('stock_requisitions')
                ->join('parties', 'stock_requisitions.party_id', '=', 'parties.id')
                ->join('products', 'stock_requisitions.product_id', '=', 'products.id')
                ->join('users', 'stock_requisitions.user_id', '=', 'users.id')
                ->whereBetween('stock_requisitions.created_at', array(new \DateTime($date1), new \DateTime($date2)))
                ->select('products.name AS pName',
                    'products.category_id AS cId',
                    'products.sub_category_id AS sId',
                    'parties.name AS partyName',
                    'stock_requisitions.requisition_quantity',
                    'stock_requisitions.branch_id AS branchId',
                    'stock_requisitions.issued_quantity',
                    'stock_requisitions.remarks',
                    'stock_requisitions.created_at',
                    'users.username AS uName'
                )
                ->get();
        }else{
            return DB::table('stock_requisitions')
                ->join('parties', 'stock_requisitions.party_id', '=', 'parties.id')
                ->join('products', 'stock_requisitions.product_id', '=', 'products.id')
                ->join('users', 'stock_requisitions.user_id', '=', 'users.id')
                ->where('stock_requisitions.branch_id', '=', $branch)
                ->where('party_id', '=', $party)
                ->whereBetween('stock_requisitions.created_at', array(new \DateTime($date1), new \DateTime($date2)))
                ->select('products.name AS pName',
                    'products.category_id AS cId',
                    'products.sub_category_id AS sId',
                    'parties.name AS partyName',
                    'stock_requisitions.requisition_quantity',
                    'stock_requisitions.branch_id AS branchId',
                    'stock_requisitions.issued_quantity',
                    'stock_requisitions.remarks',
                    'stock_requisitions.created_at',
                    'users.username AS uName'
                )
                ->get();
        }
    }
    public function getResultStockProducts($category,$product,$date1,$date2,$branch,$stock)
    {
        if(($category=='') && ($product==''))
        {
            return DB::table('stock_invoices')
                ->join('stock_details', 'stock_details.invoice_id', '=', 'stock_invoices.invoice_id')
                ->join('products', 'stock_details.product_id', '=', 'products.id')
                ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
                ->join('stock_infos', 'stock_details.stock_info_id', '=', 'stock_infos.id')
                ->join('users', 'stock_invoices.user_id', '=', 'users.id')
                ->where('stock_invoices.branch_id','=',$branch)
                ->where('stock_details.stock_info_id','=',$stock)
                ->whereBetween('stock_invoices.created_at',array(new \DateTime($date1),new \DateTime($date2)))
                ->select('products.name AS pName',
                    'product_categories.name AS category',
                    'stock_details.quantity',
                    'stock_details.entry_type',
                    'stock_details.consignment_name',
                    'stock_details.remarks',
                    'stock_invoices.created_at',
                    'users.name AS uName',
                    'stock_infos.name AS sName'
                )
                ->get();
        }elseif($category=='')
        {
            return DB::table('stock_invoices')
                ->join('stock_details', 'stock_details.invoice_id', '=', 'stock_invoices.invoice_id')
                ->join('products', 'stock_details.product_id', '=', 'products.id')
                ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
                ->join('stock_infos', 'stock_details.stock_info_id', '=', 'stock_infos.id')
                ->join('users', 'stock_invoices.user_id', '=', 'users.id')
                ->where('stock_invoices.branch_id','=',$branch)
                ->where('stock_details.stock_info_id','=',$stock)
                ->where('stock_details.product_id','=',$product)
                ->whereBetween('stock_invoices.created_at',array(new \DateTime($date1),new \DateTime($date2)))
                ->select('products.name AS pName',
                    'product_categories.name AS category',
                    'stock_details.quantity',
                    'stock_details.entry_type',
                    'stock_details.consignment_name',
                    'stock_details.remarks',
                    'stock_invoices.created_at',
                    'users.name AS uName',
                    'stock_infos.name AS sName'
                )
                ->get();
        }
        elseif($product=='')
        {
            return DB::table('stock_invoices')
                ->join('stock_details', 'stock_details.invoice_id', '=', 'stock_invoices.invoice_id')
                ->join('products', 'stock_details.product_id', '=', 'products.id')
                ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
                ->join('stock_infos', 'stock_details.stock_info_id', '=', 'stock_infos.id')
                ->join('users', 'stock_invoices.user_id', '=', 'users.id')
                ->where('stock_invoices.branch_id','=',$branch)
                ->where('stock_details.stock_info_id','=',$stock)
                ->where('products.category_id','=',$category)
                ->whereBetween('stock_invoices.created_at',array(new \DateTime($date1),new \DateTime($date2)))
                ->select('products.name AS pName',
                    'product_categories.name AS category',
                    'stock_details.quantity',
                    'stock_details.entry_type',
                    'stock_details.consignment_name',
                    'stock_details.remarks',
                    'stock_invoices.created_at',
                    'users.name AS uName',
                    'stock_infos.name AS sName'
                )
                ->get();
        }elseif(($category!='') && ($product!='') && ($date1 != '') && ($date2!= ''))
        {
            return DB::table('stock_invoices')
                ->join('stock_details', 'stock_details.invoice_id', '=', 'stock_invoices.invoice_id')
                ->join('products', 'stock_details.product_id', '=', 'products.id')
                ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
                ->join('stock_infos', 'stock_details.stock_info_id', '=', 'stock_infos.id')
                ->join('users', 'stock_invoices.user_id', '=', 'users.id')
                ->where('stock_invoices.branch_id','=',$branch)
                ->where('stock_details.stock_info_id','=',$stock)
                ->where('stock_details.product_id','=',$product)
                ->where('products.category_id','=',$category)
                ->whereBetween('stock_invoices.created_at',array(new \DateTime($date1),new \DateTime($date2)))
                ->select('products.name AS pName',
                    'product_categories.name AS category',
                    'stock_details.quantity',
                    'stock_details.entry_type',
                    'stock_details.consignment_name',
                    'stock_details.remarks',
                    'stock_invoices.created_at',
                    'users.name AS uName',
                    'stock_infos.name AS sName'
                )
                ->get();
        }

    }

}
