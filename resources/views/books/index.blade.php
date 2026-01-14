<!-- resources/views/books/index.blade.php -->
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Daftar Buku KUTUBUKU</span>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">Kembali ke Dashboard</a>
                </div>
                <div class="card-body">
                    <!-- TAMBAHKAN FORM PENCARIAN INI -->
                    <form action="{{ route('books.index') }}" method="GET" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan judul atau penulis..." value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">Cari</button>
                        </div>
                    </form>

                    <div class="row">
                        @forelse($books as $book)
                            <!-- ... kode card buku tetap sama ... -->
                        @empty
                            <p>Tidak ada buku ditemukan untuk pencarian "{{ request('search') }}".</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection