@extends('adminlte::page')

@section('title', 'Form Penyelesaian Perbaikan')

@section('content_header')
    <h1>Form Penyelesaian Perbaikan</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('maintenance.complete', $maintenance->id) }}" method="POST">
                @csrf
                <input type="hidden" name="maintenance_id" value="{{ $maintenance->id }}">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Asset</label>
                            <input type="text" class="form-control" value="{{ $maintenance->asset->name }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Selesai</label>
                            <input type="datetime-local" class="form-control" name="completion_date" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Tindakan yang Dilakukan</label>
                    <textarea class="form-control" name="actions_taken" rows="3" required 
                        placeholder="Jelaskan tindakan perbaikan yang telah dilakukan"></textarea>
                </div>

                <div class="form-group">
                    <label>Hasil Perbaikan</label>
                    <textarea class="form-control" name="results" rows="3" required 
                        placeholder="Jelaskan hasil dari perbaikan yang dilakukan"></textarea>
                </div>

                <div class="form-group">
                    <label>Part / Suku Cadang yang Diganti</label>
                    <textarea class="form-control" name="replaced_parts" rows="2" 
                        placeholder="Sebutkan suku cadang yang diganti (jika ada)"></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Total Biaya</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" class="form-control" name="total_cost" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status Barang</label>
                            <select class="form-control" name="equipment_status" required>
                                <option value="fully_repaired">Sepenuhnya Diperbaiki & Siap Digunakan</option>
                                <option value="partially_repaired">Sebagian Diperbaiki & Kemungkinan Rusak</option>
                                <option value="needs_replacement">Perlu Penggantian</option>
                                <option value="beyond_repair">Rusak Total / Tidak Dapat Diperbaiki</option>
                                <option value="temporary_fix">Perbaikan Sementara</option>
                                <option value="pending_parts">Menunggu Suku Cadang</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Rekomendasi Perawatan Selanjutnya</label>
                    <textarea class="form-control" name="recommendations" rows="2" 
                        placeholder="Berikan rekomendasi untuk perawatan selanjutnya"></textarea>
                </div>

                <div class="form-group">
                    <label>Catatan Tambahan</label>
                    <textarea class="form-control" name="additional_notes" rows="2" 
                        placeholder="Catatan tambahan (jika ada)"></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Teknisi yang Mengerjakan</label>
                            <input type="text" class="form-control" name="technician_name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Prioritas Tindak Lanjut</label>
                            <select class="form-control" name="follow_up_priority" required>
                                <option value="low">Rendah</option>
                                <option value="medium">Sedang</option>
                                <option value="high">Tinggi</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="text-right mt-4">
                    <a href="{{ route('maintenance.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
@endsection 