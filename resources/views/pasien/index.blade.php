@extends('layout.apps')
@section('content')
<div class="mr-auto mb-3">
    <h2 class="text-black font-w600">Data Penerima Manfaat</h2>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group col-lg-6" style="float: left">
                    <a href="{{Route('penerima-manfaat.add')}}" class="btn btn-primary mr-2">+Penerima Manfaat Baru</a>
                    <a href="{{Route('penerima-manfaat.export-csv', ['keyword' => request('keyword')])}}" class="btn btn-success" title="Download data penerima manfaat ke CSV">
                        <i class="fa fa-file-excel-o mr-1"></i> Export CSV
                    </a>
                </div>
                <div class="form-group col-lg-6" style="float: right">
                    <form method="get" action="{{ url()->current() }}">
                        <div class="input-group">
                            <input type="text" class="form-control gp-search" name="keyword" value="{{request('keyword')}}" placeholder="Cari" value="" autocomplete="off">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default no-border btn-sm gp-search">
                                <i class="ace-icon fa fa-search icon-on-right bigger-110"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                </div>

                <div class="table-responsive card-table"> 
                    <table class="table table-responsive-md">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No. RM</th>
                                <th>Nama Penerima Manfaat</th>
                                <th>TTL</th>
                                <th>Alamat</th>
                                <th>JK</th>
                                <th>Desil</th>
                                <th>No. HP</th>
                                <th>Status Layanan</th>
                                <th>Status</th>
                                <th style="min-width: 125px; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($datas as $key=>$row)
                                <tr>
                                    <td>{{$datas->firstItem() + $key}}</td>
                                   <td><a href="{{Route('rekam.detail',$row->id)}}">{{$row->no_rm}}</a></td>
                                   <td>{{$row->nama}}</td>
                                   <td>{{$row->tmp_lahir}},{{$row->tgl_lahir}}</td>
                                   <td>{{$row->alamat_lengkap}}</td>
                                   <td>{{$row->jk}}</td>
                                   <td>
                                       @if ($row->desil)
                                           <span class="badge badge-primary light font-w600">{{$row->desil}}</span>
                                       @else
                                           <span class="text-muted">-</span>
                                       @endif
                                   </td>
                                   <td>{{$row->no_hp}}</td>
                                   <td>Gratis, tidak dipungut biaya</td>
                                   <td>
                                      {!! $row->statusPasien() !!}
                                   </td>
                                   <td style="white-space: nowrap;">
                                       <div class="d-flex align-items-center justify-content-center">
                                           <a href="{{Route('rekam.detail',$row->id)}}" class="btn btn-primary shadow btn-xs sharp mr-1" title="Lihat Rekam Medis">
                                               <i class="fa fa-eye"></i>
                                           </a>
                                           <a href="{{Route('penerima-manfaat.edit',$row->id)}}" class="btn btn-info shadow btn-xs sharp mr-1" title="Edit Data Pasien">
                                               <i class="fa fa-pencil"></i>
                                           </a>
                                           <a href="#" class="btn btn-danger shadow btn-xs sharp delete" r-link="{{Route('penerima-manfaat.delete',$row->id)}}"
                                               r-name="{{$row->nama}}" r-id="{{$row->id}}" title="Hapus Data Pasien">
                                               <i class="fa fa-trash"></i>
                                           </a>
                                       </div>
                                   </td>
                                </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                    <div class="dataTables_info" id="example_info" role="status"
                    aria-live="polite">Showing {{$datas->firstItem()}} to {{$datas->perPage() * $datas->currentPage()}} of {{$datas->total()}} entries</div>
                   {{ $datas->appends(request()->except('page'))->links() }}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
        $().ready( function () {
            $(".delete").click(function() {
                 var id = $(this).attr('r-id');
                 var name = $(this).attr('r-name');
                 var link = $(this).attr('r-link');
                 Swal.fire({
                  title: 'Ingin Menghapus?',
                  text: "Yakin ingin menghapus data  : "+name+" ini ?" ,
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, hapus !'
                }).then((result) => {
                  console.log(result);
                  if (result.value) {
                      window.location = link;
                  }
                });
            });
        } );
    </script>
@endsection