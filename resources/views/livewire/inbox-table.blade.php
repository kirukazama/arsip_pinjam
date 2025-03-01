<div>
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Nama Pegawai</th>
                <th>Unit Kerja</th>
                <th>Nomor Telepon</th>
                <th>Jenis Arsip</th>
                <th>Keterangan</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Tindakan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($archives as $index => $archive)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $archive->nip }}</td>
                    <td>{{ $archive->nama_pegawai }}</td>
                    <td>{{ $archive->unit_kerja }}</td>
                    <td>{{ $archive->nomor_telepon }}</td>
                    <td>{{ $archive->jenis_arsip }}</td>
                    <td>{{ $archive->keterangan }}</td>
                    <td>{{ $archive->tanggal_pinjam }}</td>
                    <td>{{ $archive->tanggal_kembali }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm">Edit</button>
                        <button class="btn btn-info btn-sm">Email</button>
                        <button class="btn btn-primary btn-sm">Print</button>
                        <button wire:click="deleteArchive({{ $archive->id }})" class="btn btn-danger btn-sm">Hapus</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $archives->links() }}
</div>
