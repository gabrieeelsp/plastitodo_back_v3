<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

use Illuminate\Support\Facades\DB;

use App\Http\Resources\v1\ClientResource;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $searchText = trim($request->get('q'));
        $val = explode(' ', $searchText );

        $atr_surname = [];
        $atr_name = [];

        foreach ($val as $q) {
            array_push($atr_name, ['name', 'LIKE', '%'.strtolower($q).'%'] );
            array_push($atr_surname, ['surname', 'LIKE', '%'.strtolower($q).'%'] );
            
        };

        $limit = 5;
        if($request->has('limit')){
            $limit = $request->get('limit');
        }
        
        $users = null;
        //Paginate?
        if ( $request->has('paginate')) {
            $paginate = $request->get('paginate');
            
            if ( $paginate == 0 ) { 
                $users = User::orderBy('name', 'ASC')
                    ->where($atr_name)
                    ->orWhere($atr_surname)->get();
                    
                    return ClientResource::collection($users);

            }
            
        }
        
        
        $users = User::orderBy('name', 'ASC')
            ->orWhere($atr_name)
            ->paginate($limit);       
        
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $client)
    {
        return new ClientResource($client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function get_movements(Request $request, $id) {

        $limit = 5;
        if($request->has('limit')){
            $limit = $request->get('limit');
        }

        $sales = DB::table('sales')
            ->where('client_id', $id)
            ->select(
                'sales.id',
                'sales.created_at',
                'sales.total as valor',
                'sales.saldo'
            )
            ->addSelect(DB::raw("'sale' as tipo"));

        $payments = DB::table('payments')
            ->join('sales', 'payments.sale_id', '=', 'sales.id')
            ->select(
                'payments.id',
                'payments.created_at',
                'payments.valor',
                'payments.saldo'
            )
            ->addSelect(DB::raw("'payment' as tipo"));

        $refonds = DB::table('refonds')
            ->join('sales', 'refonds.sale_id', '=', 'sales.id')
            ->select(
                'refonds.id',
                'refonds.created_at',
                'refonds.valor',
                'refonds.saldo'
            )
            ->addSelect(DB::raw("'refond' as tipo"));
        
        
        $devolutions = DB::table('devolutions')
            ->join('sales', 'devolutions.sale_id', '=', 'sales.id')
            ->select(
                'devolutions.id',
                'devolutions.created_at',
                'devolutions.total as valor',
                'devolutions.saldo'
            )
            ->addSelect(DB::raw("'devolution' as tipo"))
            ->unionall($sales)
            ->unionall($payments)
            ->unionall($refonds)
            ->orderBy('created_at', 'DESC')
            ->paginate($limit);



        /* $payments = DB::table('payments')
            ->join('sales', 'payments.sale_id', '=', 'sales.id')
            ->where('sales.client_id', $id)
            ->select(   
                'payments.id',
                'payments.created_at',
                'payments.valor',
                'payments.saldo'
                )
            ->addSelect(DB::raw('1 as tipo'));

        $sales = DB::table('sales')
            ->where('client_id', $id)
            ->select(
                'sales.id',
                'sales.created_at',
                'sales.total as valor',
                'sales.saldo'
            )
            ->addSelect(DB::raw('2 as tipo'))
            ->unionall($payments)
            ->orderBy('created_at', 'DESC')
            ->orderBy('id', 'DESC')
            ->paginate(10); */



        return $devolutions;
    }
}
