<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\menu;
use App\Models\menuUsuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route as FacadesRoute;
use Illuminate\Support\Facades\DB;

class nivel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // DB::connection()->enableQueryLog();
        $user_id = Auth::user()->id ;
        $rota = FacadesRoute::getCurrentRoute()->getName();

        $liberado = menuUsuario::leftJoin('menu','menu.id','menu_usuario.menuId')
                            ->where('usuarioId',$user_id)
                            ->where('menu.rota','=',$rota)
                            ->first();

        // $queries = DB::getQueryLog();
        // dd($liberado,$user_id,$rota);

        if($liberado){
            return $next($request);
        }else{
            dd('Sem acesso');
        }
    }
}
