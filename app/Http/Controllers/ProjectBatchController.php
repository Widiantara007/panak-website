<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Project;
use App\Models\ProjectBatch;
use App\Models\Transaction;
use App\Models\UserPortofolio;
use App\Notifications\UserNotification;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectBatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($project_id)
    {
        $project = Project::find($project_id);
        return view('admin.project_batch.create', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($project_id, Request $request)
    {
        $validatedData = $request->validate([
            'batch_no' => 'required|numeric',
            'minimum_fund' => 'required|numeric',
            'maximum_fund' => 'nullable|numeric',
            'target_nominal' => 'required|numeric',
            'roi_low' => 'required|numeric',
            'roi_high' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'is_yearly' => 'required|boolean'
        ]);

        $store = ProjectBatch::insert([
            'project_id' => $project_id,
            'batch_no' => $request->batch_no,
            'minimum_fund' => $request->minimum_fund,
            'maximum_fund' => $request->maximum_fund,
            'target_nominal' => $request->target_nominal,
            'lot' => ($request->target_nominal / $request->minimum_fund),
            'roi_low' => $request->roi_low,
            'roi_high' => $request->roi_high,
            'is_yearly' => $request->is_yearly,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'draft',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        if ($store) {
            Toastr::success('Data berhasil ditambahkan', 'Berhasil!');
            return redirect()->route('project.show', $project_id);
        } else {
            Toastr::error('Data gagal ditambahkan, coba lagi', 'Gagal!');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($project_id, $project_batch_id)
    {
        $project = Project::find($project_id);
        $project_batch = ProjectBatch::find($project_batch_id);
        return view('admin.project_batch.edit', compact('project', 'project_batch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $project_id, $project_batch_id)
    {
        $validatedData = $request->validate([
            'batch_no' => 'required|numeric',
            'minimum_fund' => 'required|numeric',
            'maximum_fund' => 'nullable|numeric',
            'target_nominal' => 'required|numeric',
            'roi_low' => 'required|numeric',
            'roi_high' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'is_yearly' => 'required|boolean',
            'gross_income' => 'nullable|numeric'
        ]);
        $project_batch = ProjectBatch::find($project_batch_id);

        $update = $project_batch->update([
            'batch_no' => $request->batch_no,
            'minimum_fund' => $request->minimum_fund,
            'maximum_fund' => $request->maximum_fund,
            'target_nominal' => $request->target_nominal,
            'lot' => ($request->target_nominal / $request->minimum_fund),
            'roi_low' => $request->roi_low,
            'roi_high' => $request->roi_high,
            'is_yearly' => $request->is_yearly,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'updated_at' => Carbon::now(),
        ]);
        if(!empty($request->gross_income)){
            $update = $project_batch->update([
                'gross_income' => $request->gross_income,
            ]);
        }
        if(!empty($request->roi)){
            $update = $project_batch->update([
                'roi' => $request->roi,
            ]);
        }

        if ($update) {
            Toastr::success('Data berhasil diubah', 'Berhasil!');
            return redirect()->route('project.show', $project_id);
        } else {
            Toastr::error('Data gagal diubah, coba lagi', 'Gagal!');
            return redirect()->back();
        }
    }

    public function updateStatus($project_id, $project_batch_id, Request $request)
    {
        $project_batch = ProjectBatch::find($project_batch_id);

        $update = $project_batch->update([
            'status' => $request->status,
            'updated_at' => Carbon::now(),
        ]);

        //otomatis invest dana jika sebelumnya investasi tahunan
        if ($request->status == 'funding') {
            $project_batch_before = ProjectBatch::where('project_id', $project_id)->where('batch_no', $project_batch->batch_no - 1)->first();
            if (!empty($project_batch_before)) {
                $user_portofolios = $project_batch_before->user_portofolios->where('quota', '>', 0);
                if ($user_portofolios != '[]') {
                    foreach ($user_portofolios as $portofolio) {
                        //invest langsung

                        //masukin ke portofolio
                        $storePortfolio = UserPortofolio::create([
                            'user_id' => $portofolio->user_id,
                            'project_id' => $project_id,
                            'project_batch_id' => $project_batch_id,
                            'lot' => $portofolio->lot,
                            'nominal' => $portofolio->nominal,
                            'quota' => $portofolio->quota - 1,
                        ]);
                        //masukin ke transaksi
                        Transaction::create([
                            'user_id' => $portofolio->user_id,
                            'type' => 'investnak',
                            'transaction_type' => 'reinvest',
                            'project_batch_id' => $project_batch_id,
                            'user_portofolio_id' => $storePortfolio->id,
                            'nominal' => $portofolio->nominal,
                            'payment_method' => 'By System',
                            'status' => 'success',
                            'description' => 'reinvest ' . $project_batch->fullName(),
                        ]);
                    }
                }
            }
        }elseif($request->status == 'ongoing'){
            //notifikasi user
            foreach($project_batch->user_portofolios as $portofolio){
                $portofolio->user->notify(new UserNotification('investnak_start','Project '.$project_batch->fullName().' telah dimulai!', route('profile.portofolio')));
            }
        }elseif ($request->status == 'closed') {
            $validatedData = $request->validate([
                'gross_income' => 'nullable|numeric',
                'roi' => 'required|numeric'
            ]);
            $update = $project_batch->update([
                'gross_income' => $request->gross_income,
                'roi' => $request->roi,
                'updated_at' => Carbon::now(),
            ]);

            //notifikasi user
            foreach($project_batch->user_portofolios as $portofolio){
                $portofolio->user->notify(new UserNotification('investnak_stop','Project '.$project_batch->fullName().'  telah Selesai!', route('profile.portofolio')));
            }
        }

        $notif = $request->status == 'funding' ? 'dibuka' : ($request->status == 'ongoing' ? 'dimulai' : ($request->status == 'closed' ? 'ditutup' : ''));

        if ($update) {
            $log = [
                'user_id' => Auth::user()->id,
                'workflow_type' => 'project',
                'activity' => 'edit',
                'description' => $project_batch->fullName().' '.$notif,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            $document = Log::create($log);
            Toastr::success('Batch berhasil ' . $notif, 'Berhasil!');
            return redirect()->route('project.show', $project_id);
        } else {
            Toastr::error('Batch gagal ' . $notif . ' coba lagi', 'Gagal!');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($project_id, $project_batch_id)
    {
        $delete = ProjectBatch::find($project_batch_id)->delete();
        if ($delete) {
            Toastr::success('Data berhasil dihapus', 'Berhasil!');
            return redirect()->route('project.show', $project_id);
        } else {
            Toastr::error('Data gagal dihapus, coba lagi', 'Gagal!');
            return redirect()->back();
        }
    }

    public function payReturn($project_id, $project_batch_id)
    {
        $project_batch = ProjectBatch::find($project_batch_id);
        // $return_per_lot = floor($project_batch->gross_income / $project_batch->totalLot());
        $return_per_lot = floor($project_batch->minimum_fund + ($project_batch->minimum_fund*$project_batch->roi/100));

        //bagiin ke user
        foreach ($project_batch->user_portofolios as $portofolio) {
            $return_nominal = $portofolio->lot * $return_per_lot;
            $portofolio->update([
                'return_nominal' => $return_nominal,
            ]);

            if ($portofolio->quota == 0) {
                //jika tidak otomatis ikut batch selanjutnya
                Transaction::create([
                    'user_id' => $portofolio->user_id,
                    'type' => 'investnak',
                    'transaction_type' => 'return',
                    'project_batch_id' => $project_batch_id,
                    'user_portofolio_id' => $portofolio->id,
                    'nominal' => $return_nominal,
                    'payment_method' => 'Wallet',
                    'status' => 'success',
                    'description' => 'pembagian hasil investnak'
                ]);
                $portofolio->user->plusBalance($return_nominal);
                $portofolio->user->notify(new UserNotification('transaction_income','Rp '.number_format($return_nominal,0,",",".").' telah berhasil ditambahkan ke dalam saldo anda.', route('profile.wallet')));
            } else {
                //jika masih akan ikut batch selanjutnya maka hanya akan mengembalikan keuntungan
                $profit = $return_nominal - $portofolio->nominal;
                Transaction::create([
                    'user_id' => $portofolio->user_id,
                    'type' => 'investnak',
                    'transaction_type' => 'return',
                    'project_batch_id' => $project_batch_id,
                    'user_portofolio_id' => $portofolio->id,
                    'nominal' => $profit,
                    'payment_method' => 'Wallet',
                    'status' => 'success',
                    'description' => 'pembagian hasil investnak'
                ]);
                $portofolio->user->plusBalance($profit);
                $portofolio->user->notify(new UserNotification('transaction_income','Rp '.number_format($profit,0,",",".").' telah berhasil ditambahkan ke dalam saldo anda.', route('profile.wallet')));

            }
        }

        //update status
        $update = $project_batch->update([
            'status' => 'paid',
            'updated_at' => Carbon::now(),
        ]);

        if ($update) {
            $log = [
                'user_id' => Auth::user()->id,
                'workflow_type' => 'project',
                'activity' => 'edit',
                'description' => $project_batch->fullName().' dibayarkan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            $document = Log::create($log);
            Toastr::success('Dana berhasil diteruskan', 'Berhasil!');
            return redirect()->route('project.show', $project_id);
        } else {
            Toastr::error('Dana gagal diteruskan, coba lagi', 'Gagal!');
            return redirect()->back();
        }
    }
}
