<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class LiveSearchController extends Controller
{


    function index()
    {
         $users = DB::table('order_mst')
            ->join('users', 'users.id', '=', 'order_mst.c_user_code')
             ->select('users.c_firm_code','users.name', 'order_mst.n_srno', 'order_mst.d_date')
//             ->where('users', 'users.c_firm_code', '=', 'order_mst.c_firm_code')
             ->where('order_mst.n_cancel_flag', '!=', '1')
             ->where('order_mst.n_order_status', '=', '1')
             ->where('order_mst.c_firm_code', '=', '000000')
             ->orderBy('order_mst.n_srno', 'desc')
            ->get();
        return view('live_search', compact('users'));
     return view('live_search');
    }
 
   
     public function detailView(int $n_srno) {
        $users = DB::table('order_mst')
            ->join('users', 'users.id', '=', 'order_mst.c_user_code')
             ->select('users.c_firm_code','users.name', 'order_mst.n_srno', 'order_mst.d_date')
//             ->where('users', 'users.c_firm_code', '=', 'order_mst.c_firm_code')
             ->where('order_mst.n_cancel_flag', '!=', '1')
             ->where('order_mst.n_order_status', '=', '1')
             ->where('order_mst.c_firm_code', '=', '000000')
             ->where('order_mst.n_srno', '=', $n_srno)->get();
        return view('Detailed_view_order', compact('users'));
    }
    
    
 function searchview(Request $request)
    {
     if($request->ajax())
     {
      $output = '';
      $query = $request->get('query');
      if($query != '')
      {
        $data = DB::table('order_mst')
            ->join('users', 'users.id', '=', 'order_mst.c_user_code')
             ->select('users.c_firm_code','users.name', 'order_mst.n_srno', 'order_mst.d_date')
//             ->where('users', 'users.c_firm_code', '=', 'order_mst.c_firm_code')
             ->where('order_mst.n_cancel_flag', '!=', '1')
             ->where('order_mst.n_order_status', '=', '1')
             ->where('order_mst.c_firm_code', '=', '000000')
         ->Where('users.name', 'like', '%'.$query.'%')
         ->orWhere('order_mst.d_date', 'like', '%'.$query.'%')

        ->orderBy('order_mst.n_srno', 'desc')
         ->get();
         
      }
     
     $total_row = $data->count();
      if($total_row > 0)
      {
       foreach($data as $row)
       {
        $output .= '
           
    <tr>
        <td>
            <div class="sort-handler">
                 <i class="fas fa-th"></i>
             </div>
          </td>
          
          <td>'.$row->id.'</td>
          <td>'.$row->name.'</td>
          <td>'.$row->c_firm_code.'</td>
          <td>'.$row->order_date.'</td>
          <td><a href="{{ url("home/view/'.$row->id.'") }}">Detail Info</a>
           </td>
         </tr>

        ';
       }
      }
      else
      {
       $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
      }
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     }
    }
   
   
}

   

