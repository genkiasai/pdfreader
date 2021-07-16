<?php
    if (isset($_FILES["file"])) {
        // ユーザが送信したフォルダ内のPDFをカレントディレクトリに保存
        $files = $_FILES["file"];
        $cntFile = count($files["name"]);
        for ($i = 0; $i < $cntFile; $i++) {
            $file = $files["name"][$i];
            $match = preg_match("#.pdf#", $file);
            if ($match === 1) {
                $tmp_file = $files["tmp_name"][$i];
                move_uploaded_file($tmp_file, __DIR__ . "/" . $file);
            }
        }

        // popplerでtxtファイルを生成
        $pdfs = glob(__DIR__ . "/*pdf");
        $cntPDF = count($pdfs);
        for ($i=0; $i < $cntPDF; $i++) { 
            $pdf = $pdfs[$i];
            $cmd1 = __DIR__ . "/poppler/bin/pdftotext.exe -enc Shift-JIS ";
            $cmd2 = $pdf . " ";
            $cmd3 = substr($pdf, 0, strlen($pdf) -4) . ".txt";
            $cmd = $cmd1 . $cmd2 . $cmd3;
            exec($cmd, $output, $result);
        }

    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDFReader</title>

    <style>
        .fileLabel {
            border: 1px solid #777;
            padding: 2px 8px;
            font-size: .8rem;
            background-color: #eee;
            border-radius: 4px;
        }

        .fileLabel:hover {
            background-color: #ddd;
        }

        .fileLabel:active {
            background-color: #fff;
        }
    </style>
</head>

<body>
    <h1>PDFReader</h1>
    <p>複数のPDFファイルが入ったフォルダを選択</p>
    <form action="" method="POST" enctype="multipart/form-data">
        <input class="" id="file" type="file" name="file[]" webkitdirectory style="display: none">
        <label class="fileLabel" for="file">フォルダを選択</label>
        <input type="submit">
    </form>
</body>
</html>