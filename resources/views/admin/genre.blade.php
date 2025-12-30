@extends('layouts.layoutsAdmin')

@section('title', 'Admin - Kelola Genre')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/book-management.css') }}">
    <link rel="stylesheet" href="{{ asset('css/genre.css') }}"> 
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}"> 

    <style>
     .genre-card { border: none; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); transition: transform 0.3s; height: 100%; }
     .genre-card:hover { transform: translateY(-5px); }
     .card-img-container { height: 200px; background-color: #f8f9fa; display: flex; align-items: center; justify-content: center; border-radius: 10px 10px 0 0; }
     .card-img-top { max-height: 100%; max-width: 100%; object-fit: contain; }
     .card-body { padding: 1.25rem; }
     .card-title { font-weight: 600; margin-bottom: 0.5rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
     .card-text { color: #6c757d; font-size: 0.9rem; margin-bottom: 0.3rem; }
     .card-footer { background: transparent; border-top: none; padding: 0.75rem 1.25rem; }
     .action-buttons .btn { padding: 0.25rem 0.5rem; font-size: 0.8rem; margin-right: 0.3rem; }
     .genre-heading { border-bottom: 2px solid #dee2e6; padding-bottom: 0.5rem; margin-bottom: 1.5rem; }
     .books-container { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
   </style>
@endpush


@section('content')
<main class="col-lg-10 col-md-9 ms-sm-auto px-4">
    <div class="container mt-4">
        
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="mb-4 ms-5">
            <a href="{{ url('/books/create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Buku
            </a>
        </div>

        <div class="filters-container ms-5">
            <h5 class="mb-3"><i class="fas fa-filter me-2"></i>Filter by Genre</h5>
            <div class="btn-group flex-wrap">
                <a href="{{ url('/genre') }}" class="btn btn-outline-primary {{ empty($current_genre) ? 'active' : '' }}">
                    <i class="fas fa-border-all me-1"></i> All Books
                </a>
                
                @foreach($all_genres as $g)
                    <a href="{{ url('/genre', ['genre' => $g]) }}" 
                       class="btn btn-outline-primary {{ ($current_genre == $g) ? 'active' : '' }}">
                        {{ $g }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- === BAGIAN 1: JIKA GENRE DIPILIH === --}}
        @if(!empty($current_genre))
            <div class="genre-section ms-5">
                <h3 class="genre-heading">{{ $current_genre }}</h3>
                
                @forelse($books_to_show as $book)
                    <div class="books-container">
                        <div class="card genre-card">
                            <div class="card-img-container">
                                @if (!empty($book['image_path']))
                                    <img src="{{ $book['image_path'] }}" class="card-img-top">
                                @else
                                    <div class="text-center text-muted">
                                        <i class="fas fa-book fa-3x mb-2"></i>
                                        <p>No Image</p>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $book['title'] }}</h5>
                                <p class="card-text"><strong>Author:</strong> {{ $book['author'] }}</p>
                                <p class="card-text"><strong>Year:</strong> {{ $book['year'] }}</p>
                            </div>
                            <div class="card-footer action-buttons">

                                {{-- VIEW BUTTON --}}
                                <a href="{{ route('admin.buku.lihat', $book['id']) }}" 
                                   class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('admin.buku.edit', $book['id']) }}" 
                                   class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form method="POST" action="{{ url('/books/delete') }}" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $book['id'] }}">
                                    <input type="hidden" name="genre_filter" value="{{ $current_genre }}"> 
                                    <button type="submit" name="delete" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    @include('partials.view-modal', ['book' => $book])

                @empty
                    <div class="alert alert-info">
                        No books found in the "{{ $current_genre }}" genre.
                    </div>
                @endforelse
            </div>

        @else
        
            @if($grouped_books->isNotEmpty())
                
                @foreach($grouped_books as $genreName => $booksInGenre)
                    <div class="genre-section ms-5">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="genre-heading">{{ $genreName }}</h3>
                            <a href="{{ url('/genre', ['genre' => $genreName]) }}" class="btn btn-sm btn-outline-primary">
                                View All <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                        
                        <div class="books-container">
                            @foreach($booksInGenre->take(4) as $book) 
                                <div class="card genre-card">
                                    <div class="card-img-container">
                                        @if (!empty($book['image_path']))
                                            <img src="{{ $book['image_path'] }}" class="card-img-top">
                                        @else
                                            <div class="text-center text-muted">
                                                <i class="fas fa-book fa-3x mb-2"></i>
                                                <p>No Image</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $book['title'] }}</h5>
                                        <p class="card-text"><strong>Author:</strong> {{ $book['author'] }}</p>
                                        <p class="card-text"><strong>Year:</strong> {{ $book['year'] }}</p>
                                    </div>
                                    <div class="card-footer action-buttons">
                                        
                                        <a href="{{ route('admin.show-book', $book['id']) }}" 
                                           class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- EDIT BUTTON --}}
                                        <a href="{{ route('admin.buku.edit', $book['id']) }}" 
                                           class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form method="POST" action="{{ url('/books/delete') }}" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $book['id'] }}">
                                            <input type="hidden" name="genre_filter" value="">
                                            <button type="submit" name="delete" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                @include('partials.view-modal', ['book' => $book])

                            @endforeach
                        </div>
                    </div>
                @endforeach
                
            @else
                <div class="no-books-message ms-5 text-center py-5">
                    <i class="fas fa-book-open fa-3x mb-3 text-muted"></i>
                    <h4>No books found in the database</h4>
                    <p>Add your first book to get started!</p>
                    <a href="{{ url('/books/create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus me-2"></i>Add Book
                    </a>
                </div>
            @endif
        @endif
    </div>
</main>
@endsection


@push('scripts')
<script>
    document.querySelector('.sidebar-toggle').addEventListener('click', function() {
      document.querySelector('.sidebar').classList.toggle('active');
    });
    
    document.addEventListener('click', function(event) {
      const sidebar = document.querySelector('.sidebar');
      const toggleBtn = document.querySelector('.sidebar-toggle');
      
      if (window.innerWidth <= 768 && 
          !sidebar.contains(event.target) && 
          event.target !== toggleBtn && 
          !toggleBtn.contains(event.target)) {
        sidebar.classList.remove('active');
      }
    });
</script>
@endpush
