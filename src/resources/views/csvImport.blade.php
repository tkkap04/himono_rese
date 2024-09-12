@extends('layouts.app')

@section('content')
<head>
    <title>Laravel CSVインポート</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- jQuery 3.3.1のスリムバージョン（基本的な機能のみを含む軽量版）を読み込む -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.js 1.14.7を読み込む -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGaHh6f3R5g5Sgu0G5jkzLe9Hy" crossorigin="anonymous"></script>
    <!-- Bootstrap 4.3.1のJavaScriptファイルを読み込む -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container mt-5">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('csvImport') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-4" style="max-width: 500px; margin: 0 auto;">
                <div class="custom-file text-left">
                    <input type="file" name="csvFile" class="custom-file-input" id="csvFile">
                    <label class="custom-file-label" for="customFile">CSVファイル選択</label>
                </div>
            </div>
            <button class="btn btn-primary btn-lg">インポート</button>
        </form>
    </div>

    <script>
        $(document).ready(function () {
            // ファイル名を表示するための処理
            $('#csvFile').on('change', function() {
                // ファイル名を取得してラベルに設定
                var fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').html(fileName);
            });
        });
    </script>
</body>
@endsection
