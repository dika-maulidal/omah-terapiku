<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class DashboardQuery 
{
    public function perikaHariini()
    {
        $user = auth()->user();
        $role = $user->role_display();
        return Rekam::whereDate('tgl_rekam', date('Y-m-d'))
                        ->when($role == "Dokter", function ($query) use ($user){
                            $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
                            if ($dokter) {
                                $query->where('dokter_id', '=', $dokter->id);
                            }
                        })
                        ->count();
    }

    public function pasienAntri(){
        $user = auth()->user();
        $role = $user->role_display();
        return Rekam::whereDate('tgl_rekam', date('Y-m-d'))
                        ->when($role == "Dokter", function ($query) use ($user){
                            $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
                            if ($dokter) {
                                $query->where('dokter_id', '=', $dokter->id);
                            }
                        })
                        ->whereIn('status', [1, 2])
                        ->count();
    }

    public function perikaBulanini()
    {
        $user = auth()->user();
        $role = $user->role_display();
        return Rekam::whereMonth('tgl_rekam', date('m'))
                    ->whereYear('tgl_rekam', date('Y'))
                    ->when($role == "Dokter", function ($query) use ($user){
                        $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
                        if ($dokter) {
                            $query->where('dokter_id', '=', $dokter->id);
                        }
                    })
                    ->count();
    }

    public function perikaTahunini()
    {
        $user = auth()->user();
        $role = $user->role_display();
        return Rekam::whereYear('tgl_rekam', date('Y'))
                    ->when($role == "Dokter", function ($query) use ($user){
                        $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
                        if ($dokter) {
                            $query->where('dokter_id', '=', $dokter->id);
                        }
                    })
                    ->count();
    }

    public function totalPeriksa()
    {
        $user = auth()->user();
        $role = $user->role_display();
        return Rekam::when($role == "Dokter", function ($query) use ($user){
            $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
            if ($dokter) {
                $query->where('dokter_id', '=', $dokter->id);
            }
        })->count();
    }

    public function totalPasien()
    {
        return Pasien::whereNull('deleted_at')->count();
    }

    public function totalDoktor()
    {
        return Dokter::where('status', 1)->count();
    }

    public function diagnosaBulanan(){
        $filterBulan = date('Y-m');
        $data = DB::select('
            select aa.*, ic.name_id from (
                select diagnosa, count(diagnosa) as total
                from (
                    select a.diagnosa
                    from rekam_diagnosa a 
                    LEFT JOIN rekam r ON r.id = a.rekam_id
                    where a.diagnosa is not null
                    and r.tgl_rekam LIKE "%'.$filterBulan.'%"
                ) sc
                group by diagnosa
            ) aa 
            left join icds ic on ic.code = aa.diagnosa
            order by total desc limit 10');
            
        return $data;
    }

    public function diagnosaYearly(){
        $filter = date('Y-');
        $data = DB::select('
            select aa.*, ic.name_id from (
                select diagnosa, count(diagnosa) as total
                from (
                    select a.diagnosa
                    from rekam_diagnosa a
                    LEFT JOIN rekam r ON r.id = a.rekam_id
                    where a.diagnosa is not null
                    and r.tgl_rekam LIKE "%'.$filter.'%"
                ) sc
                group by diagnosa
            ) aa 
            left join icds ic on ic.code = aa.diagnosa
            order by total desc limit 10');
            
        return $data;
    }

    function rekam_day(){
        $user = auth()->user();
        $role = $user->role_display();

        return Rekam::latest()
                ->whereDate('tgl_rekam', date('Y-m-d'))
                ->when($role == "Dokter", function ($query) use ($user){
                    $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
                    if ($dokter) {
                        $query->where('dokter_id', '=', $dokter->id);
                    }
                })
                ->get();
    }

    function rekam_day2(){
        $user = auth()->user();
        $role = $user->role_display();

        return Rekam::orderBy('id', 'asc')
                ->whereDate('tgl_rekam', date('Y-m-d'))
                ->when($role == "Dokter", function ($query) use ($user){
                    $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
                    if ($dokter) {
                        $query->where('dokter_id', '=', $dokter->id);
                    }
                })
                ->get();
    }

    function rekam_antrian(){
        $user = auth()->user();
        $role = $user->role_display();

        return Rekam::orderBy('id', 'desc')
                ->whereDate('tgl_rekam', date('Y-m-d'))
                ->where('status', 2)
                ->when($role == "Dokter", function ($query) use ($user){
                    $dokter = Dokter::where('user_id', $user->id)->where('status', 1)->first();
                    if ($dokter) {
                        $query->where('dokter_id', '=', $dokter->id);
                    }
                })
                ->get();
    }
}