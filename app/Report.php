<?php namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class Report extends Eloquent
{
    //stock main Report
    public function getStockReport($product_type,$date1,$date2,$branch_id,$category_id)
    {
            return DB::table('stock_invoices')
                ->join('stock_details', 'stock_invoices.invoice_id', '=', 'stock_details.invoice_id')
                ->join('products', 'stock_details.product_id', '=', 'products.id')
                ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
                ->join('stock_infos', 'stock_details.stock_info_id', '=', 'stock_infos.id')
                ->where('stock_invoices.branch_id', '=', $branch_id)
                ->where('products.category_id', '=', $category_id)
                ->where('stock_details.product_type', '=', $product_type)
                ->whereBetween('stock_invoices.created_at', array(new \DateTime($date1), new \DateTime($date2)))
                ->groupBy('stock_details.product_id')
                ->select('products.name AS pName',
                    'product_categories.name AS category',
                    'products.sub_category_id AS subCategory',
                    'stock_invoices.created_at',
                    'stock_details.product_id',
                    'stock_details.product_type',
                    'stock_infos.name AS sName'

                )
                ->get();
    }


    public function getStockBf($product_type,$date1,$product_id)
    {
        return DB::table('stock_invoices')
            ->join('stock_details', 'stock_invoices.invoice_id', '=', 'stock_details.invoice_id')
            ->where('stock_invoices.created_at', '<',new \DateTime($date1))
            ->where('stock_details.product_type', '=',$product_type)
            ->where('stock_details.entry_type', '=', 'StockIn')
            ->where('stock_details.product_id', '=',$product_id)
            ->select(
                DB::raw('SUM(stock_details.quantity) as stockBf')

            )
            ->get();
    }
    public function getStockBfOut($product_type,$date1,$product_id)
    {
        return DB::table('stock_invoices')
            ->join('stock_details', 'stock_invoices.invoice_id', '=', 'stock_details.invoice_id')
            ->where('stock_invoices.created_at', '<',new \DateTime($date1))
            ->where('stock_details.product_type', '=',$product_type)
            ->where('stock_details.entry_type', '=', 'StockOut')
            ->where('stock_details.product_id', '=',$product_id)
            ->select(
                DB::raw('SUM(stock_details.quantity) as stockBfOut')

            )
            ->get();
    }
    public function getStockIn($product_type,$date1,$date2,$product_id)
    {
        return DB::table('stock_invoices')
            ->join('stock_details', 'stock_invoices.invoice_id', '=', 'stock_details.invoice_id')
            ->whereBetween('stock_invoices.created_at', array(new \DateTime($date1), new \DateTime($date2)))
            ->where('stock_details.product_type', '=',$product_type)
            ->where('stock_details.entry_type', '=', 'StockIn')
            ->where('stock_details.product_id', '=',$product_id)
            ->select(
                DB::raw('SUM(stock_details.quantity) as stockIn')

            )
            ->get();
    }
    public function getStockOut($product_type,$date1,$date2,$product_id)
    {
        return DB::table('stock_invoices')
            ->join('stock_details', 'stock_invoices.invoice_id', '=', 'stock_details.invoice_id')
            ->whereBetween('stock_invoices.created_at', array(new \DateTime($date1), new \DateTime($date2)))
            ->where('stock_details.product_type', '=',$product_type)
            ->where('stock_details.entry_type', '=', 'StockOut')
            ->where('stock_details.product_id', '=',$product_id)
            ->select(
                DB::raw('SUM(stock_details.quantity) as stockOut')

            )
            ->get();
    }
    public function getStockWastage($product_type,$date1,$date2,$product_id)
    {
        return DB::table('stock_invoices')
            ->join('stock_details', 'stock_invoices.invoice_id', '=', 'stock_details.invoice_id')
            ->whereBetween('stock_invoices.created_at', array(new \DateTime($date1), new \DateTime($date2)))
            ->where('stock_details.product_type', '=',$product_type)
            ->where('stock_details.entry_type', '=', 'Wastage')
            ->where('stock_details.product_id', '=',$product_id)
            ->select(
                DB::raw('SUM(stock_details.quantity) as stockWastage')

            )
            ->get();
    }
    //stock Products Report

    public function getStockProductsReport()
    {
        return DB::table('stock_counts')
            ->selectRaw('product_id,stock_info_id, sum(product_quantity) as product_quantity')
            ->groupBy('stock_counts.product_id')
            ->get();
    }
    public function getStockReportResult($stock,$product_type,$branch_id,$category_id)
    {
        return DB::table('stock_counts')
            ->join('products', 'stock_counts.product_id', '=', 'products.id')
            ->selectRaw('stock_counts.product_quantity,stock_counts.product_id,stock_counts.stock_info_id,products.branch_id,products.product_type,products.category_id')
            ->where('products.branch_id', '=', $branch_id)
            ->where('stock_counts.stock_info_id', '=', $stock)
            ->where('products.category_id', '=', $category_id)
            ->where('products.product_type', '=', $product_type)
            ->get();
    }
    public function getSalesReport($date1,$date2,$branch_id)
    {
        return DB::table('sale_details')
            ->join('sales', 'sale_details.invoice_id', '=', 'sales.invoice_id')
            ->where('sales.is_sale', '=', 1)
            ->where('sale_details.branch_id', '=', $branch_id)
            ->whereBetween('sale_details.created_at', array(new \DateTime($date1), new \DateTime($date2)))
            ->groupBy('sale_details.invoice_id')
            ->select('sale_details.created_at AS date',
                'sale_details.branch_id AS branch',
                'sale_details.invoice_id AS invoice',
                DB::raw('SUM(sale_details.price * sale_details.quantity) AS totalSale'),
                'sales.discount_percentage AS discount_amount'
            )
            ->get();
    }
    public function getPaymentForSalesReport($date1,$date2,$invoice_id)
    {
        return DB::table('transactions')
            ->where('transactions.invoice_id', '=', $invoice_id)
            ->where('transactions.type', '=', 'Receive')
            ->whereBetween('transactions.created_at', array(new \DateTime($date1), new \DateTime($date2)))
            ->select(
                DB::raw('SUM(transactions.amount) AS totalPayment')
            )
            ->get();
    }
    public function getSalesDetailsReport($date1,$date2,$branch_id)
    {
        return DB::table('sale_details')
            ->join('products', 'sale_details.product_id', '=', 'products.id')
            ->join('sales', 'sale_details.invoice_id', '=', 'sales.invoice_id')
            ->where('sales.is_sale', '=', 1)
            ->where('sale_details.branch_id', '=', $branch_id)
            ->whereBetween('sale_details.created_at', array(new \DateTime($date1), new \DateTime($date2)))
            ->orderBy('sale_details.invoice_id')
            ->select('sale_details.created_at AS date',
                'sale_details.branch_id AS branch',
                'sale_details.stock_info_id AS stock',
                'sale_details.invoice_id AS invoice',
                'sale_details.product_id',
                'sale_details.price',
                'sale_details.quantity',
                'sale_details.remarks',
                'products.category_id',
                'products.sub_category_id'
            )
            ->get();
    }
    public function getSalesDueReport($date1,$date2,$branch_id)
    {
        return DB::table('sale_details')
            ->join('sales','sale_details.invoice_id','=','sales.invoice_id')
            ->where('sale_details.branch_id', '=', $branch_id)
            ->where('sales.is_sale', '=',1)
            ->whereBetween('sale_details.created_at', array(new \DateTime($date1), new \DateTime($date2)))
            ->groupBy('sales.party_id')
            ->select('sale_details.created_at AS date',
                'sale_details.branch_id AS branch',
                'sale_details.invoice_id AS invoice',
                'sales.party_id AS party',
                DB::raw('SUM(sales.discount_percentage) as discount_amount'),
                DB::raw('SUM(sale_details.price * sale_details.quantity) AS totalSale')
            )
            ->get();
    }
    public function getPaymentForSalesDueReport($date1,$date2,$party_id)
    {
        return DB::table('transactions')
            ->join('sales','transactions.invoice_id','=','sales.invoice_id')
            ->where('sales.party_id', '=', $party_id)
            ->where('transactions.type', '=', 'Receive')
            ->whereBetween('transactions.created_at', array(new \DateTime($date1), new \DateTime($date2)))
            ->select(
                DB::raw('SUM(transactions.amount) AS totalPayment')
            )
            ->get();
    }
    public function getSalesCollectionReport($date1,$date2,$branch_id)
    {
        return DB::table('transactions')
            ->join('sale_details', 'transactions.invoice_id', '=', 'sale_details.invoice_id')
            ->join('sales', 'transactions.invoice_id', '=', 'sales.invoice_id')
            ->where('sale_details.branch_id', '=', $branch_id)
            ->where('transactions.type', '=', 'Receive')
            ->whereBetween('transactions.created_at', array(new \DateTime($date1), new \DateTime($date2)))
            ->select('transactions.created_at AS date',
                'sale_details.branch_id AS branch',
                'sales.party_id AS party',
                'transactions.amount',
                'transactions.invoice_id AS invoice',
                'transactions.payment_method',
                'transactions.account_name_id',
                'transactions.account_category_id',
                'transactions.cheque_no',
                'transactions.remarks'
            )
            ->get();
    }
//PURCHASE QUERY SECTION
    public function getPurchaseReport($date1,$date2,$branch_id)
    {
        return DB::table('purchase_invoice_details')
            ->where('purchase_invoice_details.branch_id', '=', $branch_id)
            ->whereBetween('purchase_invoice_details.created_at', array(new \DateTime($date1), new \DateTime($date2)))
            ->groupBy('purchase_invoice_details.detail_invoice_id')
            ->select('purchase_invoice_details.created_at AS date',
                'purchase_invoice_details.branch_id AS branch',
                'purchase_invoice_details.detail_invoice_id AS invoice',
                DB::raw('SUM(purchase_invoice_details.price * purchase_invoice_details.quantity) AS totalSale')
            )
            ->get();
    }
    public function getPaymentForPurchaseReport($date1,$date2,$invoice_id)
    {
        return DB::table('transactions')
            ->where('transactions.invoice_id', '=', $invoice_id)
            ->where('transactions.type', '=', 'Payment')
            ->whereBetween('transactions.created_at', array(new \DateTime($date1), new \DateTime($date2)))
            ->select(
                DB::raw('SUM(transactions.amount) AS totalPayment')
            )
            ->get();
    }
    public function getPurchaseDetailsReport($date1,$date2,$branch_id)
    {
        return DB::table('purchase_invoice_details')
            ->join('products', 'purchase_invoice_details.product_id', '=', 'products.id')
            ->where('purchase_invoice_details.branch_id', '=', $branch_id)
            ->whereBetween('purchase_invoice_details.created_at', array(new \DateTime($date1), new \DateTime($date2)))
            ->orderBy('purchase_invoice_details.detail_invoice_id')
            ->select('purchase_invoice_details.created_at AS date',
                'purchase_invoice_details.branch_id AS branch',
                'purchase_invoice_details.stock_info_id AS stock',
                'purchase_invoice_details.detail_invoice_id AS invoice',
                'purchase_invoice_details.product_id',
                'purchase_invoice_details.price',
                'purchase_invoice_details.quantity',
                'purchase_invoice_details.remarks',
                'products.category_id',
                'products.sub_category_id'
            )
            ->get();
    }
    public function getPurchaseDueReport($date1,$date2,$branch_id)
    {
        return DB::table('purchase_invoice_details')
            ->join('purchase_invoices','purchase_invoice_details.detail_invoice_id','=','purchase_invoices.invoice_id')
            ->where('purchase_invoice_details.branch_id', '=', $branch_id)
            ->whereBetween('purchase_invoice_details.created_at', array(new \DateTime($date1), new \DateTime($date2)))
            ->groupBy('purchase_invoices.party_id')
            ->select('purchase_invoice_details.created_at AS date',
                'purchase_invoice_details.branch_id AS branch',
                'purchase_invoice_details.detail_invoice_id AS invoice',
                'purchase_invoices.party_id AS party',
                DB::raw('SUM(purchase_invoice_details.price * purchase_invoice_details.quantity) AS totalSale')
            )
            ->get();
    }
    public function getPaymentForPurchaseDueReport($date1,$date2,$party_id)
    {
        return DB::table('transactions')
            ->join('purchase_invoices','transactions.invoice_id','=','purchase_invoices.invoice_id')
            ->where('purchase_invoices.party_id', '=', $party_id)
            ->where('transactions.type', '=', 'Payment')
            ->whereBetween('transactions.created_at', array(new \DateTime($date1), new \DateTime($date2)))
            ->select(
                DB::raw('SUM(transactions.amount) AS totalPayment')
            )
            ->get();
    }
    public function getPurchaseCollectionReport($date1,$date2,$branch_id)
    {
        return DB::table('transactions')
            ->join('purchase_invoice_details', 'transactions.invoice_id', '=', 'purchase_invoice_details.detail_invoice_id')
            ->join('purchase_invoices', 'transactions.invoice_id', '=', 'purchase_invoices.invoice_id')
            ->where('purchase_invoice_details.branch_id', '=', $branch_id)
            ->where('transactions.type', '=', 'Payment')
            ->whereBetween('transactions.created_at', array(new \DateTime($date1), new \DateTime($date2)))
            ->select('transactions.created_at AS date',
                'purchase_invoice_details.branch_id AS branch',
                'purchase_invoices.party_id AS party',
                'transactions.amount',
                'transactions.invoice_id AS invoice',
                'transactions.payment_method',
                'transactions.account_name_id',
                'transactions.account_category_id',
                'transactions.cheque_no',
                'transactions.remarks'
            )
            ->get();
    }
    public function getExpenseReport($date1,$date2,$branch_id)
    {
        return DB::table('expenses')
            ->where('expenses.branch_id', '=', $branch_id)
            ->whereBetween('expenses.created_at', array(new \DateTime($date1), new \DateTime($date2)))
            ->select('expenses.created_at AS date',
                'expenses.branch_id AS branch',
                'expenses.invoice_id AS invoice',
                'expenses.category',
                'expenses.particular',
                'expenses.purpose',
                'expenses.amount',
                'expenses.remarks',
                'expenses.user_id'
            )
            ->get();
    }
    public function getExpensePaymentReport($date1,$date2,$branch_id)
    {
        return DB::table('transactions')
            ->join('expenses', 'transactions.invoice_id', '=', 'expenses.invoice_id')
            ->where('expenses.branch_id', '=', $branch_id)
            ->where('transactions.type', '=', 'Expense')
            ->whereBetween('transactions.created_at', array(new \DateTime($date1), new \DateTime($date2)))
            ->select('transactions.created_at AS date',
                'expenses.branch_id AS branch',
                'transactions.amount',
                'transactions.invoice_id AS invoice',
                'transactions.payment_method',
                'transactions.account_name_id',
                'transactions.account_category_id',
                'transactions.cheque_no',
                'transactions.remarks'
            )
            ->get();
    }
    public function getBalanceTransferReport($account_id1,$account_id2)
    {
        return DB::table('balance_transfers')
            ->where('balance_transfers.from_account_name_id', '=', $account_id1)
            ->where('balance_transfers.to_account_name_id', '=',$account_id2)
            ->select('balance_transfers.created_at AS date',
                'balance_transfers.from_branch_id AS fromBranch',
                'balance_transfers.to_branch_id AS toBranch',
                'balance_transfers.from_account_name_id AS fromAccount',
                'balance_transfers.to_account_name_id AS toAccount',
                'balance_transfers.amount',
                'balance_transfers.remarks',
                'balance_transfers.user_id'
            )
            ->get();
    }
    public function getBalanceTransferReport2($account_id1,$account_id2)
    {
        return DB::table('balance_transfers')
            ->where('balance_transfers.from_account_name_id', '=', $account_id2)
            ->where('balance_transfers.to_account_name_id', '=',$account_id1)
            ->select('balance_transfers.created_at AS date',
                'balance_transfers.from_branch_id AS fromBranch',
                'balance_transfers.to_branch_id AS toBranch',
                'balance_transfers.from_account_name_id AS fromAccount',
                'balance_transfers.to_account_name_id AS toAccount',
                'balance_transfers.amount',
                'balance_transfers.remarks',
                'balance_transfers.user_id'
            )
            ->get();
    }
    public function getAccountsReportData($date1,$date2,$account_id)
    {
        return DB::table('transactions')
            ->where('transactions.account_name_id', '=', $account_id)
            ->whereBetween('transactions.created_at', array(new \DateTime($date1), new \DateTime($date2)))
            ->select('transactions.created_at AS date',
                'transactions.type',
                'transactions.amount',
                'transactions.payment_method',
                'transactions.account_name_id',
                'transactions.cheque_no',
                'transactions.remarks'
            )
            ->get();
    }
    public function getBalanceOut($date1,$date2,$account_id)
    {
        return DB::table('transactions')
            ->where('created_at', '<',new \DateTime($date1))
            ->where('type', '!=','Receive')
            ->where('account_name_id', '=',$account_id)
            ->select(
                DB::raw('SUM(amount) as balanceOut')

            )
            ->get();
    }
    public function getBalanceIn($date1,$date2,$account_id)
    {
        return DB::table('transactions')
            ->where('created_at', '<',new \DateTime($date1))
            ->where('type', '=','Receive')
            ->where('account_name_id', '=',$account_id)
            ->select(
                DB::raw('SUM(amount) as balanceIn')

            )
            ->get();
    }
    public function getTotalBalanceOut($account_id)
    {
        return DB::table('transactions')
            ->where('type', '!=','Receive')
            ->where('account_name_id', '=',$account_id)
            ->select(
                DB::raw('SUM(amount) as totalBalanceOut')

            )
            ->get();
    }
    public function getTotalBalanceIn($account_id)
    {
        return DB::table('transactions')
            ->where('type', '=','Receive')
            ->where('account_name_id', '=',$account_id)
            ->select(
                DB::raw('SUM(amount) as totalBalanceIn')

            )
            ->get();
    }
    public function getBalanceTransferFullReport()
    {
        return DB::table('balance_transfers')
            ->groupBy('balance_transfers.from_account_name_id')
            ->select(
                'balance_transfers.from_account_name_id AS fromAccount'
            )
            ->get();
    }
    public function getBalanceTransferForFromAccount($account_id)
    {
        return DB::table('balance_transfers')
            ->where('from_account_name_id', '=',$account_id)
            ->groupBy('balance_transfers.to_account_name_id')
            ->select(
                'balance_transfers.from_account_name_id AS fAccount',
                'balance_transfers.to_account_name_id AS toAccount',
                DB::raw('SUM(balance_transfers.amount) as fromAmount')
            )
            ->get();
    }
    public function getBalanceTransferForToAccount($from_account_id,$to_account_id)
    {
        return DB::table('balance_transfers')
            ->where('from_account_name_id', '=',$to_account_id)
            ->where('to_account_name_id', '=',$from_account_id)
            ->select(
                DB::raw('SUM(balance_transfers.amount) as toAmount')
            )
            ->get();
    }
    public function getTotalProducts()
    {
        $totalQuantity = DB::table('products')->count();
        return $totalQuantity;
    }
    public function getTotalImports()
    {
        return DB::table('imports')
            ->select(
                DB::raw('COUNT(imports.import_num) as totalImport')
            )
            ->get();
    }
    public function getTotalSalesToday()
    {
        return DB::table('transactions')
            ->where('transactions.type', '=', 'Receive')
            ->whereBetween('transactions.created_at', array(date('Y-m-d'.' 00:00:00'), date('Y-m-d H:i:s')))
            ->select(
                DB::raw('SUM(transactions.amount) as todaySale')
            )
            ->get();
    }
    public function getTotalPurchaseToday()
    {
        return DB::table('transactions')
            ->where('transactions.type', '=', 'Payment')
            ->whereBetween('transactions.created_at', array(date('Y-m-d'.' 00:00:00'), date('Y-m-d H:i:s')))
            ->select(
                DB::raw('SUM(transactions.amount) as todayPurchase')
            )
            ->get();
    }
    public function getAccountBalances()
    {
        return DB::table('name_of_accounts')
            ->select(
                'name_of_accounts.branch_id',
                'name_of_accounts.name',
                'name_of_accounts.opening_balance'
            )
            ->get();
    }
    public function getStocksBranch()
    {
        return DB::table('stocks')
            ->groupBy('stocks.branch_id')
            ->select(
                'stocks.branch_id AS branch'
            )
            ->get();
    }
    public function getStockInTotal($branch)
    {
        return DB::table('stocks')
            ->where('stocks.entry_type', '=', 'StockIn')
            ->where('stocks.branch_id', '=',$branch)
            ->whereBetween('stocks.created_at', array(date('Y-m-d'.' 00:00:00'), date('Y-m-d H:i:s')))
            ->select(
                DB::raw('COUNT(stocks.entry_type) as totalStockIn')
            )
            ->get();
    }
    public function getStockOutTotal($branch)
    {
        return DB::table('stocks')
            ->where('stocks.entry_type', '=', 'StockOut')
            ->where('stocks.branch_id', '=',$branch)
            ->whereBetween('stocks.created_at', array(date('Y-m-d'.' 00:00:00'), date('Y-m-d H:i:s')))
            ->select(
                DB::raw('COUNT(stocks.entry_type) as totalStockOut')
            )
            ->get();
    }
    public function getStockTransferTotal($branch)
    {
        return DB::table('stocks')
            ->where('stocks.entry_type', '=', 'Transfer')
            ->where('stocks.branch_id', '=',$branch)
            ->whereBetween('stocks.created_at', array(date('Y-m-d'.' 00:00:00'), date('Y-m-d H:i:s')))
            ->select(
                DB::raw('COUNT(stocks.entry_type) as totalStockTransfer')
            )
            ->get();
    }
    public function getSalesReturnReport($date1,$date2,$branch_id)
    {
        return DB::table('sales_return_invoices')
            ->join('sales_return_details', 'sales_return_details.invoice_id', '=', 'sales_return_invoices.invoice_id')
            ->where('sales_return_invoices.branch_id', '=', $branch_id)
            ->whereBetween('sales_return_invoices.created_at', array(new \DateTime($date1), new \DateTime($date2)))
            ->select('sales_return_invoices.created_at AS date',
                'sales_return_invoices.branch_id AS branch',
                'sales_return_details.quantity',
                'sales_return_details.unit_price',
                'sales_return_invoices.party_id',
                'sales_return_invoices.invoice_id',
                'sales_return_invoices.product_status',
                'sales_return_invoices.ref_no',
                'sales_return_invoices.discount_percentage'
            )
            ->get();
    }
    public function getSalesReturnDetailsReport($date1,$date2,$branch_id)
    {
        return DB::table('sales_return_details')
            ->join('sales_return_invoices', 'sales_return_invoices.invoice_id', '=', 'sales_return_details.invoice_id')
            ->where('sales_return_invoices.branch_id', '=', $branch_id)
            ->whereBetween('sales_return_details.created_at', array(new \DateTime($date1), new \DateTime($date2)))
            ->select('sales_return_details.created_at AS date',
                'sales_return_invoices.branch_id AS branch',
                'sales_return_details.quantity',
                'sales_return_details.unit_price',
                'sales_return_details.invoice_id',
                'sales_return_details.return_amount',
                'sales_return_details.product_id',
                'sales_return_invoices.discount_percentage'
            )
            ->get();
    }
    public function getSalesPartyLedgerReport($date1,$date2,$party_id)
    {
        return DB::table('sale_details')
            ->join('sales', 'sale_details.invoice_id', '=', 'sales.invoice_id')
            ->where('sales.is_sale', '=', 1)
            ->where('sales.party_id', '=', $party_id)
            ->whereBetween('sale_details.created_at', array(new \DateTime($date1), new \DateTime($date2)))
            ->groupBy('sale_details.invoice_id')
            ->select('sale_details.created_at AS date',
                'sale_details.branch_id AS branch',
                'sale_details.invoice_id AS invoice',
                DB::raw('SUM(sale_details.price * sale_details.quantity) AS total')
            )
            ->get();
    }
    public function getPaymentForSalesPartyLedgerReport($date1,$date2,$invoice_id)
    {
        return DB::table('transactions')
            ->where('transactions.invoice_id', '=', $invoice_id)
            ->where('transactions.type', '=', 'Receive')
            ->whereBetween('transactions.created_at', array(new \DateTime($date1), new \DateTime($date2)))
            ->select(
                'transactions.created_at AS date',
                'transactions.payment_method',
                'transactions.cheque_no',
                'transactions.amount AS total'
                //DB::raw('SUM(transactions.amount) AS total')
            )
            ->get();
    }
    public function getCredit($date1,$date2,$party_id)
    {
        return DB::table('sale_details')
            ->join('sales', 'sale_details.invoice_id', '=', 'sales.invoice_id')
            ->where('sales.is_sale', '=', 1)
            ->where('sales.party_id', '=', $party_id)
            ->where('sale_details.created_at', '<',new \DateTime($date1))
            ->select(
                DB::raw('SUM(sale_details.price * sale_details.quantity) AS totalCredit')

            )
            ->get();
    }
    public function getDebit($date1,$date2,$party_id)
    {
        return DB::table('transactions')
            ->join('sales','transactions.invoice_id','=','sales.invoice_id')
            ->where('sales.party_id', '=', $party_id)
            ->where('transactions.type', '=', 'Receive')
            ->where('transactions.created_at', '<',new \DateTime($date1))
            ->select(
                DB::raw('SUM(transactions.amount) as totalDebit')

            )
            ->get();
    }
    public function getPurchasePartyLedgerReport($date1,$date2,$party_id)
    {
        return DB::table('purchase_invoice_details')
            ->join('purchase_invoices', 'purchase_invoice_details.detail_invoice_id', '=', 'purchase_invoices.invoice_id')
            ->where('purchase_invoices.party_id', '=', $party_id)
            ->whereBetween('purchase_invoice_details.created_at', array(new \DateTime($date1), new \DateTime($date2)))
            ->groupBy('purchase_invoice_details.invoice_id')
            ->select('purchase_invoice_details.created_at AS date',
                'purchase_invoice_details.branch_id AS branch',
                'purchase_invoice_details.invoice_id AS invoice',
                DB::raw('SUM(purchase_invoice_details.price * purchase_invoice_details.quantity) AS total')
            )
            ->get();
    }
    public function getPaymentForPurchasePartyLedgerReport($date1,$date2,$invoice_id)
    {
        return DB::table('transactions')
            ->where('transactions.invoice_id', '=', $invoice_id)
            ->where('transactions.type', '=', 'Payment')
            ->whereBetween('transactions.created_at', array(new \DateTime($date1), new \DateTime($date2)))
            ->select(
                'transactions.created_at AS date',
                'transactions.payment_method',
                'transactions.cheque_no',
                'transactions.amount AS total'
            //DB::raw('SUM(transactions.amount) AS total')
            )
            ->get();
    }
    public function getCreditForPurchase($date1,$date2,$party_id)
    {
        return DB::table('purchase_invoice_details')
            ->join('purchase_invoices', 'purchase_invoice_details.detail_invoice_id', '=', 'purchase_invoices.invoice_id')
            ->where('purchase_invoices.party_id', '=', $party_id)
            ->where('purchase_invoice_details.created_at', '<',new \DateTime($date1))
            ->select(
                DB::raw('SUM(purchase_invoice_details.price * purchase_invoice_details.quantity) AS totalCredit')

            )
            ->get();
    }
    public function getDebitForPurchase($date1,$date2,$party_id)
    {
        return DB::table('transactions')
            ->join('purchase_invoices','transactions.invoice_id','=','purchase_invoices.invoice_id')
            ->where('purchase_invoices.party_id', '=', $party_id)
            ->where('transactions.type', '=', 'Payment')
            ->where('transactions.created_at', '<',new \DateTime($date1))
            ->select(
                DB::raw('SUM(transactions.amount) as totalDebit')

            )
            ->get();
    }
}
