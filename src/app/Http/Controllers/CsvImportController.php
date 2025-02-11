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

            if (($fp = fopen($path, 'r')) !== FALSE) {
                fgetcsv($fp);
                
                \DB::beginTransaction();

                $errors = []; // バリデーションエラーを格納

                try {
                    while (($csvData = fgetcsv($fp)) !== FALSE) {
                        $validationErrors = $this->insertCsvData($csvData);
                        if ($validationErrors) {
                            $errors[] = $validationErrors;
                        }
                    }

                    if (!empty($errors)) {
                        \DB::rollBack();
                        fclose($fp);
                        return redirect()->back()->withErrors($errors)->withInput();
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
            'image_url' => [
                'required', 'url', 'regex:/\.(jpeg|jpg|png)$/i',
                function ($attribute, $value, $fail) {
                    if (!in_array(pathinfo(parse_url($value, PHP_URL_PATH), PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png'])) {
                        $fail('アップロード可能な画像形式は jpg, jpeg, png のみです。');
                    }
                }
            ],
        ];

        $messages = [
            'name.required' => '店舗名を入力してください。',
            'name.max' => '店舗名は50文字以内で入力してください。',
            'area.required' => '地域を選択してください。',
            'area.in' => '地域は「東京都」「大阪府」「福岡県」のいずれかを選択してください。',
            'genre.required' => 'ジャンルを選択してください。',
            'genre.in' => 'ジャンルは「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」のいずれかを選択してください。',
            'description.required' => '店舗概要を入力してください。',
            'description.max' => '店舗概要は400文字以内で入力してください。',
            'image_url.required' => '画像URLを入力してください。',
            'image_url.url' => '画像URLの形式が正しくありません。',
            'image_url.regex' => '画像URLの拡張子は jpg, jpeg, png のいずれかを指定してください。',
        ];

        $data = [
            'name' => $csvData[0],
            'area' => $csvData[1],
            'genre' => $csvData[2],
            'description' => $csvData[3],
            'image_url' => $csvData[4],
        ];

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return $validator->errors()->all();
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

        return null;
    }

}
