<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\PurchaseOrderImports;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class PurchaseController extends Controller
{
    public function index()
    {
        return view('dashboard.admin.purchases.list_purchases');
    }

    public function getList()
    {
        $purchaseOrders = PurchaseOrder::orderBy('id', 'DESC')->get();
        return DataTables::of($purchaseOrders)->addIndexColumn()
            ->addColumn('user', function ($row) {
                return User::find($row->user_id)->full_name;
            })->rawColumns(['user'])
            ->addColumn('role', function ($row) {
                return json_decode(User::find($row->user_id)->getRoleNames());
            })->rawColumns(['role'])
            ->addColumn('payment', function ($row) {
                if ($row->payment == 1) {
                    return '<span class="badge badge-primary">Tiền Mặt</span>';
                } else {
                    if ($row->payment == 2) {
                        return '<span class="badge badge-success">Chuyển Khoản</span>';
                    } else {
                        if ($row->payment == 3) {
                            return '<span class="badge badge-danger">Thẻ</span>';
                        }
                    }
                }
            })
            ->addColumn('date', function ($row) {
                return date('d-m-Y', strtotime($row->created_at));
            })->rawColumns(['date'])
            ->addColumn('actions', function ($row) {
                return '<div class="btn-group">
                        <button class="btn_detail btn btn-info" value="' . $row->id . '"><i class="fas fa-eye"></i></button>
                        <a href="' . route('admin.purchases.editOrder', $row->id) . '">
                        <button class="role_btn btn btn-warning" value="' . $row->id . '"><i class="fas fa-pencil-alt"></i></button></a>
                        <button class="delete_btn btn btn-danger" value="' . $row->id . '"><i class="fas fa-trash-alt"></i></button>
                    </div>';
            })->rawColumns(['payment', 'actions'])->make(true);
    }

    public function createOrder()
    {
        $suppliers = Supplier::all();
        return view('dashboard.admin.purchases.create_order')->with(compact('suppliers'));
    }

    public function EditOrder($purchaseOrderId)
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        $purchaseOrder = PurchaseOrder::with('purchase_order_details', 'users')->find($purchaseOrderId);
        $count = count($purchaseOrder->purchase_order_details);
        return view('dashboard.admin.purchases.edit_order')->with(compact('purchaseOrder', 'suppliers',
            'count', 'products'));
    }

    public function updateOrder($purchaseOrderId, Request $request)
    {
        //Update new PurchaseOrder
        $purchaseOrder = PurchaseOrder::with('purchase_order_details', 'users')->find($purchaseOrderId);
        $purchaseOrder->user_id = Auth::user()->id;
        $purchaseOrder->total = $request->total;
        $purchaseOrder->content = $request->description;
        $purchaseOrder->payment = $request->payment;
        $purchaseOrder->save();

        //Delete all Purchaser order detail old
        PurchaseOrderDetail::where('purchase_order_id', $purchaseOrderId)->delete();

        //Update new Purchase Purchaser order detail
        parse_str($_POST['form_data'], $data);//parse string of $_POST['form_data'] to $data
        for ($count = 0; $count < count($data['item_product']); $count++) {
            $dataDetail = array(
                'purchase_order_id' => $purchaseOrder->id,
                'supplier_id' => $data['item_supplier'][$count],
                'product_id' => $data['item_product'][$count],
                'price_in' => $data['item_priceIn'][$count],
                'buying_quantity' => $data['item_quantity'][$count],
                'sub_total' => $data['item_subTotal'][$count],
            );
            if (($data['item_mfg'][$count] != '') && ($data['item_exp'][$count]) != '') {
                $dataDetail['mfg'] = date('Y-m-d', strtotime($data['item_mfg'][$count]));
                $dataDetail['exp'] = date('Y-m-d', strtotime($data['item_exp'][$count]));
            }
            $purchaseOrderDetail = PurchaseOrderDetail::create($dataDetail);
        }
        return 'Success';
    }

    public function selectProduct(Request $request)
    {
        $output = '';
        $supplier = Supplier::where('id', $request->supplier_id)->first();
        $products = Product::where('supplier_id', $supplier->id)->get();
        foreach ($products as $p) {
            $output .= '<option value="' . $p->id . '">' . $p->name . '</option>';
        }
        echo $output;
    }

    public function selectPrice(Request $request)
    {
        $product = Product::where('id', $request->product_id)->first();
        $output = $product->price_in;
        echo $output;
    }

    public function store(Request $request)
    {
        $dataPurchaseOrder['code'] = 'NH-'.Carbon::now('Asia/Ho_Chi_Minh')->rawFormat('dmy-hi');
        $dataPurchaseOrder['user_id'] = Auth::user()->id;
        $dataPurchaseOrder['total'] = $request->total;
        $dataPurchaseOrder['content'] = $request->description;
        $dataPurchaseOrder['payment'] = $request->payment;
        $purchaseOrder = PurchaseOrder::create($dataPurchaseOrder);

        parse_str($_POST['form_data'], $data);//parse string of $_POST['form_data'] to $data
        for ($count = 0; $count < count($data['item_product']); $count++) {
            $dataDetail = array(
                'purchase_order_id' => $purchaseOrder->id,
                'supplier_id' => $data['item_supplier'][$count],
                'product_id' => $data['item_product'][$count],
                'price_in' => $data['item_priceIn'][$count],
                'buying_quantity' => $data['item_quantity'][$count],
                'sub_total' => $data['item_subTotal'][$count],
            );
            if (($data['item_mfg'][$count] != '') && ($data['item_exp'][$count]) != '') {
                $dataDetail['mfg'] = date('Y-m-d', strtotime($data['item_mfg'][$count]));
                $dataDetail['exp'] = date('Y-m-d', strtotime($data['item_exp'][$count]));
            }
            $purchaseOrderDetail = PurchaseOrderDetail::create($dataDetail);
        }
        return 'Success';
    }

    public function detail(Request $request)
    {
        $purchaseOrder = PurchaseOrder::with('users', 'purchase_order_details')->find($request->purchaseOrderId);
        if ($purchaseOrder->payment == 1) {
            $purchaseOrderPayment = "Tiền Mặt";
        } else {
            if ($purchaseOrder->payment == 2) {
                $purchaseOrderPayment = "Chuyển Khoản";
            } else {
                $purchaseOrderPayment = "Thẻ";
            }
        }

        $output = '<div class="col-md-6">
            <p><strong>Mã Hóa Đơn: </strong>' . $purchaseOrder->code . '</p>
            <p><strong>Người Nhập: </strong>' . $purchaseOrder->users->full_name . '</p>
            <p><strong>Vai Trò: </strong>' . ($purchaseOrder->users->getRoleNames())[0] . '</p></div>
            <div class="col-md-6">
            <p><strong>Thời Gian: </strong>' . $purchaseOrder->updated_at->format('d/m/y') . '</p>
            <p><strong>Nội Dung: </strong>' . $purchaseOrder->content . '</p>
            <p><strong>Thanh Toán: </strong>' . $purchaseOrderPayment . '</p></div>';
        $output .= '<table class="table table-bordered table-striped"><thead><tr><th>STT</th><th>Nhà Cung Cấp</th>
            <th>Sản Phẩm</th><th>Giá Nhập</th><th>Số Lượng</th><th>Sản Xuất</th><th>Hạn</th><th>Thành Tiền</th></tr></thead><tbody>';
        $count = 1;
        foreach ($purchaseOrder->purchase_order_details as $row) {
            $output .= '<tr><td>' . $count . '</td>';
            $output .= '<td>' . $row->suppliers->name . '</td>';
            $output .= '<td>' . $row->products->name . '</td>';
            $output .= '<td>' . $row->products->price_in . '</td>';
            $output .= '<td>' . $row->buying_quantity . '</td>';
            $output .= '<td>' . (($row->mfg != '') ? date('d-m-Y', strtotime($row->mfg)) : '') . '</td>';
            $output .= '<td>' . ((($row->exp != '') ? date('d-m-Y', strtotime($row->exp)) : '')) . '</td>';
            $output .= '<td>' . $row->sub_total . '</td></tr>';
            $count++;
        }
        $output .=
            '<tr><td><strong>Tổng Tiền</strong></td><td colspan="6"></td><td>' . $purchaseOrder->total . '</td></tr>';

        return $output;
    }

    public function convertToPDF($purchaseOrderId)
    {
        $purchaseOrder = PurchaseOrder::with('users', 'purchase_order_details')->find($purchaseOrderId);
        if ($purchaseOrder->payment == 1) {
            $purchaseOrderPayment = "Tiền Mặt";
        } else {
            if ($purchaseOrder->payment == 2) {
                $purchaseOrderPayment = "Chuyển Khoản";
            } else {
                $purchaseOrderPayment = "Thẻ";
            }
        }

        $output =
            '<style>
                body{ font-family: "DejaVu Sans;",sans-serif;}
                table {width: 100%; border-collapse: collapse;}
                table, td, th {border-spacing: 0;}
                h3{ text-align: center;}
                .table_1{border-style: hidden; margin-left: 50px;}
                .table_2{border: 1px solid black; margin-top: 20px;}
                td.table_2, th.table_2, tr.table_2{border: 1px solid black;text-align: center;}
             </style>
            <h3>Hóa Đơn Nhập Hàng</h3>
            <table class="table_1">
                <tr>
                    <td><strong>Mã Hóa Đơn: </strong>' . $purchaseOrder->code . '</td>
                    <td><strong>Thời Gian: </strong>' . $purchaseOrder->updated_at->format('d/m/y') . '</td>
                </tr>
                <tr >
                    <td><strong>Người Nhập: </strong>' . $purchaseOrder->users->full_name . '</td>
                    <td><strong>Thanh Toán: </strong>' . $purchaseOrderPayment . '</td>
                </tr>
                <tr>
                    <td><strong>Vai Trò: </strong>' . ($purchaseOrder->users->getRoleNames())[0] . '</td>
                </tr>
            </table>
            <p style="margin-left: 50px"><strong>Nội Dung: </strong>' . $purchaseOrder->content . '</p>

            <table class="table_2"><thead><tr>
                <th class="table_2">STT</th><th class="table_2">Nhà Cung Cấp</th><th class="table_2">Sản Phẩm</th>
                <th class="table_2">Giá Nhập</th><th class="table_2">Số Lượng</th>
                <th class="table_2">Sản Xuất</th><th class="table_2">Hạn</th><th class="table_2">Thành Tiền</th>
            </tr></thead><tbody>';
        $count = 1;
        foreach ($purchaseOrder->purchase_order_details as $row) {
            $output .= '<tr><td class="table_2">' . $count . '</td>';
            $output .= '<td class="table_2">' . $row->suppliers->name . '</td>';
            $output .= '<td class="table_2">' . $row->products->name . '</td>';
            $output .= '<td class="table_2">' . $row->products->price_in . '</td>';
            $output .= '<td class="table_2">' . $row->buying_quantity . '</td>';
            $output .= '<td class="table_2">' . (($row->mfg != '') ? date('d-m-Y',
                    strtotime($row->mfg)) : '') . '</td>';
            $output .= '<td class="table_2">' . (($row->exp != '') ? date('d-m-Y',
                    strtotime($row->exp)) : '') . '</td>';
            $output .= '<td class="table_2">' . $row->sub_total . '</td></tr>';
            $count++;
        }
        $output .=
            '<tr><td class="table_2"><strong>Tổng Tiền</strong></td><td class="table_2" colspan="6"></td><td  class="table_2">' . $purchaseOrder->total . '</td></tr>';

        return $output;
    }

    public function printPDF($purchaseOrderId)
    {
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convertToPDF($purchaseOrderId));
        return $pdf->stream();
    }

    public function importCSV(Request $request)
    {
        $path = $request->file('file')->getRealPath();
        Excel::import(new PurchaseOrderImports(), $path);
        return redirect()->route('admin.purchases.index')->with('succes',
            'Thêm Đơn Nhập Hàng bằng File .csv thành công');
    }

    public function delete(Request $request)
    {
        $purchaseOrder = PurchaseOrder::with('users', 'purchase_order_details')->find($request->purchaseOrderId);
        if ($purchaseOrder) {
            DB::beginTransaction();
            try {
                //Delete all Purchase order detail then delete PurchaseOrder
                PurchaseOrderDetail::where('purchase_order_id', $request->purchaseOrderId)->delete();
                $purchaseOrder->delete();
            } catch (\Throwable $e) {
                DB::rollBack();
                Log::error($e->getMessage(), [$e->getTraceAsString()]);
                return response()->json(['status' => 422, 'msg' => 'Có lỗi khi xóa']);
            }
            DB::commit();
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 404, 'msg' => 'Không tìm thấy dữ liệu']);
        }
    }
}
