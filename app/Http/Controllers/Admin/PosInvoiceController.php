<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Tax;
use App\Models\PosInvoice;
use App\Models\PosInvoiceDetail;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PosInvoiceController extends Controller
{
    public function index()
    {
        return view('dashboard.admin.pos_invoices.index');
    }

    public function getList()
    {
        $posInvoices = PosInvoice::with('user', 'tax', 'customer')->orderBy('id', 'DESC')->get();
        return DataTables::of($posInvoices)->addIndexColumn()
            ->addColumn('customer_name', function ($row) {
                if ($row->customer_id == 0) {
                    return '<span class="badge badge-primary">Khách Thường</span>';
                } else {
                    return '<span class="badge badge-success">' . $row->customer->name . '</span>';
                }
            })
            ->addColumn('total_price_product', function ($row) {
                return number_format($row->total_price_product, 0, ',') . ' VNĐ';
            })
            ->addColumn('tax_id', function ($row) {
                return $row->tax->name;
            })
            ->addColumn('tax_fee', function ($row) {
                return number_format($row->tax_fee, 0, ',') . ' VNĐ';
            })
            ->addColumn('discount_invoice', function ($row) {
                return number_format($row->discount_invoice, 0, ',') . ' VNĐ';
            })
            ->addColumn('total_last', function ($row) {
                return number_format($row->total_last, 0, ',') . ' VNĐ';
            })
            ->addColumn('payment', function ($row) {
                if ($row->payment == 1) {
                    return '<span class="badge badge-info">Tiền Mặt</span>';
                } else {
                    if ($row->payment == 2) {
                        return '<span class="badge badge-danger">Chuyển Khoản</span>';
                    } else {
                        if ($row->payment == 3) {
                            return '<span class="badge badge-secondary">Thẻ</span>';
                        }
                    }
                }
            })
            ->addColumn('user_id', function ($row) {
                return $row->user->full_name;
            })
            ->addColumn('user_role', function ($row) {
                return json_decode($row->user->getRoleNames());
            })
            ->addColumn('date', function ($row) {
                return date('d-m-Y| h:i:s A', strtotime($row->created_at));
            })
            ->addColumn('actions', function ($row) {
                return ' <button class="btn_detail btn btn-warning" value="' . $row->id . '"><i class="fas fa-eye"></i></button>';
            })->rawColumns(['customer_name', 'payment', 'actions'])->make(true);
    }

    public function detail(Request $request)
    {
        $posInvoice = posInvoice::with('user', 'customer', 'tax', 'pos_invoice_details')
            ->find($request->posInvoiceId);
        $output = '<div class="col-md-6">
             <p><strong>Mã Đơn POS: </strong>' . $posInvoice->code . '</p>
             <p><strong>Người Tạo: </strong>' . $posInvoice->user->full_name . '</p>
             <p><strong>Vai Trò: </strong>' . ($posInvoice->user->getRoleNames())[0] . '</p></div>
             <div class="col-md-6">
             <p><strong>Khách Hàng: </strong>' . (($posInvoice->customer_id == 0) ? 'Khách Thường' : $posInvoice->customer->name) . '</p>
             <p><strong>Thanh Toán: </strong>' . $posInvoice->getPayment() . '</p>
             <p><strong>Thời Gian: </strong>' . $posInvoice->updated_at->format('d/m/y | h-i-s A') . '</p></div>
             <p><strong style="margin-left: 7px;">Ghi Chú: </strong>' . $posInvoice->note . '</p>';

        $output .= '<table class="table table-bordered table-striped"><thead><tr><th>STT</th><th>Sản Phẩm</th>
           <th>Giá</th><th>Số Lượng</th><th>Giảm Giá</th><th>Thành Tiền</th></tr></thead><tbody>';
        $count = 1;
        foreach ($posInvoice->pos_invoice_details as $row) {
            $output .= '<tr><td>' . $count . '</td>';
            $output .= '<td>' . $row->products->name . '</td>';
            $output .= '<td>' . number_format($row->price, 0, ',') . ' VNĐ' . '</td>';
            $output .= '<td>' . $row->buying_quantity . '</td>';
            $output .= '<td>' . number_format($row->discount, 0, ',') . '</td>';
            $output .= '<td>' . number_format($row->sub_total, 0, ',') . ' VNĐ' . '</td></tr>';
            $count++;
        }
        $output .=
            '<tr><td colspan="4"></td><td><strong>Tiền Hàng<td>'
            . number_format($posInvoice->total_price_product, 0, ',') . ' VNĐ' . '</td></tr>
            <tr><td colspan="4"></td><td><strong>Thuế</strong> (' . $posInvoice->tax->name . ')</td><td>'
            . number_format($posInvoice->tax_fee, 0, ',') . ' VNĐ' . '</td></tr>
            <tr><td colspan="4"></td><td><strong>Chiết Khấu Hóa Đơn<td>'
            . number_format($posInvoice->discount_invoice, 0, ',') . ' VNĐ' . '</td></tr>
            <tr><td colspan="4"></td><td><strong>Tổng Tiền</strong></td><td>'
            . number_format($posInvoice->total_last, 0, ',') . ' VNĐ' . '</td></tr>';

        return $output;
    }

    public function convertToPDF($posInvoiceId)
    {
        $posInvoice = PosInvoice::with('user', 'customer', 'tax', 'pos_invoice_details')
            ->find($posInvoiceId);;
        $output =
            '<style>
                body{ font-family: "DejaVu Sans;",sans-serif;}
                table {border-collapse: collapse;}
                table, td, th{ border: 1px solid black;border-spacing: 0;}
                h3, td, th{}
             </style>
            <h3 style="text-align: center;">Hóa Đơn Bán POS</h3>
            <p>
                <strong>Mã Hóa Đơn: </strong>' . $posInvoice->code . '
                <strong style="margin-left: 100px">Khách Hàng: </strong>' . (($posInvoice->customer_id == 0) ? 'Khách Thường' : $posInvoice->customer->name) . '
            </p>
             <p>
               <strong>Vị Trí: </strong>' . ($posInvoice->user->getRoleNames())[0]. '
               <strong  style="margin-left: 240px">Thời Gian: </strong>' . $posInvoice->created_at->format('d/m/y | h-i-s A') . '
            </p>
            <p> <strong">Thanh Toán: </strong>' . $posInvoice->getPayment() . '</p>
            <p><strong>Ghi Chú: </strong>' . $posInvoice->note . '</p>
             <p><strong>Người Tạo: </strong>' . $posInvoice->user->full_name. '</p>
            <table style="width: 100%; text-align: center;" id="table_1"><thead><tr>
                <th>STT</th><th>Sản Phẩm</th><th>Giá</th><th>Số Lượng</th>
                <th>Giảm Giá</th><th>Thành Tiền</th>
            </tr></thead><tbody>';
        $count = 1;
       foreach ($posInvoice->pos_invoice_details as $row) {
            $output .= '<tr><td>' . $count . '</td>';
            $output .= '<td>' . $row->products->name . '</td>';
            $output .= '<td>' . number_format($row->price, 0, ',') . ' VNĐ' . '</td>';
            $output .= '<td>' . $row->buying_quantity . '</td>';
            $output .= '<td>' . number_format($row->discount, 0, ',') . '</td>';
            $output .= '<td>' . number_format($row->sub_total, 0, ',') . ' VNĐ' . '</td></tr>';
            $count++;
        }
        $output .= '</tbody></table>';
        $output .=
            '<p style="margin-top: 50px"><strong  style="margin-left: 300px">Tiền Hàng</strong>
            <span style="margin-left: 170px">' . number_format($posInvoice->total_product_price, 0, ',') . ' VNĐ</span></p>
            <p><strong style="margin-left: 300px">Tiền Thuế</strong>
            <span style="margin-left: 168px">' . number_format($posInvoice->tax_fee, 0, ',') . ' VNĐ' . '</span></p>
            <p><strong  style="margin-left: 300px">Chiết Khấu</strong>
            <span style="margin-left: 165px">' . number_format($posInvoice->discount_invoice, 0, ',') . ' VNĐ' . '</span></p>
            <p><strong  style="margin-left: 300px">Tổng Tiền</strong>
            <span style="margin-left: 175px">' . number_format($posInvoice->total_last, 0, ',') . ' VNĐ</span></p>';
        return $output;
    }

    public function printPDF($posInvoiceId)
    {
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convertToPDF($posInvoiceId));
        return $pdf->stream();
    }

    public function create(Request $request)
    {
        $tax = Tax::where('rate', $request->tax_rate)->first();
        $dataPosInvoice['code'] = "POS-" . Carbon::now('Asia/Ho_Chi_Minh')->rawFormat('dmy-hi');
        $dataPosInvoice['user_id'] = Auth::user()->id;
        $dataPosInvoice['customer_id'] = $request->customer_id;
        $dataPosInvoice['note'] = $request->note;
        $dataPosInvoice['payment'] = $request->payment;
        $dataPosInvoice['tax_id'] = $tax->id;
        $dataPosInvoice['tax_fee'] = $request->tax_fee;
        $dataPosInvoice['total_price_product'] = $request->total_price_product;
        $dataPosInvoice['total_last'] = $request->total_last;
        $dataPosInvoice['discount_invoice'] = $request->discount_invoice;
        $posInvoice = PosInvoice::create($dataPosInvoice);

        parse_str($_POST['form_data'], $data);//parse string of $_POST['form_data'] to $data
        for ($count = 0; $count < count($data['item_productId']); $count++) {
            $dataDetail = array(
                'pos_invoice_id' => $posInvoice->id,
                'product_id' => $data['item_productId'][$count],
                'buying_quantity' => $data['item_quantity'][$count],
                'price' => $data['item_price'][$count],
                'discount' => $data['item_discount'][$count],
                'sub_total' => $data['item_subTotal'][$count],
            );

            //Delete quantity of Product
            $product = Product::find( $data['item_productId'][$count]);
            $product->quantity -= $data['item_quantity'][$count];
            $product->save();

            //Save Information
            $posInvoiceDetail = PosInvoiceDetail::create($dataDetail);
            $result = array('message' => 'Success');
            return json_encode($result);
        }
    }
}
