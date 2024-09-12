<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
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
            // リクエストからファイルを取得
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

                    // トランザクションコミット
                    \DB::commit();
                } catch (\Exception $e) {
                    // トランザクションロールバック
                    \DB::rollBack();
                    fclose($fp);
                    return redirect()->back()->with('error', 'CSVファイルのインポートに失敗しました: ' . $e->getMessage());
                }

                // ファイルを閉じる
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
        // csvファイル情報をインサートする
        $area = Area::firstOrCreate(['name' => $csvData[1]]);
        $genre = Genre::firstOrCreate(['name' => $csvData[2], 'image_url' => $csvData[4]]);

        Shop::create([
            'name' => $csvData[0],
            'area_id' => $area->id,
            'genre_id' => $genre->id,
            'description' => $csvData[3],
            'image_url' => $csvData[4]
        ]);
    }
}
