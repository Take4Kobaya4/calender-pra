<?php
//タイムゾーン設定を日本に設定
date_default_timezone_set('Asia/Tokyo');

if(isset($_GET['ym'])){
    $ym = $_GET['ym'];
} else {
    $ym = date('Y-m');
}

$timestamp = strtotime($ym . '-01');
if($timestamp === false) {
    $ym = date('Y-m');
    $timestamp = strtotime($ym . '-01');
}

$today = date('Y-m-j');
//カレンダータイトル
$html_title = date('Y年n月', $timestamp);

//前月・次月の年月を取得
$prev = date('Y-m' , strtotime('-1 month' , $timestamp));
$next = date('Y-m' , strtotime('+1 month' , $timestamp));
//当該月の日数を取得
$day_count = date('t', $timestamp);
//曜日の取得
$youbi = date('w', $timestamp);

$weeks = [];
$week = '';

$week .= str_repeat('<td></td>' , $youbi);

for($day = 1; $day <= $day_count; $day++, $youbi++){
    $date = $ym . '-' . $day;

    if($today == $date) {
        $week .= '<td class="today">' . $day;
    } else {
        $week .= '<td>' . $day;
    }
    $week .= '</td>';

    if($youbi % 7 == 6 || $day == $day_count){
       
        if($day == $day_count){
            $week .= str_repeat('<td></td>', 6 - ($youbi % 7));
        }

        $weeks[] = '<tr>' . $week . '</tr>';

        $week = '';
    }

}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カレンダー</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
<style>
      .container {
        font-family: 'Noto Sans', sans-serif; /*--GoogleFontsを使用--*/
          margin-top: 80px;
      }
        h3 {
            margin-bottom: 30px;
        }
        th {
            height: 30px;
            text-align: center;
        }
        td {
            height: 100px;
        }
        .today {
            background: yellow; /*--日付が今日の場合は背景オレンジ--*/
        }
        th:nth-of-type(1), td:nth-of-type(1) { /*--日曜日は赤--*/
            color: red;
        }
        th:nth-of-type(7), td:nth-of-type(7) { /*--土曜日は青--*/
            color: blue;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3><a href="?ym=<?php echo $prev; ?>">&lt;</a><?php echo $html_title; ?><a href="?ym=<?php echo $next;?>">&gt;</a></h3>
    <table class="table table-bordered">
            <tr>
                <th>日</th>
                <th>月</th>
                <th>火</th>
                <th>水</th>
                <th>木</th>
                <th>金</th>
                <th>土</th>
            </tr>
            <?php
            foreach ($weeks as $week) {
                echo $week;
            }
        ?>
    </table>
    </div>
</body>
</html>