<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use Illuminate\Support\Facades\Validator;
use Exception;

class CsvImportController extends Controller
{
    public function import()
    {
        return view('csvImport');
    }

    public function csvImport(Request $request)
    {
        if ($request->hasFile('csvFile')) {
            $file = $request->file('csvFile');
            $path = $file->getRealPath();

            // ファイルを開く
            if (($fp = fopen($path, 'r')) !== FALSE) {
                // ヘッダー行をスキップ
                fgetcsv($fp);
                
                // トランザクション開始
                \DB::beginTransaction();

                try {
                    // 1行ずつ読み込む
                    while (($csvData = fgetcsv($fp)) !== FALSE) {
                        $this->insertCsvData($csvData);
                    }
                    \DB::commit();
                } catch (\Exception $e) {
                    \DB::rollBack();
                    fclose($fp);
                    return redirect()->back()->with('error', 'CSVファイルのインポートに失敗しました: ' . $e->getMessage());
                }

                fclose($fp);
                return redirect()->back()->with('success', 'CSVファイルのインポートに成功しました。');
            } else {
                return redirect()->back()->with('error', 'CSVファイルの読み取りに失敗しました。');
            }
        } else {
            return redirect()->back()->with('error', 'CSVファイルの取得に失敗しました。');
        }
    }

     public function insertCsvData($csvData)
    {
        $rules = [
            'name' => 'required|string|max:50',
            'area' => 'required|in:東京都,大阪府,福岡県',
            'genre' => 'required|in:寿司,焼肉,イタリアン,居酒屋,ラーメン',
            'description' => 'required|string|max:400',
            'image_url' => ['required', 'url', 'regex:/\.(jpeg|jpg|png)$/i'],

        ];

        $data = [
            'name' => $csvData[0],
            'area' => $csvData[1],
            'genre' => $csvData[2],
            'description' => $csvData[3],
            'image_url' => $csvData[4],
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new Exception("バリデーションエラー: " . implode(", ", $validator->errors()->all()));
        }

        $area = Area::firstOrCreate(['name' => $data['area']]);
        $genre = Genre::firstOrCreate(['name' => $data['genre']]);

        Shop::create([
            'name' => $data['name'],
            'area_id' => $area->id,
            'genre_id' => $genre->id,
            'description' => $data['description'],
            'image_url' => $data['image_url']
        ]);
    }
}
