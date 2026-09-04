<?php

namespace App\Http\Controllers;

use App\Models\Rekam;
use Illuminate\Http\Request;
// use Image;
use App\Models\RekamDiagnosa;
class RekamPemeriksaanController extends Controller
{
    private function ensureClinicalRole()
    {
        if (!in_array(auth()->user()->role_display(), ['Admin', 'Dokter'])) {
            abort(403);
        }
    }

    public function pemeriksaan(Request $request)
    {
        $this->ensureClinicalRole();

        $this->validate($request,[
            'rekam_id' => 'required',
            'pasien_id' => 'required',
            'pemeriksaan' => 'required',
        ]);

        $rekam = Rekam::find($request->rekam_id);
        $rekam->update([
            'pemeriksaan' => $request->pemeriksaan
        ]);

        if ($request->hasFile('file')) {
            $extension = $request->file('file')->getClientOriginalExtension();
            $safeNoRekam = preg_replace('/[^a-zA-Z0-9_-]/', '-', $rekam->no_rekam ?: $rekam->id);
            $fileName = "PEM-" . $safeNoRekam . "-" . time() . '.' . $extension;
            $destinationPath = public_path('images/pemeriksaan');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $request->file('file')->move($destinationPath, $fileName);
            $rekam->update(
                ['pemeriksaan_file' => $fileName]
            );
        }

        return redirect()->route('rekam.detail', $request->pasien_id)
                ->with('sukses', 'Pemeriksaan (O) Berhasil diperbaharui');
    }

    function diagnosa_delete(Request $reques,$id){
        $rekam = RekamDiagnosa::find($id);
        $rekam->delete();

        return redirect()->route('rekam.detail',$rekam->pasien_id)
                ->with('sukses','Diagnosa Berhasil dihapus');
    }

    public function diagnosa(Request $request)
    {
        $this->ensureClinicalRole();

        $this->validate($request,[
            'rekam_id' => 'required',
            'pasien_id' => 'required',
            'diagnosa' => 'required',
        ]);

        $rekam = Rekam::findOrFail($request->rekam_id);
        $rekam->update([
            'diagnosa' => $request->diagnosa
        ]);

        RekamDiagnosa::updateOrCreate(
            ['rekam_id' => $request->rekam_id, 'pasien_id' => $request->pasien_id],
            ['diagnosa' => $request->diagnosa]
        );

        return redirect()->route('rekam.detail', $request->pasien_id)
                ->with('sukses', 'Assessment / Diagnosa Terapi Berhasil diperbaharui');
    }

    public function tindakan(Request $request)
    {
        $this->ensureClinicalRole();

        $this->validate($request,[
            'rekam_id' => 'required',
            'pasien_id' => 'required',
            'tindakan' => 'required',
        ]);

        $rekam = Rekam::find($request->rekam_id);
        $rekam->update([
            'tindakan' => $request->tindakan
        ]);

        if ($request->hasFile('file')) {
            $extension = $request->file('file')->getClientOriginalExtension();
            $safeNoRekam = preg_replace('/[^a-zA-Z0-9_-]/', '-', $rekam->no_rekam ?: $rekam->id);
            $fileName = "TIND-" . $safeNoRekam . "-" . time() . '.' . $extension;
            $destinationPath = public_path('images/pemeriksaan');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $request->file('file')->move($destinationPath, $fileName);
            $rekam->update(
                ['tindakan_file' => $fileName]
            );
        }

        return redirect()->route('rekam.detail', $request->pasien_id)
                ->with('sukses', 'Plan & Tindakan (P) Berhasil diperbaharui');
    }

    function file(Request $request, $id, $type){
        $data = Rekam::find($id);
        return view('rekam.file',compact('data','type'));

    }

    function insertToTableNew(){
        $rekam = Rekam::whereNotNull('diagnosa')->get();
        foreach ($rekam as $key => $data) {
            $data = array(
                'pasien_id' => $data->pasien_id,
                'rekam_id' => $data->id,
                'diagnosa' => $data->diagnosa
            );
            RekamDiagnosa::updateOrCreate($data,$data);

        }
    }
    

}
